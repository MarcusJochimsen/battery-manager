<?php

namespace App\Http\Controllers;

use App\Battery;
use App\Charging;
use App\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ChargingController extends Controller
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
        return view('charging.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Battery $battery
     * @return View
     */
    public function create(Battery $battery): View
    {
        return view('charging.create')
            ->with('battery', $battery);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Battery $battery
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Battery $battery): RedirectResponse
    {
        $this->validate(request(), [
            'load' => 'required|int|min:0|max:100',
        ]);

        $model = new Charging(request([
            'load',
        ]));

        $model->setShiftAttributeManual($battery->id);

        $battery->chargings()->save(
            $model
        );

        return redirect(route('battery.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Charging $charging
     * @return View
     */
    public function show(Charging $charging): View
    {
        return view('charging.show')
            ->with('charging', $charging);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Charging $charging
     * @return View
     */
    public function edit(Charging $charging): View
    {
        return view('charging.edit')
            ->with('charging', $charging);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Charging $charging
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Charging $charging): RedirectResponse
    {
        $this->validate(request(), [
            'load' => 'required|int|min:0|max:100',
        ]);

        $charging->update(
            request([
                'load',
                'shift',
            ])
        );

        return redirect(route('battery.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Charging $charging
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Charging $charging): RedirectResponse
    {
        $charging->delete();

        return redirect('charging');
    }
}
