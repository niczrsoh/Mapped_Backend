<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Sample extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'samples';

    protected $fillable = [
        'title',
        'content',
        'created_at',
    ];
}
