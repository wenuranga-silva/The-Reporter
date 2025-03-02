<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('video_tags', function (Blueprint $table) {
            $table->bigInteger('video_id');
            $table->bigInteger('tag_id');
            $table->timestamps();
            $table->primary(array('video_id' ,'tag_id'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_tags');
    }
};
