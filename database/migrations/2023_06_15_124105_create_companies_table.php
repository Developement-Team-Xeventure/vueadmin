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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('code',255)->unique();
            $table->string('GSTIN')->nullable();
            $table->string('phone',20);
            $table->string('email',255)->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('signature')->nullable();

            $table->foreignId('business_type')
            ->constrained('business_types')
            ->onUpdate('cascade')
            ->onDelete('cascade')->nullable();

            $table->foreignId('business_categories')
            ->constrained('business_categories')
            ->onUpdate('cascade')
            ->onDelete('cascade')->nullable();

            $table->foreignId('state_id')
            ->constrained('states')
            ->onUpdate('cascade')
            ->onDelete('cascade')->nullable();

            $table->text('description')->nullable();

            $table->tinyInteger('open_status')->default(0)->comment('0 = not opened '); // 0 not opened
            $table->tinyInteger('active_status')->default(1)->comment('1 = active'); // 1 active
            $table->tinyInteger('is_parent')->default(1)->comment('1 = Parent'); // 1 Parent

            $table->foreignId('user_id')
            ->constrained('users')
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
        Schema::dropIfExists('companies');
    }
};
