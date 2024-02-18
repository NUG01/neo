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
        Schema::create('step_field_values', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->foreignId('step_field_id');
            $table->foreignId('participation_id');
            $table->timestamps();

            $table->foreign('step_field_id')->references('id')->on('step_fields')->onDelete('cascade');
            $table->foreign('participation_id')->references('id')->on('participations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('step_field_values');
    }
};
