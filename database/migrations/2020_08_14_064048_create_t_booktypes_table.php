<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBooktypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_booktypes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('BookTypeId');
            $table->string('BookType',30)->unique();
            $table->timestamps();
        });


        /*Default value insert*/
        DB::table('t_booktypes')->insert([
            ['BookTypeId' => '1','BookType' => 'Hard Copy'],
            ['BookTypeId' => '2','BookType' => 'Soft copy']
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_booktypes');
    }
}
