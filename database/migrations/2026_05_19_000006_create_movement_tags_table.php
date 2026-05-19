<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movement_tags', function (Blueprint $table) {
            $table->foreignId('movement_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['movement_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movement_tags');
    }
};
