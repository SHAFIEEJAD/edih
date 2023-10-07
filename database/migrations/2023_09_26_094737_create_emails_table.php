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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->string('title');
            $table->string('subject');
            $table->longText('body');
            $table->boolean('is_correct');            
            $table->boolean('active')->default(true);
            $table->json('sender_address')->nullable();
            $table->json('cc_addresses_list')->nullable();      
            $table->unsignedBigInteger('created_by');
            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
