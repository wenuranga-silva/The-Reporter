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
        Schema::create('post_images', function (Blueprint $table) {
            $table->bigInteger('post_id');
            $table->string('image_id');
            $table->text('image');
            $table->string('caption')->nullable();
            $table->text('copyright_link')->nullable();
            $table->string('copyright_text')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->primary(['post_id' ,'image_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_images');
    }
};
