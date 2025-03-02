<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PostImage extends Model
{
    use HasFactory ,LogsActivity;

    //// only for deleting & updating
    protected static $recordEvents = ['deleted', 'updated'];

    /// create a log for post images
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['image_id' ,'post_id'])
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName} by " . Auth::user()->id)
            ->useLogName('postImage')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
