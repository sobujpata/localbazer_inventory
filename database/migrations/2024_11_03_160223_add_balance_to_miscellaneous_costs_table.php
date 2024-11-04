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
        Schema::table('miscellaneous_costs', function (Blueprint $table) {
            $table->decimal('balance', 10, 2)->default(0)->after('amount'); // Example for a decimal balance column with default value
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('miscellaneous_costs', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
};
