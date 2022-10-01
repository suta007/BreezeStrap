<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->string('name', 200);
            $table->string('email')->unique()->nullable();
            $table->string('type', 50)->nullable()->default('user');
            $table->timestamp('last_login')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    //  DB::table('users')->insert(['cid'=>'1559900082749','password' => Hash::make('User@123'),'prefix' => 'Mr.','firstname'=>'Kritsadapong','lastname'=>'Suta', 'email' => 'Mr.Suta@gmail.go.th','sex'=>'male','school_id'=>0]);
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
