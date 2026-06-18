<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleProduit extends Model
{
    // On indique explicitement le nom de la table
    protected $table = 'module_produits';

    // La clé primaire n'est pas 'id' par défaut, on la redéfinit
    protected $primaryKey = 'ModuleProduit_id';

    // La clé primaire n'est pas un entier auto-incrémenté, c'est un UUID
    public $incrementing = false;
    protected $keyType = 'string';

    // Laravel gère automatiquement created_at et updated_at
    public $timestamps = true;

    // Les champs que l'on autorise à remplir en masse
    protected $fillable = [
        'ModuleProduit_id',
        'ModuleProduit_nom',
        'categorie',
        'largeur_cm',
        'prix_base',
        'image_url',
        'actif',
    ];

    // Relation : un module peut être utilisé dans plusieurs projets
    public function projetModules()
    {
        return $this->hasMany(ProjetModule::class, 'module_id', 'ModuleProduit_id');
    }
}