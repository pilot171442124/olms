<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBookaccesstypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_bookaccesstype', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('BookAccessTypeId');
            $table->string('BookAccessType',30)->unique();
            $table->timestamps();
        });

        /*Default value insert*/
        DB::table('t_bookaccesstype')->insert([
            ['BookAccessTypeId' => '1', 'BookAccessType'=>'Public'],
            ['BookAccessTypeId' => '2', 'BookAccessType'=>'Private']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_bookaccesstype');
    }
}
