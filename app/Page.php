<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    
    use SoftDeletes;

    protected $dates = ['deleted_at'];
   
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function contents()
    {
        return $this->hasMany('App\Content');
    }

    public function title()
    {
        return $this->contents()->where('lang','en')->first()->title;
    }
    /*
        public function getPublishAtAttribute($value)
        {
            return !is_null($value) ? Carbon::parse($value)->toDateString() : NULL;
        }

        public function getUnpublishAtAttribute($value)
        {
            return !is_null($value) ? Carbon::parse($value)->toDateString() : NULL;
        }
    */
    public function setPublishAtAttribute($value)
    {

        $this->attributes['publish_at'] =  $value ? Carbon::parse($value)->startOfDay() : NULL;

    }

    public function setUnpublishAtAttribute($value)
    {

        $this->attributes['unpublish_at'] = $value ? Carbon::parse($value)->endOfDay() : NULL;

    }
   
}
