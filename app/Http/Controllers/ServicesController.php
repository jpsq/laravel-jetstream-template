<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use App\Facades\Services;
use App\Http\Requests\SaveService;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class ServicesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Services', [
            'services' => Services::all()
        ]);
    }

    public function update(SaveService $saveService): RedirectResponse
    {
        $saveService->handle();

        return back();
    }

     /**
     * Show the terms of service for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function documentation(Request $request,$service)
    {
        $termsFile = Jetstream::localizedMarkdownPath('tenorDocumentation.md');

        return Inertia::render('TermsOfService', [
            'terms' => Str::markdown(file_get_contents($termsFile)),
        ]);
    }
}
