<?php
namespace App\Http\Controllers;

use App\Models\Materiau;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MateriauController extends Controller
{
    /**
     * INDEX — Lister tous les matériaux
     * GET /api/admin/materiaux
     */
    public function index()
    {
        $materiaux = Materiau::all();

        return response()->json([
            'materiaux' => $materiaux
        ], 200);
    }

    /**
     * STORE — Créer un nouveau matériau
     * POST /api/admin/materiaux
     */
    public function store(Request $request)
    {
        $request->validate([
            'materiau_nom'    => 'required|string|max:20',
            'type'            => 'required|string|max:20',
            'supplement_prix' => 'required|numeric|min:0',
        ]);

        $materiau = Materiau::create([
            'Materiau_id'     => (string) Str::uuid(),
            'materiau_nom'    => $request->materiau_nom,
            'type'            => $request->type,
            'supplement_prix' => $request->supplement_prix,
        ]);

        return response()->json([
            'message'  => 'Matériau créé avec succès',
            'materiau' => $materiau
        ], 201);
    }

    /**
     * SHOW — Afficher un matériau
     * GET /api/admin/materiaux/{id}
     */
    public function show($id)
    {
        $materiau = Materiau::findOrFail($id);

        return response()->json([
            'materiau' => $materiau
        ], 200);
    }

    /**
     * UPDATE — Modifier un matériau
     * PUT /api/admin/materiaux/{id}
     */
    public function update(Request $request, $id)
    {
        $materiau = Materiau::findOrFail($id);

        $request->validate([
            'materiau_nom'    => 'sometimes|string|max:20',
            'type'            => 'sometimes|string|max:20',
            'supplement_prix' => 'sometimes|numeric|min:0',
        ]);

        $materiau->update($request->only([
            'materiau_nom',
            'type',
            'supplement_prix',
        ]));

        return response()->json([
            'message'  => 'Matériau mis à jour avec succès',
            'materiau' => $materiau
        ], 200);
    }

    /**
     * DESTROY — Supprimer un matériau
     * DELETE /api/admin/materiaux/{id}
     */
    public function destroy($id)
    {
        $materiau = Materiau::findOrFail($id);
        $materiau->delete();

        return response()->json([
            'message' => 'Matériau supprimé avec succès'
        ], 200);
    }
}