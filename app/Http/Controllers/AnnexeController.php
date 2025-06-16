<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
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
            'type' => 'annexe_texte',
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
            'type' => 'annexe_fichier',
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

    public function edit(Annexe $annexe)
    {
        return view('annexes.edit', compact('annexe'));
    }

    public function update(Request $request, Annexe $annexe)
    {
        if ($annexe->type === 'annexe_texte') {
            $request->validate([
                'description' => 'required|string',
            ]);

            $annexe->update([
                'description' => $request->description,
                'taille' => strlen($request->description),
            ]);

        } elseif ($annexe->type === 'annexe_fichier') {
            $request->validate([
                'fichier' => 'required|file',
            ]);

            // Supprimer l'ancien fichier
            if ($annexe->repertoire) {
                \Storage::disk('public')->delete($annexe->repertoire);
            }

            $file = $request->file('fichier');
            $chemin = $file->store("annexes/tache_{$annexe->tache_id}", 'public');

            $annexe->update([
                'nom' => $file->getClientOriginalName(),
                'repertoire' => $chemin,
                'taille' => $file->getSize(),
            ]);
        }

        return redirect()->route('taches.show', $annexe->tache_id);
    }

    public function telecharger($id)
    {
        $annexe = Annexe::findOrFail($id);

        // Chemin du fichier dans le disque public
        $chemin = 'public/' . $annexe->repertoire;

        // Vérifie si le fichier existe
        if (Storage::exists($chemin)) {
            return Storage::download($chemin);
        }

        return redirect()->back()->with('error', 'Fichier introuvable.');
    }
}
