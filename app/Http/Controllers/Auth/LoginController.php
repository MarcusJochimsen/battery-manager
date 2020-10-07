<?php

namespace App\Http\Controllers\Auth;

use App\Battery;
use App\Charging;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, ?Authenticatable $user): void
    {
        if ($user !== null && $user->name === 'Testnutzer') {
            // Todo In Seeder auslagern
            $user->batteries()->delete();

            $user->batteries()->save(
                new Battery(['name' => 'Akku 1'])
            )->chargings()->save(
                new Charging([
                    'load' => 30,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ])
            );

            $user->batteries()->save(
                new Battery(['name' => 'Akku 2'])
            )->chargings()->save(
                new Charging([
                    'load' => 100,
                    'created_at' => Carbon::now()->subDays(2),
                    'updated_at' => Carbon::now()->subDays(2),
                ])
            );

            $user->batteries()->save(
                new Battery(['name' => 'Akku 3'])
            )->chargings()->save(
                new Charging([
                    'load' => 50,
                    'created_at' => Carbon::now()->subDays(5),
                    'updated_at' => Carbon::now()->subDays(5),
                ])
            );

            $user->batteries()->save(
                new Battery(['name' => 'Akku 4'])
            )->chargings()->save(
                new Charging([
                    'load' => 100,
                    'created_at' => Carbon::now()->subWeek(),
                    'updated_at' => Carbon::now()->subWeek(),
                ])
            );

            $user->batteries()->save(
                new Battery(['name' => 'Akku 5'])
            )->chargings()->save(
                new Charging([
                    'load' => 100,
                    'created_at' => Carbon::now()->subWeeks(2),
                    'updated_at' => Carbon::now()->subWeeks(2),
                ])
            );
        }
    }
}
