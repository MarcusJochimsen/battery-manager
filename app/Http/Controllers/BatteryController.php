<?php

namespace App\Http\Controllers;

use App\Battery;
use App\Charging;
use App\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BatteryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        /** @var User $user */
        $user = auth()->user();

        return view('battery.index')
            ->with('batteries', $user->orderedBatteries() ?? []);
//            ->with('batteries', $user->batteries()->getResults() ?? []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('battery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(): RedirectResponse
    {
        $this->validate(request(), [
            'name' => 'required|string',
        ]);

        /** @var User $user */
        $user = auth()->user();
        /** @var Battery $batterie */
        $batterie = $user->batteries()->save(
            new Battery(request([
                'name',
            ]))
        );
        $batterie->chargings()->save(
            new Charging(['load' => 100])
        );

        return redirect('battery');
    }

    /**
     * Display the specified resource.
     *
     * @param Battery $battery
     * @return View
     */
    public function show(Battery $battery): View
    {
        return view('battery.show')
        ->with('battery', $battery);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Battery $battery
     * @return View
     */
    public function edit(Battery $battery): View
    {
        return view('battery.edit')
            ->with('battery', $battery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Battery $battery
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Battery $battery): RedirectResponse
    {
        $this->validate(request(), [
            'name' => 'required|string',
        ]);

        $battery->update(
            request([
                'name',
            ])
        );

        return redirect('battery/' . $battery->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Battery $battery
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Battery $battery): RedirectResponse
    {
        $battery->delete();

        return redirect('battery');
    }
}
