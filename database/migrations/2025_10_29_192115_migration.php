<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals_packages_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_package_id');
            $table->integer('applied_amount')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals_packages_links');
    }
};