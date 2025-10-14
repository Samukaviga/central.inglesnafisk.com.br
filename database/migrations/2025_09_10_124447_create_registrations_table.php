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
        Schema::create('registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name', 150)->nullable();
            $table->string('name', 150)->nullable();
            $table->string('email', 120)->nullable();
            $table->string('mobile_phone', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedBigInteger('age')->nullable();
            $table->string('gender', 150)->nullable();
            $table->string('course', 60)->nullable();
            $table->string('status', 60)->nullable();
            $table->string('city', 60)->nullable();

            $table->string('lead_source')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('gclid')->nullable();
            $table->string('fbclid')->nullable();
            $table->string('msclkid')->nullable();
            $table->string('referrer')->nullable();
            $table->string('landing_page')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
