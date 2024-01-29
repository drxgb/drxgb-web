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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
			$table->string('title');
			$table->string('slug');
			$table->string('page')->nullable();
			$table->text('description')->nullable();
			$table->decimal('price');
			$table->boolean('active');
			$table->foreignId('category_id')->constrained()->nullable();
			$table->foreignId('cover_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
