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
            $table->string('name');
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status')->default('guest');
            $table->string('user_id')->nullable();
            $table->string('referee_id')->nullable();
            $table->string('operationstaff_id')->nullable();
            $table->string('admin_id')->nullable();
            $table->string('role_id')->nullable();
            $table->bigInteger('coin_amount')->nullable();
            $table->string('remark')->nullable();
            $table->bigInteger('commision')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('users');
    }
}
