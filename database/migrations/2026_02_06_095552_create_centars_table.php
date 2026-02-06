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
        Schema::create('centars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ashon_id')->default(1);
            $table->string('title');
            $table->string('address');
            $table->timestamps();

            $table->foreign('ashon_id')->references('id')->on('ashons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centars');
    }
};
