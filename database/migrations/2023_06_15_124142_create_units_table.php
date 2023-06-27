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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('short_name');
            $table->string('long_name');
            $table->tinyInteger('is_deletable')->default(0)->comment('0= Not deletable, 1=  deletable');
            $table->tinyInteger('is_default')->default(0)->comment('Default Units');

            $table->foreignId('company_id')
            ->nullable(true)
            ->constrained('companies')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
