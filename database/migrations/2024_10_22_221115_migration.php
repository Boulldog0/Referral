<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->integer('referred_id');
            $table->integer('referrer_id');
            $table->decimal('referrer_total_earn');
            $table->boolean('created_via_link');
            $table->timestamps();
        });

        Schema::create('referrals_registrations', function(Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('referrals_transactions', function(Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('command_id');
            $table->integer('total_amount');
            $table->integer('referrer_id');
            $table->integer('percentage_given');
            $table->integer('given_amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('referrals_registrations');
        Schema::dropIfExists('referrals_transactions');
    }
};