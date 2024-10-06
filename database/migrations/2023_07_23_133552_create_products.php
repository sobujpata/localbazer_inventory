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

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('category_id')->references('id')->on('categories')
                ->cascadeOnUpdate()->restrictOnDelete();


            $table->string('name',100);
            $table->string('buy_price',50);
            $table->string('buy_qty',50);
            $table->string('wholesale_price',50);
            $table->string('local_price',50)->nullable();
            $table->enum('for_sale', ['wholesale', 'local_sale', 'both_sale'])->nullable();
            $table->string('unit',50)->nullable();
            $table->string('img_url',100);


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
