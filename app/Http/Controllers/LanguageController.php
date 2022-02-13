<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * @param $lang
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function swap($locale)
    {
        // ALMACENO EL IDIOMA EN LA SESIÓN

        App::setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
