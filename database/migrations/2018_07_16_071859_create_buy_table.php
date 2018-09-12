<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('registration',255);
            $table->string('name',255);
            $table->string('idCard',255);
            $table->mediumInteger('haveHouse');
            $table->string('file',255);
            $table->mediumInteger('marriage');
            $table->string('pay',25);
            $table->string('loan',25);
            $table->string('down',25);
            $table->string('household',255);
            $table->mediumInteger('status');
            $table->string('sale',25);
            $table->string('area',25);
            $table->string('phone',15);
            $table->string('address',255);
            $table->string('email',255);
            $table->mediumInteger('parking');
            $table->integer('child');
            $table->integer('other');
            $table->integer('firstTrial');
            $table->integer('finalTrial');
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
        Schema::dropIfExists('buy');
    }
}
