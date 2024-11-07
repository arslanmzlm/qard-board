<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyField;
use App\Models\Field;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
    public function list(Request $request): Response
    {
        return Inertia::render('Company/List', [
            'companies' => Company::query()
                ->when($request->get('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                    $query->orWhere('slug', 'like', "%{$search}%");
                    $query->orWhere('title', 'like', "%{$search}%");
                    $query->orWhere('subtitle', 'like', "%{$search}%");
                    $query->orWhere('description', 'like', "%{$search}%");
                    $query->orWhere('phone', 'like', "%{$search}%");
                    $query->orWhere('email', 'like', "%{$search}%");
                    $query->orWhere('website', 'like', "%{$search}%");
                    $query->orWhere('address', 'like', "%{$search}%");
                })
                ->orderByDesc('id')
                ->paginate(15)
                ->withQueryString(),
            'filters' => $request->only(['search']),
            'logoPath' => Company::LOGO_PATH,
        ]);
    }

    public function show(Company $company)
    {
        $theme = $company->theme ?? Company::DEFAULT_THEME;

        return view("cards/{$theme}", [
            'company' => $company,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Company/Create', [
            'themes' => Company::THEMES,
            'fields' => Field::orderBy('name')->get(),
            'defaults' => [
                'survey_title' => trans('messages.company.defaults.survey_title'),
                'fields_title' => trans('messages.company.defaults.fields_title'),
                'address_link_title' => trans('messages.company.defaults.address_link_title'),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $company = new Company();
        $this->assignAttributes($validated, $company, $request);

        return to_route('company.edit', ['company' => $company])->with('toast', trans('messages.company.create.success'));
    }

    public function edit(Company $company): Response
    {
        return Inertia::render('Company/Edit', [
            'company' => $company->load('fields'),
            'themes' => Company::THEMES,
            'logoPath' => Company::LOGO_PATH,
            'coverPath' => Company::COVER_PATH,
            'fields' => Field::orderBy('name')->get(),
            'defaults' => [
                'survey_title' => trans('messages.company.defaults.survey_title'),
                'fields_title' => trans('messages.company.defaults.fields_title'),
                'address_link_title' => trans('messages.company.defaults.address_link_title'),
            ],
        ]);
    }

    public function update(Company $company, Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules($company));

        $this->assignAttributes($validated, $company, $request);

        return to_route('company.list')->with('toast', trans('messages.company.update.success'));
    }

    public function destroy(Company $company): RedirectResponse
    {
        try {
            $company->delete();

            return to_route('company.list')->with('toast', trans('messages.company.destroy.success'));
        } catch (\Exception $exception) {
            return to_route('company.list')->with('toast', ['type' => 'error', 'message' => trans('messages.company.destroy.error')]);
        }
    }

    public function active(Company $company): RedirectResponse
    {
        if ($company->state === Company::STATE_ACTIVE) {
            return to_route('company.list')->with('toast', trans('messages.company.state.always_active'));
        }

        $company->state = Company::STATE_ACTIVE;
        $company->save();

        return to_route('company.list')->with('toast', trans('messages.company.state.active'));
    }

    public function passive(Company $company): RedirectResponse
    {
        if ($company->state === Company::STATE_PASSIVE) {
            return to_route('company.list')->with('toast', trans('messages.company.state.always_passive'));
        }

        $company->state = Company::STATE_PASSIVE;
        $company->save();

        return to_route('company.list')->with('toast', trans('messages.company.state.passive'));
    }

    public function rules(?Company $company = null)
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique(Company::class, 'slug')
                    ->ignore($company?->id),
            ],
            'theme' => [
                'nullable',
                Rule::in(Company::THEMES)
            ],
            'logo' => 'nullable|image|max:1024',
            'cover' => 'nullable|image|max:1024',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'phone_title' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'email_title' => 'nullable|string|max:255',
            'website' => 'nullable|string|url|max:255',
            'website_title' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'address_link' => 'nullable|string|url',
            'address_link_title' => 'nullable|string|max:255',
            'survey_link' => 'nullable|string|url|max:255',
            'survey_title' => 'nullable|string|max:255',
            'fields_title' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'fields.*.id' => 'nullable|exists:company_fields,id',
            'fields.*.field_id' => 'nullable|exists:fields,id',
            'fields.*.order' => 'nullable|numeric',
            'fields.*.value' => 'nullable',
        ];
    }

    private function assignAttributes(array $validated, Company $company, Request $request): void
    {
        $company->name = $validated['name'];
        $company->slug = Str::slug(!empty($validated['slug']) ? $validated['slug'] : $validated['name']);
        $company->theme = $validated['theme'];
        $company->title = $validated['title'];
        $company->subtitle = $validated['subtitle'];
        $company->description = $validated['description'];
        $company->phone = $validated['phone'];
        $company->phone_title = $validated['phone_title'];
        $company->email = $validated['email'];
        $company->email_title = $validated['email_title'];
        $company->website = $validated['website'];
        $company->website_title = $validated['website_title'];
        $company->address = $validated['address'];
        $company->address_link = $validated['address_link'];
        $company->address_link_title = $validated['address_link_title'];
        $company->survey_link = $validated['survey_link'];
        $company->survey_title = $validated['survey_title'];
        $company->fields_title = $validated['fields_title'];
        $company->meta_title = $validated['meta_title'];
        $company->meta_description = $validated['meta_description'];
        $company->meta_keywords = $validated['meta_keywords'];

        if (isset($validated['logo']) && $file = $request->file('logo')) {
            $fileName = Str::slug($company->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storePubliclyAs(Company::LOGO_PATH, $fileName);
            $company->logo = $fileName;
        }

        if (isset($validated['cover']) && $file = $request->file('cover')) {
            $fileName = Str::slug($company->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storePubliclyAs(Company::COVER_PATH, $fileName);
            $company->cover = $fileName;
        }

        $company->save();

        if (isset($validated['fields'])) {
            $fields = collect($validated['fields']);

            foreach ($fields as $row) {
                $value = $row['value'];

                if (is_array($value)) {
                    if (is_array(current($value))) {
                        $value = array_map(function ($item) {
                            return ['label' => $item['label'], 'value' => $item['value'], 'copy' => $item['copy'] ?? false];
                        }, $value);
                    } else {
                        $value = array_filter($value, function ($item) {
                            return !empty($item);
                        });
                    }
                }

                if (!empty($value)) {
                    $find = [
                        'field_id' => $row['field_id'],
                        'company_id' => $company->id,
                    ];

                    $values = [
                        'field_id' => $row['field_id'],
                        'company_id' => $company->id,
                        'value' => $value,
                        'order' => $row['order'] ?? 1,
                    ];

                    CompanyField::updateOrCreate($find, $values);
                } else if (!empty($row['id'])) {
                    CompanyField::find($row['id'])->delete();
                }
            }
        }
    }
}
