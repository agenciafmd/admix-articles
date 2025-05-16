<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', static function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')
                ->unsigned()
                ->index()
                ->default(1);
            $table->boolean('star')
                ->default(0);
            $table->string('name');
            $table->string('author')
                ->nullable();
            $table->string('call')
                ->nullable();
            $table->text('short_description')
                ->nullable();
            $table->string('video')
                ->nullable();
            $table->text('description')
                ->nullable();
            $table->dateTime('published_at')
                ->nullable();
            $table->string('slug')
                ->unique()
                ->index();
            $table->integer('sort')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
