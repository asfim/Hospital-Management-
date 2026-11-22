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
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'title')) {
                $table->string('title')->after('id');
            }
            if (!Schema::hasColumn('services', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }
            if (!Schema::hasColumn('services', 'tagline')) {
                $table->string('tagline')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('services', 'badge')) {
                $table->string('badge')->nullable()->after('tagline');
            }
            if (!Schema::hasColumn('services', 'badge_color')) {
                $table->string('badge_color')->default('teal')->after('badge');
            }
            if (!Schema::hasColumn('services', 'icon')) {
                $table->string('icon')->default('fa-solid fa-hospital')->after('badge_color');
            }
            if (!Schema::hasColumn('services', 'icon_color')) {
                $table->string('icon_color')->default('text-teal')->after('icon');
            }
            if (!Schema::hasColumn('services', 'gradient')) {
                $table->string('gradient')->nullable()->after('icon_color');
            }
            if (!Schema::hasColumn('services', 'short_description')) {
                $table->text('short_description')->nullable()->after('gradient');
            }
            if (!Schema::hasColumn('services', 'description')) {
                $table->longText('description')->nullable()->after('short_description');
            }
            if (!Schema::hasColumn('services', 'points')) {
                $table->json('points')->nullable()->after('description');
            }
            if (!Schema::hasColumn('services', 'contact_number')) {
                $table->string('contact_number')->nullable()->after('points');
            }
            if (!Schema::hasColumn('services', 'emergency_button_text')) {
                $table->string('emergency_button_text')->nullable()->after('contact_number');
            }
            if (!Schema::hasColumn('services', 'emergency_button_link')) {
                $table->string('emergency_button_link')->nullable()->after('emergency_button_text');
            }
            if (!Schema::hasColumn('services', 'image')) {
                $table->string('image')->nullable()->after('emergency_button_link');
            }
            if (!Schema::hasColumn('services', 'status')) {
                $table->boolean('status')->default(true)->after('image');
            }
            if (!Schema::hasColumn('services', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'slug', 'tagline', 'badge', 'badge_color',
                'icon', 'icon_color', 'gradient', 'short_description',
                'description', 'points', 'contact_number',
                'emergency_button_text', 'emergency_button_link',
                'image', 'status', 'sort_order'
            ]);
        });
    }
};
