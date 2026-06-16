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
        Schema::create('coverage_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coverage_type')->default('wireless'); // fiber | wireless
            $table->string('node')->nullable();                    // nodo o torre
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coverage_zones');
    }
};
