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
        Schema::create('product_files', function (Blueprint $table) : void
		{
            $table->id();
			$table->string('name');
			$table->string('extension', 8)->nullable();
			$table->decimal('size')->nullable();
			$table->string('file_path')->nullable();
			$table->foreignId('version_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('product_files');
    }
};
