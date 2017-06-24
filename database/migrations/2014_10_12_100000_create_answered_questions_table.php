<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnsweredQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answered_questions', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('answered_question');
            $table->string('user_answer');
            $table->integer('answer_score');
            $table->integer('up_votes'); 
            $table->integer('down_votes');
            $table->increments('answer_id');
            $table->tinyInteger('answered');
            $table->string('email_address');
            $table->rememberToken();
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
        Schema::dropIfExists('answered_questions');
    }
}
