<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title','200');
            $table->string('client','250');
            $table->date('date');
            $table->string('contribution')->nullable();
            $table->longText('description');
            $table->string('link1','250')->nullable();
            $table->string('link2','250')->nullable();
            $table->string('category','100')->nullable();
            $table->String('image')->nullable();
            $table->text('keyword')->nullable();
            $table->integer('views')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
