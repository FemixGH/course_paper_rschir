<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Создаёт поле id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('name'); // Поле для имени пользователя
            $table->string('email')->unique(); // Поле для email с уникальным значением
            $table->timestamp('email_verified_at')->nullable(); // Поле для подтверждения email
            $table->string('password'); // Поле для пароля
            $table->rememberToken(); // Поле для "запомнить меня"
            $table->timestamps(); // Поля created_at и updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('users'); // Удаление таблицы при откате миграции
    }
};
