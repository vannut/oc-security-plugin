<?php

namespace Vannut\Security\Models;

use Model;

class FsCrawlerRun extends Model
{
    public $timestamps = false;

    protected $fillable = ['started_at','elapsed_ms'];

    protected $table = 'vannut_secops_crawler_run';

}
