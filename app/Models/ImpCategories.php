<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpCategories extends Model
{
    use HasFactory;

    public function Category() {

        return $this->belongsTo(Category::class ,'cat_id' ,'id');
    }

}
