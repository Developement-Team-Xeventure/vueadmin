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
        Schema::create('g_s_t_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('is_deletable')->default(0)->comment('0= Not deletable, 1=  deletable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('g_s_t_types');
    }
};
