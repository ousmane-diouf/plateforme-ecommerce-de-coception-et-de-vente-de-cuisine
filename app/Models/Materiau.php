<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materiau extends Model
{
    protected $table = 'materiaux';

    protected $primaryKey = 'Materiau_id';

    public $incrementing = false;
    protected $keyType = 'string';

    // La table materiaux n'a pas de timestamps (created_at/updated_at)
    public $timestamps = false;

    protected $fillable = [
        'Materiau_id',
        'materiau_nom',
        'type',
        'supplement_prix',
    ];

    // Relation : un matériau peut être utilisé dans plusieurs projets
    public function projetModules()
    {
        return $this->hasMany(ProjetModule::class, 'materiau_id', 'Materiau_id');
    }
}