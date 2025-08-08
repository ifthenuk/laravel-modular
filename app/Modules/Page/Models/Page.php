<?php

namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        // Add your fillable fields here
    ];

    protected $guarded = [
        // Add your guarded fields here
    ];
}

