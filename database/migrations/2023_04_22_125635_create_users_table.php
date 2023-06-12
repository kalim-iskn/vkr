<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login', 20)->unique();
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic')->nullable();
            $table->boolean('sex')->nullable();
            $table->date("birthday")->nullable();
            $table->string("class")->nullable();

            $table->unsignedBigInteger("school_id")
                ->nullable();
            $table->foreign("school_id")
                ->references("id")
                ->on("schools");

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
};
