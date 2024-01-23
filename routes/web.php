<?php

use App\Http\Controllers\ActiesController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DossiersController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FacturenController;
use App\Http\Controllers\KlantenController;
use App\Http\Controllers\MaatschappijenController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\SearchController;
use App\Models\Dossier;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/login', 'Auth\LoginController@showLoginForm')->name('loginForm');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('loginForm');

Route::post('login', [LoginController::class, 'login'])->name('login');
// Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('registerform');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/', [Controller::class, 'index'])->name('site.home');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ******************klanten routes
Route::get('/klanten', [KlantenController::class, 'index'])->name('klanten.home');
Route::get('/klanten/create', [KlantenController::class, 'create'])->name('klanten.create');
Route::post('/klanten/create', [KlantenController::class, 'store'])->name('klanten.store');
Route::get('/klanten/{id}/edit', [KlantenController::class, 'edit'])->name('klanten.edit');
Route::post('/klanten/{id}/edit', [KlantenController::class, 'update'])->name('klanten.update');
Route::get('/klanten/{id}/delete', [KlantenController::class, 'destroy'])->name('klanten.destroy');

// ******************facturen routes
Route::get('/facturen', [FacturenController::class, 'index'])->name('facturen.home');
Route::get('/facturen/create', [FacturenController::class, 'create'])->name('facturen.create');
Route::post('/facturen/create', [FacturenController::class, 'store'])->name('facturen.store');
Route::get('/facturen/{id}/edit', [FacturenController::class, 'edit'])->name('facturen.edit');
Route::post('/facturen/{id}/edit', [FacturenController::class, 'update'])->name('facturen.update');
Route::get('/facturen/zoeken', [FacturenController::class, 'search'])->name('facturen.zoeken');

// ******************Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.home');
Route::get('/statistieken', [DashboardController::class, 'statistieken'])->name('dashboard.statistieken');
Route::get('/dossiersstatistieken', [DashboardController::class, 'ossiersstatistieken'])->name('dashboard.dossiers');
// ************************CarsRoutes
Route::get('/cars', [CarsController::class, 'index'])->name('cars.home');
Route::get('/cars/create', [CarsController::class, 'create'])->name('cars.create');
Route::post('/cars/create', [CarsController::class, 'store'])->name('cars.store');
Route::get('/cars/{id}/edit', [CarsController::class, 'edit'])->name('cars.edit');
Route::post('/cars/{id}/edit', [CarsController::class, 'update'])->name('cars.update');
Route::get('/cars/{id}/delete', [CarsController::class, 'destroy'])->name('cars.destroy');
// *********************acties Routes
Route::get('/acties', [ActiesController::class, 'index'])->name('acties.home');
Route::get('/acties/create', [ActiesController::class, 'create'])->name('acties.create');
Route::post('/acties/create', [ActiesController::class, 'store'])->name('acties.store');
Route::get('/acties/{id}/edit', [ActiesController::class, 'edit'])->name('acties.edit');
Route::post('/acties/{id}/edit', [ActiesController::class, 'update'])->name('acties.update');
Route::get('/acties/{id}/delete', [ActiesController::class, 'destroy'])->name('acties.destroy');
// *************Maatschappijen Routes
Route::get('/maatschappijen', [MaatschappijenController::class, 'index'])->name('maatschappijen.home');
Route::get('/maatschappijen/create', [MaatschappijenController::class, 'create'])->name('maatschappijen.create');
Route::post('/maatschappijen/create', [MaatschappijenController::class, 'store'])->name('maatschappijen.store');
Route::get('/maatschappijen/{id}/edit', [MaatschappijenController::class, 'edit'])->name('maatschappijen.edit');
Route::post('/maatschappijen/{id}/edit', [MaatschappijenController::class, 'update'])->name('maatschappijen.update');
Route::get('/maatschappijen/{id}/delete', [MaatschappijenController::class, 'destroy'])->name('maatschappijen.destroy');


// ***************VervaldagTypes Routes
Route::get('/vervaldagtypes', [MaatschappijenController::class, 'index'])->name('vervaldagtypes.home');
Route::get('/vervaldagtypes/create', [MaatschappijenController::class, 'create'])->name('vervaldagtypes.create');
Route::post('/vervaldagtypes/create', [MaatschappijenController::class, 'store'])->name('vervaldagtypes.store');
Route::get('/vervaldagtypes/{id}/edit', [MaatschappijenController::class, 'edit'])->name('vervaldagtypes.edit');
Route::post('/vervaldagtypes/{id}/edit', [MaatschappijenController::class, 'update'])->name('vervaldagtypes.update');
Route::get('/vervaldagtypes/{id}/delete', [MaatschappijenController::class, 'destroy'])->name('vervaldagtypes.destroy');

// *************Search Controller Routes
Route::post('/search/executeSearch', [SearchController::class, 'executeSearch'])->name('klanten.search');
Route::post('search/executeSearchDossiers', [SearchController::class, 'executeSearchDossiers'])->name('dossiers.search');
Route::post('/search/executeFacturenSearch', [SearchController::class, 'executeFacturenSearch'])->name('facturen.search');
Route::post('/search/searchInvoices', [SearchController::class, 'executeSearchInvoices'])->name('facturen.search2');
Route::post('/search/statistieken', [SearchController::class, 'berekenStatistieken'])->name('dashboard.berekenen');
Route::post('/search/dossiersstatistieken', [SearchController::class, 'berekenDossiersStatistieken'])->name('dashboard.dossiersberekenen');
// **************MakelaarsController Routes
Route::get('/makelaars', [MaatschappijenController::class, 'index'])->name('makelaars.home');
Route::get('/makelaars/create', [MaatschappijenController::class, 'create'])->name('makelaars.create');
Route::post('/makelaars/create', [MaatschappijenController::class, 'store'])->name('makelaars.store');
Route::get('/makelaars/{id}/edit', [MaatschappijenController::class, 'edit'])->name('makelaars.edit');
Route::post('/makelaars/{id}/edit', [MaatschappijenController::class, 'update'])->name('makelaars.update');
Route::get('/makelaars/{id}/delete', [MaatschappijenController::class, 'destroy'])->name('makelaars.destroy');
// *********************excel routes
Route::get('/export', [ExportController::class, 'index'])->name('export.home');
Route::get('/export/export', [ExportController::class, 'export'])->name('export.export');
Route::get('/import-export-csv-excel', [ExportController::class, 'importExportExcelORCSV'])->name('excel.import');
Route::post('/import-csv-excel', [ExportController::class, 'importFileIntoDB'])->name('import-csv-excel');
// *********************Print Routes
Route::get('/print-facturen', [PrintController::class, 'printFacturen'])->name('print_overzicht_facturen');
Route::post('/print-facturen', [PrintController::class, 'printFacturen'])->name('print_overzicht_facturen');
// ***************** Dossiers Routes
Route::get('/dossiers', [DossiersController::class, 'index'])->name('dossiers.home');
Route::get('/dossiers/zoeken', [DossiersController::class, 'search'])->name('dossiers.zoeken');
Route::get('/dossiers/{dossiernummer}', [DossiersController::class, 'show'])->name('dossiers.show');
// ***********import-dossiers Routes
Route::get('/import-dossiers', [ExportController::class, 'import'])->name('dossiersexcel.import');
Route::post('/import-dossiers', [ExportController::class, 'importDossiersIntoDB'])->name('dossiers.import');
Route::get('/logs', [ExportController::class, 'index'])->name('logs.home');
// ***********************Test routes
Route::get('test', function () {
    // $factuur = App\Factuur::find(1441);
    // return $factuur->dossiers()->first();
    $dossier = Dossier::find(2);
    return $dossier->facturen()->get();
});