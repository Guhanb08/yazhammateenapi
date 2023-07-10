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
        Schema::create('tkcategories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('Active');
            $table->text('slug')->nullable();
            $table->text('brief')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('tkcategories')->onDelete('cascade');
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('category_id')->nullable();
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
        Schema::dropIfExists('tkcategories');
    }
};
