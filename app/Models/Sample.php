<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
/**
 * @method static self create(array $attributes = [])
 * @method bool save(array $options = [])
 */
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
