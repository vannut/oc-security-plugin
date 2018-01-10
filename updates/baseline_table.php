<?php

namespace Vannut\Security\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vannut_secops_baseline', function ($table) {
            $table->string('hash');
            $table->string('path');
            $table->string('path_hash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vannut_secops_baseline');
    }
}