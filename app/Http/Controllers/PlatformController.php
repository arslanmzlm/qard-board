<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PlatformController extends Controller
{
    public function list(): Response
    {
        return Inertia::render('Platform/List', [
            'platforms' => Platform::orderByDesc('id')->paginate(15),
            'logoPath' => Platform::LOGO_PATH,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Platform/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024',
        ]);

        $platform = new Platform();
        $platform->name = $validated['name'];

        if (isset($validated['logo']) && $file = $request->file('logo')) {
            $fileName = Str::slug($platform->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storeAs(Platform::LOGO_STORAGE_PATH, $fileName);
            $platform->logo = $fileName;
        }

        $platform->save();

        return to_route('platform.list')->with('toast', trans('messages.platform.create.success'));
    }

    public function edit(Platform $platform): Response
    {
        return Inertia::render('Platform/Edit', [
            'platform' => $platform,
            'logoPath' => Platform::LOGO_PATH,
        ]);
    }

    public function update(Platform $platform, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|max:1024',
        ]);

        $platform->name = $validated['name'];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = Str::slug($platform->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storeAs(Platform::LOGO_STORAGE_PATH, $fileName);
            $platform->logo = $fileName;
        }

        $platform->save();

        return to_route('platform.list')->with('toast', trans('messages.platform.update.success'));
    }

    public function destroy(Platform $platform): RedirectResponse
    {
        try {
            $platform->delete();

            return to_route('platform.list')->with('toast', trans('messages.platform.destroy.success'));
        } catch (\Exception $exception) {
            return to_route('platform.list')->with('toast', ['type' => 'error', 'message' => trans('messages.platform.destroy.error')]);
        }
    }
}
