<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')
                ->default(0);
            $table->boolean('is_active')
                ->default(1);
            $table->boolean('star')
                ->default(0);
            $table->string('name');
            $table->string('call')
                ->nullable();
            $table->text('description')
                ->nullable();
            $table->text('short_description')
                ->nullable();
            $table->string('video')
                ->nullable();
            $table->string('slug');
            $table->dateTime('published_at')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
