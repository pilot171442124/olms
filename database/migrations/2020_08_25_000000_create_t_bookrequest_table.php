<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBookrequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_bookrequest', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('RequestId');
            $table->bigInteger('UserId')->length(20)->unsigned();
            $table->date('RequestDate');
            $table->string('RequestCode',20);
            $table->integer('BookId')->length(10)->unsigned();
            $table->integer('RequestCopy')->default(1);
            $table->string('Status',20);
            $table->date('CancelDate')->nullable();
            $table->bigInteger('CancelUserId')->length(20)->unsigned()->nullable();
            $table->date('IssueDate')->nullable();
            $table->bigInteger('IssueUserId')->length(20)->unsigned()->nullable();
            $table->date('ReceiveDate')->nullable();
            $table->bigInteger('ReceiveUserId')->length(20)->unsigned()->nullable();
			
            $table->date('RetSMSDate')->nullable();
            $table->integer('FirstSMSDays')->length(10)->unsigned()->default(0);
            $table->date('FineFirstSMSDate')->nullable();
            $table->integer('FineSMSCount')->length(10)->unsigned()->default(0);
            $table->integer('FineAmount')->length(10)->unsigned()->default(0);
            $table->integer('FinePaid')->length(10)->unsigned()->default(0);

            $table->timestamps();
            $table->foreign('UserId')->references('id')->on('users');
            $table->foreign('BookId')->references('BookId')->on('t_books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_bookrequest');
    }
}
