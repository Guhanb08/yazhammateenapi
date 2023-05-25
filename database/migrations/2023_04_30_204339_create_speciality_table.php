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
        Schema::create('speciality', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->text('slug')->nullable();
            $table->text('brief')->nullable();
            $table->string('icon')->nullable();
            $table->integer('orderby')->nullable();
            $table->string('status')->default('Inactive');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speciality');
    }
};
