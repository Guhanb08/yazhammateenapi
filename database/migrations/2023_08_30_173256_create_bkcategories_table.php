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
        Schema::create('bkcategories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('Active');
            $table->text('slug')->nullable();
            $table->text('image')->nullable();
            $table->string('bookflag')->default('No');
            $table->text('brief')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('bkcategories')->onDelete('cascade');
            $table->integer('category_id')->nullable();
            $table->integer('subcategory_id')->nullable();
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
        Schema::dropIfExists('bkcategories');
    }
};
