<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('products', function (Blueprint $table) : void
		{
            $table->id();
			$table->string('title');
			$table->string('slug');
			$table->string('page')->nullable();
			$table->longText('description')->nullable();
			$table->decimal('price');
			$table->boolean('active');
			$table->bigInteger('cover_index', unsigned: true)->nullable();
			$table->bigInteger('download_count', unsigned: true)->default(0);
			$table->foreignId('category_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('products');
    }
};
