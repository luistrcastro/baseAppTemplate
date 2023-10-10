<?php

use App\Models\Account;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->index();
            $table->foreignIdFor(Category::class)->nullable()->default(null)->index();
            $table->foreignIdFor(Account::class)->index();
            $table->unsignedInteger('parent_transaction_id')->nullable()->default(null);
            $table->string('label', 20);
            $table->string('description', 255)->nullable()->default(null);
            $table->decimal('amount');
            $table->date('date');
            $table->boolean('is_computed')->default(true);
            $table->boolean('duplication_checked')->default(false);
            $table->boolean('system_generated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
