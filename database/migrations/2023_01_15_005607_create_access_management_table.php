<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('designation_id');
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('action_id');
            $table->boolean('can_access')->default(false);

            $table->foreign('designation_id')->references('id')->on('designations');
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->foreign('action_id')->references('id')->on('actions');

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
        Schema::dropIfExists('access_management');
    }
}
