<?php

namespace Vannut\Security\Classes;

use Vannut\Security\Exceptions\ConfigException;
use Vannut\Security\Classes\Timer;
use Vannut\Security\Models\FsCrawlerRun;
use Vannut\Security\Models\FsCrawlerAnomaly;
use Vannut\Security\Notifications\BaseLineCreated;
use Vannut\Security\Notifications\AnomalyDetected;
use Symfony\Component\Finder\Finder;
use DB;

/**
 * This is the fileSystem crawler to detect changes
 */
class Crawler
{

    protected $config;

    // hashing algo for the file content hash
    protected $hashingAlgo = 'sha256';

    // notifiable
    protected $notifier;

    public function __construct()
    {
        $this->notifier = new Notifier;
        $this->config = [
            // Directories to exclude from the crawler
            'exclude_dirs' => [
                './vendor',
            ],

            // for debug purposes just using the crawler
            // directory, normally you would use: base_path()
            // testing: __DIR__
            'base_dir' => __DIR__,

        ];
    }


    /**
     * Creates a hash signature of a files content
     *
     * @param string $path
     * @return string the Hash
     */
    private function createHashFromFile($path)
    {
        return hash_file($this->hashingAlgo, $path);
    }

    /**
     * Creates a new baseline based on the given include_directories
     *
     * @todo log file
     * @return void
     */
    public function createBaseline()
    {
        // setup things
        $timer = new Timer;
        $this->checkConfig();

        // load the current state
        $current = $this->getCurrentFilesWithHashes();

        // Store current state as baseline in database
        DB::transaction(function () use ($current) {
            // remove the old baseline.
            DB::table('vannut_secops_baseline')->delete();

            // insert the new baseline.
            DB::table('vannut_secops_baseline')->insert($current->toArray());
        });

        // we are done with the creation of the baseline
        // so time stops here.
        $timer->stop();

        // TODO: write this crawler run into the logs.

        // fire baseline created event, with the log file
        $this->notifier->notify(new BaseLineCreated($current->count(), $timer->diff()));

        // debugging...
        echo "Done in {$timer->diff()} seconds<br>";
        echo "Found {$current->count()} files<br>";
        echo "<pre>";
        print_r($current->toArray());
        return '==== EINDE ====';
    }

    /**
     * Gets the current files in the instance directory
     * and transforms them to a proper comparable array
     *
     * @return void
     */
    public function getCurrentFilesWithHashes()
    {
        $directory = $this->config['base_dir'];
        $exclude = collect($this->config['exclude_dirs'])
            ->transform(function ($item) {
                return $item;
            });

        // Finding all the files
        $finder = new Finder();
        $finder->ignoreUnreadableDirs()
            ->in($directory)
            ->exclude($exclude->toArray())
            ->files();

        return collect($finder)
            ->transform(function ($item) {
                $hash = $this->createHashFromFile($item);
                return [
                    'path' => './'.$item->getRelativePathname(),
                    'hash' => $hash,
                    'path_hash' => md5('./'.$item->getRelativePathname())
                ];
            })
            ->keyBy('path_hash');
    }

    /**
     * Compare the current state of the filesystem
     * with the baseline stored in the database.
     *
     * @todo Log file
     * @return void
     */
    public function compareFilesystem()
    {
        $timer = new Timer;
        $this->checkConfig();

        // baseline ophalen
        $baseline = DB::table('vannut_secops_baseline')->select(['path','hash', 'path_hash'])
            ->get()
            ->keyBy('path_hash')
            ->transform(function ($item) {
                return (array) $item;
            });

        $currentFiles = $this->getCurrentFilesWithHashes();

        // traverse through current files and see what is happening
        $currentFiles->transform(function ($item) use ($baseline) {
            // not found in baseline... then we have an addition..
            if (!$baseline->has($item['path_hash'])) {
                $status = 'file-added';
            // the content hashes are not the same...
            } elseif ($baseline->get($item['path_hash'])['hash']     !== $item['hash']) {
                $status = 'content-changed';
            } else {
                $status = 'no-change';
            }
            $item['type'] = $status;

            return (array) $item;
        });

        // split out the different nof statusses
        $changed = $currentFiles->filter(function ($item) {
            return $item['type'] == 'content-changed';
        });
        $noChange = $currentFiles->filter(function ($item) {
            return $item['type'] == 'no-change';
        });
        $newFile = $currentFiles->filter(function ($item) {
            return $item['type'] == 'file-added';
        });

        // What about deletions?
        $deleted = $baseline->reject(function ($item) use ($currentFiles) {
            return $currentFiles->has($item['path_hash']);
        })
        ->transform(function ($item) {
            $item['type'] = 'file-deleted';
            return $item;
        });


        $timer->stop();

        // Sent notifications
        if ($newFile->count() >0 || $changed->count() >0 || $deleted->count() >0) {
            $this->notifier->notify(new AnomalyDetected([
                'changed' => $changed,
                'newFiles' => $newFile,
                'noChange' => $noChange,
                'deleted' => $deleted,
                'elapsedTime' => $timer->diff()
            ]));
        }


        // Creating a crawler Run
        $run = FsCrawlerRun::create([
            'started_at' => $timer->startedAtCarbon(),
            'elapsed_ms' => 0
        ]);

        // Store changes
        $storable = $currentFiles->merge($deleted)->reject(function ($item) {
            return $item['type'] === 'no-change';
        })
        ->transform(function ($item) use ($run) {
            unset($item['hash']);
            unset($item['path_hash']);
            $item['run_id'] = $run->id;

            return $item;
        });

        $an = FsCrawlerAnomaly::insert($storable->values()->toArray());


        // debugging...
        echo "Done in {$timer->diff()} seconds<br>";
        echo "<pre>";
        echo 'Changed: '; print_r($changed->count()); echo "<br>";
        echo 'NewFile: '; print_r($newFile->count()); echo "<br>";
        echo 'Deleted: '; print_r($deleted->count()); echo "<br>";
        echo 'no change: '; print_r($noChange->count()); echo "<br>";
        print_r($currentFiles->toArray());

        return '==== EINDE ====';
    }

    /**
     * Checks the given configuration and throws an exception if
     * something is wrong
     * @throws ConfigException
     * @TODO: how to restrict the include dirs, to everything BELOW the base path...
     * @return void
     */
    private function checkConfig()
    {
        //throw new ConfigException('[crawler] Incorrect configuration');
        return null;
    }
}
