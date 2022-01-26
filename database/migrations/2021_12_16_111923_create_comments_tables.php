<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentator');
            $table->morphs('commentable');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
            $table->longText('original_text');
            $table->longText('text');
            $table->json('extra')->nullable();
            $table->timestamps();
        });

        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentator');
            $table->foreignId('comment_id')->references('id')->on('comments')->cascadeOnDelete();
            $table->string('reaction')->collation('utf8mb4_bin');
            $table->timestamps();
        });

        Schema::create('comment_notification_opt_outs', function(Blueprint $table) {
            $table->morphs('commentator', 'commentator_opt_outs');
            $table->morphs('commentable', 'opt_outs');
            $table->timestamps();
        });
    }
};
