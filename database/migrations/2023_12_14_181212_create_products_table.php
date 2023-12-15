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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->double('price', 8, 2, true)->index();
            $table->unsignedInteger('stock');
            $table->string('serial_number', 8)->unique();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
