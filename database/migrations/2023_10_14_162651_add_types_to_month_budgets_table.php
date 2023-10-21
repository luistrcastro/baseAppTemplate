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
        Schema::table('month_budgets', function (Blueprint $table) {
          $table->enum('type', ['expense', 'income'])->after('description');
          $table->decimal('percentage')->nullable()->default(null)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('month_budgets', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('percentage');
        });
    }
};
