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
        Schema::create('file_extension_platform', function (Blueprint $table) : void
		{
			$table->foreignId('file_extension_id')->constrained();
			$table->foreignId('platform_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('file_extension_platform');
    }
};
