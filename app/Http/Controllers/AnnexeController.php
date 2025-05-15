<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annexe;
use App\Models\Tache;

class AnnexeController extends Controller
{

    public function storeTexte(Request $request, Tache $tache)
    {
        $request->validate([
            'description' => 'required|string',
        ]);

        $texte = $request->description;

        Annexe::create([
            'nom' => 'texte_' . now()->format('Ymd_His'),
            'description' => $texte,
            'type' => 'texte',
            'taille' => strlen($texte),
            'tache_id' => $tache->id,
        ]);

        return redirect()->back();
    }

    public function storeFichier(Request $request, Tache $tache)
    {
        $request->validate([
            'fichier' => 'required|file',
        ]);

        $file = $request->file('fichier');
        $nom = $file->getClientOriginalName();
        $taille = $file->getSize();
        $chemin = $file->store('annexes', 'public');

        Annexe::create([
            'nom' => $nom,
            'description' => null,
            'repertoire' => $chemin,
            'type' => 'fichier',
            'taille' => $taille,
            'tache_id' => $tache->id,
        ]);

        return redirect()->back();
    }

    public function destroy(Annexe $annexe)
    {
        if ($annexe->type === 'annexe_fichier' && $annexe->repertoire) {
            \Storage::disk('public')->delete($annexe->repertoire);
        }

        $annexe->delete();

        return redirect()->back();
    }
}
