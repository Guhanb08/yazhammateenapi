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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('brief')->nullable();
            $table->text('imageone')->nullable();
            $table->text('imagetwo')->nullable();
            $table->text('imagethree')->nullable();
            $table->text('imagefour')->nullable();
            $table->text('audioone')->nullable();
            $table->text('audiotwo')->nullable();
            $table->text('description')->nullable();
            $table->integer('categoryid')->nullable();
            $table->integer('subcategoryid')->nullable();
            $table->integer('childcategoryid')->nullable();
            $table->text('slug')->nullable();
            $table->string('author')->nullable();
            $table->string('specname')->nullable();
            $table->dateTime('articledate')->nullable();
            $table->integer('orderby')->nullable();
            $table->string('status')->default('Inactive');
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('news_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->primary(['news_id', 'category_id']);
        });


        Schema::create('news_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('tag_id');
            $table->integer('orderby')->nullable();
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->primary(['news_id', 'tag_id']);
        });


        Schema::create('news_speciality', function (Blueprint $table) {
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('speciality_id');
            $table->integer('orderby')->nullable();
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->foreign('speciality_id')->references('id')->on('speciality')->onDelete('cascade');
            $table->primary(['news_id', 'speciality_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
