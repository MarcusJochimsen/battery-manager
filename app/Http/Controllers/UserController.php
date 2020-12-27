<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return StreamedResponse
     */
    public function index()
    {
        $user = auth()->user();
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=BatterManger_' . $user->name . '_' . Carbon::now() . '.backup.csv',
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $batteries = $user->batteries()->getResults();
        $batteryArray = $batteries->toArray();

        $chargingArray = [];
        foreach (iterator_to_array($batteries) as $battery) {
            $chargingArray = array_merge($chargingArray, $battery->chargings()->getResults()->toArray());
        }

        # add headers for each column in the CSV download
        array_unshift($batteryArray, array_keys($batteryArray[0]));
        array_unshift($chargingArray, array_keys($chargingArray[0]));

        $callback = function() use ($batteryArray, $chargingArray)
        {
            $FH = fopen('php://output', 'w');
            foreach ($batteryArray as $row) {
                fputcsv($FH, $row);
            }
            fputcsv($FH, []);
            foreach ($chargingArray as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        $currentUserId = auth()->user()->id;

        $data = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $currentUserId],
        ]);

        $user = User::find($currentUserId);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        return redirect(route('setting.index'));
    }
}
