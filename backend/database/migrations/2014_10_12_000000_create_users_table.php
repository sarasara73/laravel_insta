<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->id();
            $table->string('name'); //varchar lengh 255
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); //utc
            $table->string('avatar',50)->nullable();
            $table->string('password');
            $table->string('introduction',100)->nullable();
            $table->unsignedBigInteger('role_id')
                    ->default(2)
                    ->comment('1:admin 2:user');
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
        Schema::dropIfExists('users');
    }
}
