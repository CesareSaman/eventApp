<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    protected $guarded = ['category_id'];
    public $timestamps = false;

    /**
     * All events associated with the category
     *
     */
    public function events()
    {
        return $this->belongsToMany(Event::class,'category_event', 'category_id', 'event_id');
    }
}
