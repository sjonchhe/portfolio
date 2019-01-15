<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('email');
            $table->date('dob')->nullable();
            $table->text('about')->nullable();
            $table->string('image')->nullable();
            $table->string('coverimage')->nullable();
            $table->string('cv')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('portfolios');
    }
}
