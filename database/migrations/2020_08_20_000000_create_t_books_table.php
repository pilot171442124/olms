<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_books', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('BookId');            
            $table->integer('DepartmentId')->length(10)->unsigned();
            $table->integer('BookTypeId')->length(10)->unsigned();
            $table->string('BookName',50)->unique();
            $table->string('AuthorName',50);
            $table->integer('TotalCopy')->default(0);
            $table->integer('BookAccessTypeId')->length(10)->unsigned();;
            $table->string('BookURL',150)->nullable();
            $table->string('Remarks',150)->nullable();
            $table->timestamps();
            $table->foreign('BookTypeId')->references('BookTypeId')->on('t_booktypes');
            $table->foreign('BookAccessTypeId')->references('BookAccessTypeId')->on('t_bookaccesstype');
            $table->foreign('DepartmentId')->references('DepartmentId')->on('t_department');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_books');
    }
}
