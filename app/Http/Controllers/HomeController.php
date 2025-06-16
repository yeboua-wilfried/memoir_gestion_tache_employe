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
            'tachesEnCours' => $user->tacheRealiserUsers()->where('etat', 'en cours')->count(),
            'tachesTerminees' => $user->tacheRealiserUsers()->where('etat', 'terminee')->count(),
            'projetsActifs' => $user->tacheRealiserUsers()->whereNotNull('projet_id')->pluck('projet_id')->unique()->count(),
            'tachesDuJour' => $user->tacheRealiserUsers()->whereDate('date_debut', now())->where('etat', 'en cours')->get(),
            'prochainesTaches' => $user->tacheRealiserUsers()->whereDate('date_debut', '>', now())->orderBy('date_debut')->where('etat', 'en cours')->limit(5)->get(),
            'tachesEnRetard' => $user->tacheRealiserUsers()->where('etat', '!=', 'terminee')->whereDate('date_fin', '<', now())->get(),
        ]);
    }
}
