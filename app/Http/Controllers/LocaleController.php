<?php

namespace App\Http\Controllers;

use Redirect;


class LocaleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Define a tradução
     * @param pt (portugues) ou en (ingles) ou es (espanhol)
     */
    public function setLocale($locale)
    {
        session(['locale' => $locale]);
        return Redirect::route('home');
    }
}
