<?php

namespace App\Http\Controllers;

use RuntimeException;

class SentryController extends Controller
{
    public function exception(): void
    {
        throw new RuntimeException('Sentry-Test');
    }
}
