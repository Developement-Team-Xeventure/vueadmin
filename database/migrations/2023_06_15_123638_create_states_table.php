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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);

            $table->foreignId('country_id')
            ->constrained('countries')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->string('country_code',2);
            $table->string('fips_code',255)->nullable();
            $table->string('iso2',255)->nullable();
            $table->string('type',255)->nullable();
            $table->decimal('latitude',11,8)->nullable();
            $table->decimal('longitude',11,8)->nullable();
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
        Schema::dropIfExists('states');
    }
};
