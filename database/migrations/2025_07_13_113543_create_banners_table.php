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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();         // العنوان متعدد اللغات
            $table->json('description')->nullable();   // الوصف متعدد اللغات
            $table->json('button_text')->nullable();   // نص الزر متعدد اللغات
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(1);     // 1=ظاهر، 0=مخفي
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
