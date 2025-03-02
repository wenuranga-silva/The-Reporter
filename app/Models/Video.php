<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Video extends Model
{
    use HasFactory, LogsActivity;

    //// only for deleting & updating
    protected static $recordEvents = ['deleted', 'updated'];

    /// create a log for News
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['url', 'id'])
            ->setDescriptionForEvent(fn (string $eventName) => " {$eventName} by " . Auth::user()->id)
            ->useLogName('video')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    /// create video url
    public function getVideoUrlAttribute() {

        $url = $this->url;
        if (strpos($url, 'www.youtube.com/watch')) {

            $url = str_replace('watch?v=', 'embed/', $url);
        }

        return $url;
    }

    //// format date
    /// customize date
    public function getFormattedDateAttribute()
    {

        return Carbon::parse($this->created_at)->format('F d, Y');
    }

    //// remove tags in description
    public function getCleanDescAttribute() {

        return strip_tags($this->description);
    }

    public function News()
    {

        return $this->belongsTo(News::class, 'post_id', 'id');
    }

    public function Tags()
    {

        return $this->hasMany(VideoTag::class, 'video_id', 'id');
    }

    public function Author()
    {

        return $this->belongsTo(User::class, 'author', 'id');
    }
}
