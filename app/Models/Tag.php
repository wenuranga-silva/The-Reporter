<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Tag extends Model
{
    use HasFactory ,LogsActivity;

    //// only for deleting & updating
    protected static $recordEvents = ['deleted' ,'updated'];

    /// create a log for tags
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name'])
        ->useLogName('tag');
        // Chain fluent methods for configuration options
    }
}
