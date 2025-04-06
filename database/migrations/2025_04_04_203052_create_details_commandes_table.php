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
        Schema::create('details_commandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commandeId');
            $table->unsignedBigInteger('livreId');
            $table->integer('quantity')->default(1);
            $table->decimal('montant', 8, 2);
            $table->timestamps();
            // Clés étrangères
            $table->foreign('commandeId')->references('id')->on('commandes')->onDelete('cascade');
            $table->foreign('livreId')->references('id')->on('livres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_commandes');
    }
};
