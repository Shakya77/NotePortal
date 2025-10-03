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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            
            $table->string('topic');
            $table->string('sub_topic')->nullable();
            $table->longText('content');
            $table->json('components_used')->nullable();
            $table->integer('component_count')->default(0);
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();

            $table->index('topic');
            $table->index('sub_topic');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
