<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class GeneratedSeo extends Base
{
    use Cachable;
    protected $table = 'generated_seo';
    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
    ];

    public $timestamps = false;
    
    public function getTempParamsAttribute()
    {
        return [
            'breakpoint-date' => optional($this->date)->format('Y-m-d'),  
        ];
    }

}
