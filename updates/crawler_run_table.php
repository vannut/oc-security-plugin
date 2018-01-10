<?php

namespace Vannut\Security\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CrawlerRunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vannut_secops_crawler_run', function ($table) {
            $table->increments('id');
            $table->timestamp('started_at');
            $table->integer('elapsed_ms');
            $table->string('init_by')->default('j');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vannut_secops_crawler_run');
    }
}