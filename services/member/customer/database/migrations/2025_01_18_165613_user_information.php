<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'customer';
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_information', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('name')->nullable();
            $table->string('nickname')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('occupation')->nullable();
            $table->timestamps();

            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_information');
    }
};
