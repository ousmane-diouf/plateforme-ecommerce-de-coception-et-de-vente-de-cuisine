<?php
namespace App\Http\Controllers;

use App\Models\ModuleProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleProduitController extends Controller
{
    /**
     * INDEX — Lister tous les modules
     * GET /api/admin/modules
     */
    public function index()
    {
        // On récupère tous les modules triés du plus récent au plus ancien
        $modules = ModuleProduit::orderBy('created_at', 'desc')->get();

        return response()->json([
            'modules' => $modules
        ], 200);
    }

    /**
     * STORE — Créer un nouveau module
     * POST /api/admin/modules
     */
    public function store(Request $request)
    {
        // A. Validation des données reçues
        $request->validate([
            'ModuleProduit_nom' => 'required|string|max:20',
            'categorie'         => 'required|string|max:20',
            'prix_base'         => 'required|numeric|min:0',
            'image_url'         => 'nullable|string|max:30',
            'actif'             => 'boolean',
        ]);

        // B. Création du module avec un UUID généré automatiquement
        $module = ModuleProduit::create([
            'ModuleProduit_id'  => (string) Str::uuid(),
            'ModuleProduit_nom' => $request->ModuleProduit_nom,
            'categorie'         => $request->categorie,
            'prix_base'         => $request->prix_base,
            'image_url'         => $request->image_url,
            'actif'             => $request->actif ?? true,
        ]);

        // C. Réponse avec le module créé
        return response()->json([
            'message' => 'Module créé avec succès',
            'module'  => $module
        ], 201);
    }

    /**
     * SHOW — Afficher un module spécifique
     * GET /api/admin/modules/{id}
     */
    public function show($id)
    {
        // On cherche le module par son UUID, erreur 404 si introuvable
        $module = ModuleProduit::findOrFail($id);

        return response()->json([
            'module' => $module
        ], 200);
    }

    /**
     * UPDATE — Modifier un module existant
     * PUT /api/admin/modules/{id}
     */
    public function update(Request $request, $id)
    {
        // A. On cherche le module à modifier
        $module = ModuleProduit::findOrFail($id);

        // B. Validation des données
        $request->validate([
            'ModuleProduit_nom' => 'sometimes|string|max:20',
            'categorie'         => 'sometimes|string|max:20',
            'prix_base'         => 'sometimes|numeric|min:0',
            'image_url'         => 'nullable|string|max:30',
            'actif'             => 'sometimes|boolean',
        ]);

        // C. Mise à jour — 'sometimes' signifie "valide seulement si présent"
        $module->update($request->only([
            'ModuleProduit_nom',
            'categorie',
            'prix_base',
            'image_url',
            'actif',
        ]));

        return response()->json([
            'message' => 'Module mis à jour avec succès',
            'module'  => $module
        ], 200);
    }

    /**
     * DESTROY — Supprimer un module
     * DELETE /api/admin/modules/{id}
     */
    public function destroy($id)
    {
        // On cherche le module à supprimer
        $module = ModuleProduit::findOrFail($id);

        $module->delete();

        return response()->json([
            'message' => 'Module supprimé avec succès'
        ], 200);
    }
}