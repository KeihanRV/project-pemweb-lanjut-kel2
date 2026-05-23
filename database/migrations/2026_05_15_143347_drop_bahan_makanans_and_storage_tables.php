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
        Schema::dropIfExists('bahan_makanans');
        Schema::dropIfExists('kitchen_storage_ingredient');
        Schema::dropIfExists('kitchen_storage');
        // Schema::dropIfExists('kitchen_ingredient');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
