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
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->uuid('division_id')->nullable();
            $table->string('position');
            $table->timestamps();

            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');

            $table->index('name');
            $table->index('division_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
