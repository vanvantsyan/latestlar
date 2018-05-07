<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class GeneratedSeo extends Base
{
    use Cachable;
    protected $table = 'generated_seo';
    protected $guarded = [];

    public $timestamps = false;

}
