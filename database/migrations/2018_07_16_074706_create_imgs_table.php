<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imgs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buyId');
            $table->string('idCardfront',255);
            $table->string('idCardback',255);
            $table->string('accountBook',255);
            $table->string('accountBookpersonal',255);
            // json数组 住房情况
            $table->string('housingSituation',255);
            // 个人征信证明
            $table->string('personalCredit',255);
            // 资金冻结
            $table->string('fundFreezing',255);
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
        Schema::dropIfExists('imgs');
    }
}
