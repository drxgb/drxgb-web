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
        Schema::create('versions', function (Blueprint $table) : void
		{
            $table->id();
			$table->integer('number');
			$table->date('release_date');
			$table->text('release_notes')->nullable();
			$table->text('fixes')->nullable();
			$table->foreignId('product_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('versions');
    }
};
