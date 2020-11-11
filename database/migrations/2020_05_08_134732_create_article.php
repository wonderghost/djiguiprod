<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->string('slug')->primary();
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->string('author');
            $table->foreign('author')
                ->references('email')
                ->on('users');
                
            $table->string('id_sub_category');
            $table->foreign('id_sub_category')
                ->references('slug')
                ->on('sub_category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
