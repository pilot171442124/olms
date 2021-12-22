<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_post', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('PostId');
            $table->dateTime('PostDate');
            $table->string('PostTitle',100);
            $table->text('Post');
            $table->string('userrole',20); /*Post for which type user. When All then this post for admin,teacher and student OR mentioned Admin/Teacher/Student*/
            $table->bigInteger('UserId')->length(20)->unsigned();
            $table->timestamps();
            $table->foreign('UserId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_post');
    }
}
