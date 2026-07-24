<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_customizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('profiles');
            $table->foreignId('theme_id')->constrained('themes');
            $table->string('primary_color')->default('#6366f1');
            $table->string('secondary_color')->default('#8b5cf6');
            $table->string('accent_color')->default('#06b6d4');
            $table->string('background_color')->default('#0f172a');
            $table->string('text_color')->default('#e2e8f0');
            $table->string('font_family')->default('Inter');
            $table->string('font_size')->default('16px');
            $table->string('border_radius')->default('0.75rem');
            $table->string('layout_width')->default('1200px');
            $table->string('header_style')->default('standard');
            $table->string('footer_style')->default('standard');
            $table->text('custom_css')->nullable();
            $table->text('custom_js')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_customizations');
    }
};