<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_department', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('DepartmentId');
            $table->string('Department',30)->unique();
            $table->timestamps();
        });

         /*Default value insert*/
        DB::table('t_department')->insert([
            ['DepartmentId' => '1','Department' => 'CSE'],
            ['DepartmentId' => '2','Department' => 'EEE']
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_department');
    }
}
