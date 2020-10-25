<?php

namespace App\Http\Controllers;

use App\Battery;
use App\Charging;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StaticSiteController extends Controller
{
    public function datenschutz(): View
    {
        return view('datenschutz');
    }

    public function impressum(): View
    {
        return view('impressum');
    }
}
