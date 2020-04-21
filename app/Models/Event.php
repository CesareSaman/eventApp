<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'event_id';
    protected $guarded = ['event_id'];

    /**
     * All categories associated with the event
     *
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_event', 'event_id', 'category_id');
    }

    /**
     * The user associated with the event
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
