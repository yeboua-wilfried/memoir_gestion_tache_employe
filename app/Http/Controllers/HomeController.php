<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tache;
use App\Models\Projet;

use App\Models\User;
use App\Models\Departement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class HomeController extends Controller
{
    public function home()
    {
        // Supprimer les utilisateurs partis depuis plus d'un mois
        User::where('disponibilite_user', 'départ')->whereDate('date_fin_contrat', '<', Carbon::now()->subMonth())->delete();

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

    public function dashboard()
    {
        // Graphique 1 : Tâches par statut
        $tachesStatuts = Tache::select('etat', DB::raw('count(*) as total'))
            ->groupBy('etat')->pluck('total', 'etat');

        // Graphique 2 : Utilisateurs par département
        $usersParDepartement = DB::table('users')
            ->join('equipes', 'users.equipe_id', '=', 'equipes.id')
            ->join('departements', 'equipes.departement_id', '=', 'departements.id')
            ->select('departements.nom as departement', DB::raw('count(users.id) as total'))
            ->groupBy('departements.nom')
            ->pluck('total', 'departement');

        // Graphique 3 : Tâches par mois
        $tachesParMois = Tache::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->groupBy('mois')->orderBy('mois')->get();

        $moisLabels = $tachesParMois->pluck('mois')->map(function ($mois) {
            return \Carbon\Carbon::create()->month($mois)->format('F');
        });

        return view('dashboard', [
            'statutsLabels' => $tachesStatuts->keys(),
            'statutsCounts' => $tachesStatuts->values(),

            'departementsLabels' => $usersParDepartement->keys(),
            'departementsCounts' => $usersParDepartement->values(),

            'moisLabels' => $moisLabels,
            'moisCounts' => $tachesParMois->pluck('total'),
        ]);
    }

}
