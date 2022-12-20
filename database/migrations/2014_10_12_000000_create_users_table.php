<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

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
                $table->increments('id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('name');
                $table->string('username')->unique();
                $table->string('gender');
                $table->string('email')->nullable();
                $table->string('staff_id');
                $table->unsignedBigInteger('department_id')->default(1);
                $table->unsignedBigInteger('designation_id')->default(1);
                $table->string('phone_number')->unique();
                $table->string('other_phone_number')->nullable();
                $table->string('address');
                $table->string('nin')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('image')->nullable();
                $table->string('password', 255)->default(Hash::make('12345678'));
                $table->integer('login_attempts')->default(0);
                $table->integer('otp_attempts')->default(0);
                $table->string('otp_code')->nullable();
                $table->string('is_verified')->default(true);
                $table->boolean('is_active')->default(true);
                $table->string('acc_changed_by')->nullable();
                $table->rememberToken()->nullable();
                $table->timestamps();
                $table->foreign('designation_id')->references('id')->on('designations');
                $table->foreign('department_id')->references('id')->on('departments');
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
