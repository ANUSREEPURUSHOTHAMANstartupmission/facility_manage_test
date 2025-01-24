<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StartupController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\StartupIndiaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FacilityController as ControllersFacilityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController as ControllersProfileController;
use App\Http\Controllers\Startup\ProfileController;
use App\Http\Controllers\VisitController;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Location;
use App\Models\User;
use App\Notifications\FacilityBookedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    $locations = Location::all()->pluck('district');
    $search = "%".$request->input('query').'%';

    $facilities = Facility::where([['status', 'active'],['is_addon','==', false],['type','room']])
                            ->whereHas('location', function($query) use($search){
                                $query->where('district', 'LIKE', $search);
                            })->get()->groupBy(function($item){
                                return $item->location->district;
                            });

    $visits = Location::whereHas('facilities', function($q){
        $q->where('status', 'active')->where('type', 'visit');
    })->get();

    return view('welcome', compact('locations', 'facilities', 'visits'));

})->name('welcome');

Route::middleware('guest')->get('login', [LoginController::class, 'form'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);
Route::middleware('guest')->get('verify-login/{token}', [LoginController::class, 'verify'])->name('verify-login');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'form'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('users/{user}/resend', [UserController::class, 'resend'])->name('users.resend');
    Route::post('users/search', [UserController::class, 'search'])->name('users.search');
    Route::resource('users', UserController::class);

    Route::resource('roles', RoleController::class);
    // Route::resource('startups', StartupController::class);
    
    Route::get('locations/{location}/assign', [LocationController::class, 'assign'])->name('locations.assign');
    Route::post('locations/{location}/assign', [LocationController::class, 'user']);
    Route::delete('locations/{location}/detach/{user}', [LocationController::class, 'detach'])->name('locations.detach');
    Route::resource('locations', LocationController::class);
    Route::resource('holidays', HolidayController::class);

    Route::get('facilities/{facility}/assign', [FacilityController::class, 'assign'])->name('facilities.assign');
    Route::post('facilities/{facility}/assign', [FacilityController::class, 'user']);
    Route::delete('facilities/{facility}/detach/{user}', [FacilityController::class, 'detach'])->name('facilities.detach');
    Route::resource('facilities', FacilityController::class);

    Route::get('facility/{facility}/rates/create', [RateController::class, 'create'])->name('rates.create');
    Route::post('rates', [RateController::class, 'store'])->name('rates.store');
    Route::get('facility/{facility}/rates/{rate}/edit', [RateController::class, 'edit'])->name('rates.edit');
    Route::put('rates/{rate}', [RateController::class, 'update'])->name('rates.update');

    Route::post('facility/{facility}/image', [ImageController::class, 'store'])->name('facility.image');
    Route::delete('image/{image}', [ImageController::class, 'destroy'])->name('image.delete');
    
    Route::post('bookings/{booking}/attach', [AdminBookingController::class, 'attach'])->name('bookings.attach');
    Route::get('bookings/{booking}/detach/{facility}', [AdminBookingController::class, 'detach'])->name('bookings.detach');
    Route::post('bookings/{booking}', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::resource('bookings', AdminBookingController::class)->only(['index','create','store','show','update']);

    Route::get('payments/{payment}', [AdminPaymentController::class, 'view'])->name('payments.view');
    
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.view');

    Route::get('export', [ExportController::class, 'export'])->name('export');
});


Route::prefix('startup')->name('startup.')->group(function(){
    Route::resource('profile', ProfileController::class);
});


Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('facility/{facility}', [ControllersFacilityController::class, 'show'])->name('facility.view');
Route::post('facility/{facility}', [ControllersFacilityController::class, 'store'])->name('facility.store');

Route::get('visit/{location}', [VisitController::class, 'show'])->name('visit.view');
Route::post('visit/{location}', [VisitController::class, 'store'])->name('visit.store');

Route::get('booking/{booking}', [BookingController::class, 'show'])->name('booking.view');
Route::get('booking/{booking}/detach/{facility}', [BookingController::class, 'destroy'])->name('booking.detach');
Route::post('booking/{booking}/attach', [BookingController::class, 'store'])->name('booking.attach');
Route::post('booking/{booking}', [BookingController::class, 'update'])->name('booking.request');

Route::post('booking/{booking}/payment', [PaymentController::class, 'store'])->name('booking.payment.create');
Route::get('payment/{payment}', [PaymentController::class, 'show'])->name('payment.show');
Route::put('payment/{payment}', [PaymentController::class, 'update'])->name('payment.update');

Route::get('booking/{booking}/receipt', [BookingController::class, 'index'])->name('booking.receipt');

Route::get('profile', [ControllersProfileController::class, 'index'])->name('profile.index');
Route::post('profile', [ControllersProfileController::class, 'store'])->name('profile.store');

Route::get('storage/{folder}/{filename}', function ($folder,$filename)
{
    // dd($folder, $filename);

    $path = storage_path('app/'.$folder. '/' . $filename);

    // dd($path);
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;

})->name('storage.file');

Route::get('test', function(){

    $booking = Booking::find('7ba06e69-369d-4a68-b6fb-0fb464182173');

    return (new FacilityBookedNotification($booking))->toMail(User::first());


    $facilities = $booking->facilities;

    $users = $facilities->map(function($facility){
        return $facility->users;
    })->flatten()->pluck('email')->unique();

    dd($users);

    return;

    $route_list = Route::getRoutes();

    foreach($route_list as $key => $route){
        
        var_dump($route);
            echo $key." - ".$route->getActionName();
            echo "<br>";
        break;
    }
});

Route::get('silogin', [StartupIndiaController::class, 'login_form'])->name('silogin');
Route::get('silogin/callback', [StartupIndiaController::class, 'callback'])->name('silogin.callback');
