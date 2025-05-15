<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tache;
use App\Models\Projet;

class HomeController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        return view('home', [
            'tachesEnCours' => $user->tachesRealisees()->where('etat', 'en_cours')->count(),
            'tachesTerminees' => $user->tachesRealisees()->where('etat', 'terminee')->count(),
            'projetsActifs' => $user->tachesRealisees()->whereNotNull('projet_id')->pluck('projet_id')->unique()->count(),
            'tachesDuJour' => $user->tachesRealisees()->whereDate('date_debut', now())->get(),
            'prochainesTaches' => $user->tachesRealisees()->whereDate('date_debut', '>', now())->orderBy('date_debut')->limit(5)->get(),
            'tachesEnRetard' => $user->tachesRealisees()->where('etat', '!=', 'terminee')->whereDate('date_fin', '<', now())->get(),
        ]);
    }
}
