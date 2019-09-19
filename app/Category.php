<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    public $timestamps = true;

    public function users()
    {
        return $this->belongsToMany('App\Category', 'user_categories','category_id','user_id')->withPivot('created_at');
    }
}
