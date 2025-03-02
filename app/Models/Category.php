<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use HasFactory ,LogsActivity;

    //// only for deleting & updating
    protected static $recordEvents = ['deleted' ,'updated'];

    /// create a log for categories
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name'])
        ->useLogName('category');
        // Chain fluent methods for configuration options
    }

    public function Nav() {

        return $this->hasOne(Navigation::class ,'category_id' ,'id');
    }

    public function impCat() {

        return $this->hasOne(ImpCategories::class ,'cat_id' ,'id');
    }

    public function News() {

        return $this->hasMany(News::class ,'category_id' ,'id')->orderBy('created_at', 'desc');
    }
    
}
