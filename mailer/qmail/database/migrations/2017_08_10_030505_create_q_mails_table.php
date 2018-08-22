<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q_mails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->string('message');
            $table->string('description');
            $table->interger('creator_id');
            $table->interger('parent_id');
            $table->timestamps();
        });

        Schema::create('q_mail_verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('verification_code');
            $table->interger('user_id');
            $table->datetime('verification_date');
            $table->interger('status')->default(0);
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
        Schema::dropIfExists('q_mails');
    }
}
