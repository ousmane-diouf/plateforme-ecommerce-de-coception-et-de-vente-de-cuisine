<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('module_produits', function (Blueprint $table) {
            // Largeur du module en centimètres (ex: 60cm pour un meuble bas)
            $table->integer('largeur_cm')->default(60)->after('prix_base');
        });
    }

    public function down(): void
    {
        Schema::table('module_produits', function (Blueprint $table) {
            $table->dropColumn('largeur_cm');
        });
    }
};