<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTag extends Model
{
    use HasFactory;

    public function Tag() {

        return $this->belongsTo(Tag::class ,'tag_id' ,'id');
    }
}
