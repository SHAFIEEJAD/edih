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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->boolean('answer');
            $table->string('answer_guid', 36);
            $table->unsignedBigInteger('email_id'); 
            $table->foreign('email_id')->references('id')->on('emails');   
            $table->unsignedBigInteger('dep_id'); 
            $table->foreign('dep_id')->references('id')->on('departments');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
