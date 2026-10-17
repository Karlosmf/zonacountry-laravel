<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_name')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ad_zones', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('dimensions_label');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ad_zone_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('headline');
            $table->string('subheadline')->nullable();
            $table->string('image_path')->nullable();
            $table->string('target_url');
            $table->string('color_theme')->default('emerald');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->unsignedBigInteger('impressions_count')->default(0);
            $table->unsignedBigInteger('clicks_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sector')->default('Autopista Santa Fe - Rosario');
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('badge_color')->default('emerald');
            $table->timestamps();
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_post_id')->nullable()->index();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content_html');
            $table->string('featured_image')->nullable();
            $table->json('countries_tags')->nullable();
            $table->text('whatsapp_copy')->nullable();
            $table->text('instagram_copy')->nullable();
            $table->string('seo_meta_title')->nullable();
            $table->string('seo_meta_description')->nullable();
            $table->boolean('generated_with_ai')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('classified_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_listing_id')->nullable()->index();
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category_name');
            $table->string('price_label')->default('Consultar');
            $table->text('description');
            $table->json('features')->nullable();
            $table->string('image_path')->nullable();
            $table->string('whatsapp_contact')->default('5493424878424');
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('vecinal_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->string('neighbor_name');
            $table->string('neighbor_phone')->nullable();
            $table->string('claim_type');
            $table->text('description');
            $table->string('status')->default('recibido');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vecinal_claims');
        Schema::dropIfExists('classified_listings');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('ad_zones');
        Schema::dropIfExists('sponsors');
    }
};
