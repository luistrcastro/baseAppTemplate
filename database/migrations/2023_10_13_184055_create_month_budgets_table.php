<?php

use App\Models\User;
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
        Schema::create('month_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->default(null)->index();
            $table->decimal('percentage')->nullable()->default(null);
            $table->string('type', 25);
            $table->string('name', 25);
            $table->string('color', 25);
            $table->string('icon', 25);
            $table->string('description', 255)->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('month_budgets');
    }
};
