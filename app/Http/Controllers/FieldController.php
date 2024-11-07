<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class FieldController extends Controller
{
    public function list(): Response
    {
        return Inertia::render('Field/List', [
            'fields' => Field::orderByDesc('id')->paginate(15),
            'logoPath' => Field::LOGO_PATH,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Field/Create', [
            'types' => Field::TYPES
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:' . implode(',', Field::TYPES),
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024',
            'values' => 'nullable|array',
            'values.*' => 'required|string|max:255',
        ]);

        $field = new Field();
        $field->type = $validated['type'];
        $field->name = $validated['name'];

        if (!empty($validated['values']) && $validated['type'] === Field::TYPE_CARD) {
            $field->values = array_filter($validated['values']);
        } else {
            $field->values = null;
        }

        if (isset($validated['logo']) && $file = $request->file('logo')) {
            $fileName = Str::slug($field->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storePubliclyAs(Field::LOGO_PATH, $fileName);
            $field->logo = $fileName;
        }

        $field->save();

        return to_route('field.list')->with('toast', trans('messages.field.create.success'));
    }

    public function edit(Field $field): Response
    {
        return Inertia::render('Field/Edit', [
            'types' => Field::TYPES,
            'field' => $field,
            'logoPath' => Field::LOGO_PATH,
        ]);
    }

    public function update(Field $field, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:' . implode(',', Field::TYPES),
            'name' => 'required|string|max:255',
            'logo' => 'nullable|max:1024',
            'values' => 'nullable|array',
            'values.*' => 'required|string|max:255',
        ]);

        $field->type = $validated['type'];
        $field->name = $validated['name'];

        if (!empty($validated['values']) && $validated['type'] === Field::TYPE_CARD) {
            $field->values = array_filter($validated['values']);
        } else {
            $field->values = null;
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = Str::slug($field->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storePubliclyAs(Field::LOGO_PATH, $fileName);
            $field->logo = $fileName;
        }

        $field->save();

        return to_route('field.list')->with('toast', trans('messages.field.update.success'));
    }

    public function destroy(Field $field): RedirectResponse
    {
        try {
            Storage::delete(public_path($field->getLogoUrlAttribute()));
            $field->delete();

            return to_route('field.list')->with('toast', trans('messages.field.destroy.success'));
        } catch (\Exception $exception) {
            return to_route('field.list')->with('toast', ['type' => 'error', 'message' => trans('messages.field.destroy.error')]);
        }
    }
}
