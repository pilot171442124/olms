<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_status', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('Status',20);
            $table->smallInteger('SerialNo');
            $table->timestamps();
            $table->primary('Status');
        });


        /*Default value insert*/
        DB::table('t_status')->insert([
            ['Status' => 'Requested','SerialNo'=>1],
            ['Status' => 'Canceled','SerialNo'=>2],
            ['Status' => 'Accepted','SerialNo'=>3],
            ['Status' => 'Issued','SerialNo'=>4],
            ['Status' => 'Dateover','SerialNo'=>5],
            ['Status' => 'Returned','SerialNo'=>6]
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_status');
    }
}
