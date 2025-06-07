<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\AnnexeController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::get('/notifications', function () {
        return response()->json(['notifications' => auth()->user()->notifications()->where('is_read', false)->get()]);
    });
    Route::get('/notifications/unread', [NotificationController::class, 'unread']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/demande/user', [DemandeController::class, 'indexUser'])->name('demande.user.index');
    Route::get('/demandes/create', [DemandeController::class, 'create'])->name('demandes.create');
    Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');

    Route::get('/taches/user', [TacheController::class, 'indexUser'])->name('taches.user.index');

    Route::get('/taches/{id}/travail', [TacheController::class, 'travail'])->name('taches.travail');
    Route::get('/taches/{id}', [TacheController::class, 'show'])->name('taches.show');
    Route::patch('/taches/{tache}/valider', [TacheController::class, 'valider'])->name('taches.valider');

    Route::post('/annexes/texte/{tache}', [AnnexeController::class, 'storeTexte'])->name('annexes.storeTexte');
    Route::post('/annexes/fichier/{tache}', [AnnexeController::class, 'storeFichier'])->name('annexes.storeFichier');
    Route::get('/annexes/{annexe}/edit', [AnnexeController::class, 'edit'])->name('annexes.edit');
    Route::put('/annexes/{annexe}', [AnnexeController::class, 'update'])->name('annexes.update');
    Route::delete('/annexes/{annexe}', [AnnexeController::class, 'destroy'])->name('annexes.destroy');
});

Route::middleware(['auth', 'role:super_employe,pdg,admin,super_employe_rh'])->group(function () {
    Route::get('/liste_employe', [EmployeController::class, 'index'])->name('employes.index');
    Route::get('/employes/create', [EmployeController::class, 'create'])->name('employes.create');
    Route::post('/employes', [EmployeController::class, 'store'])->name('employes.store');
    Route::get('/employes/{id}/edit', [EmployeController::class, 'edit'])->name('employes.edit');
    Route::patch('/employes/{id}', [EmployeController::class, 'update'])->name('employes.update');
    Route::delete('/employes/{id}', [EmployeController::class, 'destroy'])->name('employes.destroy');

    Route::get('/taches', [TacheController::class, 'index'])->name('taches.index');
    Route::get('/taches/create', [TacheController::class, 'create'])->name('taches.create');
    Route::get('/tache/create', [TacheController::class, 'create'])->name('tache.create');
    Route::post('/taches', [TacheController::class, 'store'])->name('taches.store');
    Route::get('/taches/{id}/edit', [TacheController::class, 'edit'])->name('taches.edit');
    Route::patch('/taches/{id}', [TacheController::class, 'update'])->name('taches.update');
    Route::delete('/taches/{id}', [TacheController::class, 'destroy'])->name('taches.destroy');

    Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index');

    Route::get('/postes', [PosteController::class, 'index'])->name('postes.index');
    Route::get('/postes/create', [PosteController::class, 'create'])->name('postes.create');
    Route::post('/postes', [PosteController::class, 'store'])->name('postes.store');
    Route::get('/postes/{poste}/edit', [PosteController::class, 'edit'])->name('postes.edit');
    Route::patch('/postes/{poste}', [PosteController::class, 'update'])->name('postes.update');
    Route::resource('postes', PosteController::class);
    Route::delete('/postes/{id}', [PosteController::class, 'destroy'])->name('postes.destroy');

    Route::get('/departements', [DepartementController::class, 'index'])->name('departements.index');
    Route::get('/departements/create', [DepartementController::class, 'create'])->name('departements.create');
    Route::post('/departements', [DepartementController::class, 'store'])->name('departements.store');
    Route::get('/departements/{id}/edit', [DepartementController::class, 'edit'])->name('departements.edit');
    Route::patch('/departements/{id}', [DepartementController::class, 'update'])->name('departements.update');
    Route::delete('/departements/{id}', [DepartementController::class, 'destroy'])->name('departements.destroy');

    Route::get('/equipes', [EquipeController::class, 'index'])->name('equipes.index');
    Route::get('/equipes/create', [EquipeController::class, 'create'])->name('equipes.create');
    Route::post('/equipes', [EquipeController::class, 'store'])->name('equipes.store');
    Route::get('/equipes/{id}/edit', [EquipeController::class, 'edit'])->name('equipes.edit');
    Route::patch('/equipes/{id}', [EquipeController::class, 'update'])->name('equipes.update');
    Route::delete('/equipes/{id}', [EquipeController::class, 'destroy'])->name('equipes.destroy');

    Route::get('/projets/create', [ProjetController::class, 'create'])->name('projets.create');
    Route::post('/projets', [ProjetController::class, 'store'])->name('projets.store');
    Route::get('/projets/{id}/edit', [ProjetController::class, 'edit'])->name('projets.edit');
    Route::patch('/projets/{id}', [ProjetController::class, 'update'])->name('projets.update');
    Route::delete('/projets/{id}', [ProjetController::class, 'destroy'])->name('projets.destroy');
});

//mot de passe des utilisateurs = password

require __DIR__.'/auth.php';
