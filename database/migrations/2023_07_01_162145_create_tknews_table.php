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
        Schema::create('tknews', function (Blueprint $table) {
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


        Schema::create('tknews_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('news_id')->references('id')->on('tknews')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('tkcategories')->onDelete('cascade');
            $table->primary(['news_id', 'category_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tknews');
    }
};
