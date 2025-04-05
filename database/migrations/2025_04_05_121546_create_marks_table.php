<?php

use App\Support\AppDefaults;
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
        Schema::create('marks', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->timestamps();
            $table->enum('type',AppDefaults::markTypes());
            $table->text('description');
            $table->magellanPoint('geometry', 3857);
            $table->foreignUlid('user_id')->constrained('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
