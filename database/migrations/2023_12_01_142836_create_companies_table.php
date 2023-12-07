<?php

use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('state')->default(Company::STATE_CREATED);
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('cover')->nullable();
            $table->text('qrcode')->nullable()->unique();
            $table->text('theme')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_title')->nullable();
            $table->string('email')->nullable();
            $table->string('email_title')->nullable();
            $table->string('website')->nullable();
            $table->string('website_title')->nullable();
            $table->string('address', 511)->nullable();
            $table->text('address_link')->nullable();
            $table->string('address_link_title')->nullable();
            $table->string('survey_link')->nullable();
            $table->string('survey_title')->nullable();
            $table->string('banks_title')->nullable();
            $table->string('platforms_title')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
