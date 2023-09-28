<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_adresses', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('email_id');
            $table->smallInteger('type');
            $table->string('address');
            $table->string('display_name');            
            $table->foreign('email_id')->references('id')->on('emails');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_adresses');
    }
};
