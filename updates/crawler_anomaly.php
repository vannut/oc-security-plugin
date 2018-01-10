<?php

namespace Vannut\Security\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CrawlerAnomaly extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vannut_secops_crawler_anomaly', function ($table) {
            $table->increments('id');
            $table->integer('run_id');
            $table->string('type');
            $table->string('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vannut_secops_crawler_anomaly');
    }
}