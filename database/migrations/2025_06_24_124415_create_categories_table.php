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
        Schema::create('categories', function (Blueprint $table) {
       $table->id();
            
            // الحقول المترجمة (باستخدام JSON لاستيعاب الترجمات)
            $table->json('name'); // سيحتوي على {'ar': 'الاسم العربي', 'he': 'الاسم العبري'}
            
            // الحقول العادية
            $table->string('slug')->unique(); // نسخة URL-friendly من الاسم
            $table->string('image')->nullable(); // مسار صورة التصنيف
            $table->boolean('status')->default(true); // حالة التصنيف (مفعل/غير مفعل)
            $table->unsignedBigInteger('parent_id')->nullable(); // للتصنيفات الفرعية
            
            // التوقيتات التلقائية
            $table->timestamps();
            
            // مفاتيح خارجية
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
