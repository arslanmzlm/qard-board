<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class BankController extends Controller
{
    public function list(): Response
    {
        return Inertia::render('Bank/List', [
            'banks' => Bank::orderByDesc('id')->paginate(15),
            'logoPath' => Bank::LOGO_PATH,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Bank/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024',
        ]);

        $bank = new Bank();
        $bank->name = $validated['name'];

        if (isset($validated['logo']) && $file = $request->file('logo')) {
            $fileName = Str::slug($bank->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storePubliclyAs(Bank::LOGO_STORAGE_PATH, $fileName);
            $bank->logo = $fileName;
        }

        $bank->save();

        return to_route('bank.list')->with('toast', trans('messages.bank.create.success'));
    }

    public function edit(Bank $bank): Response
    {
        return Inertia::render('Bank/Edit', [
            'bank' => $bank,
            'logoPath' => Bank::LOGO_PATH,
        ]);
    }

    public function update(Bank $bank, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|max:1024',
        ]);

        $bank->name = $validated['name'];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = Str::slug($bank->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storePubliclyAs(Bank::LOGO_STORAGE_PATH, $fileName);
            $bank->logo = $fileName;
        }

        $bank->save();

        return to_route('bank.list')->with('toast', trans('messages.bank.update.success'));
    }

    public function destroy(Bank $bank): RedirectResponse
    {
        try {
            $bank->delete();

            return to_route('bank.list')->with('toast', trans('messages.bank.destroy.success'));
        } catch (\Exception $exception) {
            return to_route('bank.list')->with('toast', ['type' => 'error', 'message' => trans('messages.bank.destroy.error')]);
        }
    }
}
