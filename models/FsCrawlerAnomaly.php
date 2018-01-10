<?php

namespace Vannut\Security\Models;

use Model;

class FsCrawlerAnomaly extends Model
{
    public $timestamps = false;
    protected $fillable = ['type','path', 'run_id'];

    protected $table = 'vannut_secops_crawler_anomaly';

}
