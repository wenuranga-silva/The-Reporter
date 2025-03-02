<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use LakM\Comments\Concerns\Commentable;
use LakM\Comments\Contracts\CommentableContract;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class News extends Model implements CommentableContract
{
    use HasFactory ,LogsActivity ,Commentable;

    //// only for deleting & updating
    protected static $recordEvents = ['deleted', 'updated'];

    /// create a log for News
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title' ,'description' ,'id'])
            ->dontLogIfAttributesChangedOnly(['views'])
            ->useLogName('news')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => " {$eventName} by " . Auth::user()->id)
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    /// customize date
    public function getFormattedDateAttribute()
    {

        return Carbon::parse($this->created_at)->format('F d, Y');
    }

    /// calculate view count
    protected function calcViewCount($viewsCount) {

        if ($viewsCount >= 1000) {

            return number_format($viewsCount / 1000, 1) . 'k';
        } else {

            return $viewsCount;
        }
    }

    /// return view count
    public function getViewsCountAttribute() {

        return $this->calcViewCount($this->views);
    }

    /// return calculated reading time
    public function getReadingTimeAttribute() {

        return $this->calcReadingTime($this->description);
    }

    /// calculate reading time
    protected function calcReadingTime($desc) {

        $wordsPerMinute = 200;
        /// count number of words without html tags
        $wordCount = str_word_count(strip_tags($desc));

        return ceil($wordCount / $wordsPerMinute);
    }

    public function PostImage()
    {

        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    public function Tags()
    {

        return $this->hasMany(PostTag::class, 'post_id', 'id');
    }

    public function author()
    {

        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function Category() {

        return $this->belongsTo(Category::class ,'category_id' ,'id');
    }

    public function video() {

        return $this->hasOne(Video::class ,'post_id' ,'id');
    }
}
