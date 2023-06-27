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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('iso3',3)->nullable();
            $table->string('numeric_code',3)->nullable();
            $table->string('iso2',2)->nullable();
            $table->string('phonecode',255)->nullable();
            $table->string('capital',255)->nullable();
            $table->string('currency',255)->nullable();
            $table->string('currency_name',255)->nullable();
            $table->string('currency_symbol',255)->nullable();
            $table->string('tld',255)->nullable();
            $table->string('native',255)->nullable();
            $table->string('region',255)->nullable();
            $table->string('subregion',255)->nullable();
            $table->text('timezones')->nullable();
            $table->text('translations')->nullable();
            $table->decimal('latitude',11,8)->nullable();
            $table->decimal('longitude',11,8)->nullable();
            $table->string('emoji',191)->nullable();
            $table->string('emojiU',191)->nullable();
            $table->integer('flag')->default(1);
            $table->string('wikiDataId')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
