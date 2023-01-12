<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
                $table->increments('id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('username')->unique();
                $table->string('staff_id');
                $table->unsignedBigInteger('department_id')->default(1);
                $table->unsignedBigInteger('designation_id')->default(1);
                $table->string('phone_number')->unique();
                $table->string('other_phone_number')->nullable();
                $table->string('email')->nullable();
                $table->string('gender');
                $table->string('address');
                $table->string('nin')->nullable();
                $table->string('tin_number')->nullable();
                $table->string('nssf_number')->nullable();
                $table->string('next_of_kin')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('image')->nullable();
                $table->string('password', 255)->default(Hash::make('12345678'));
                $table->integer('login_attempts')->default(0);
                $table->integer('otp_attempts')->default(0);
                $table->string('otp_code')->nullable();
                $table->string('is_verified')->default(true);
                $table->boolean('is_active')->default(true);
                $table->boolean('is_deleted')->default(false);
                $table->string('created_by')->nullable();
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('staff');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
