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
        Schema::create('campaign_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained();
            $table->foreignId('term_id')->constrained();
            $table->dateTime('monetization_timestamp')->comment('The date and time of the monetization event');
            $table->decimal('revenue', 20, 5)->comment('The revenue generated by the monetization event');
            $table->integer('hours')->nullable()->comment('Hour of the monetization event timestamp, will be used for hourly aggregation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_stats');
    }
};
