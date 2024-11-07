<?php

namespace App\Http\Controllers;

use App\Models\Company;

class PublicController extends Controller
{
    public function index()
    {
        $company = Company::first();
        $theme = $company->theme ?? Company::DEFAULT_THEME;

        return view("cards/{$theme}", [
            'company' => $company,
            'fields' => $company->fields()->orderBy('order')->get(),
        ]);
    }

    public function card(Company $company)
    {
        $theme = $company->theme ?? Company::DEFAULT_THEME;

        return view("cards/{$theme}", [
            'company' => $company,
            'fields' => $company->fields()->orderBy('order')->get(),
        ]);
    }
}
