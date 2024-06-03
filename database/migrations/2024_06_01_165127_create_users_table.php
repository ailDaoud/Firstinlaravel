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
            $table->id();
            $table->string('first_name');//->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->integer('phone_number')->unique()->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('verify_email')->default(0);
            $table->boolean('verify_number')->default(0);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
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
