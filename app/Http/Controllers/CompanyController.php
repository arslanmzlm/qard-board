<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Platform;
use App\Models\PlatformAccount;
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
            'banks' => Bank::orderBy('name')->get(),
            'platforms' => Platform::orderBy('name')->get(),
            'defaults' => [
                'survey_title' => trans('messages.company.defaults.survey_title'),
                'platforms_title' => trans('messages.company.defaults.platforms_title'),
                'banks_title' => trans('messages.company.defaults.banks_title'),
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
            'company' => $company->load(['bankAccounts', 'platformAccounts']),
            'themes' => Company::THEMES,
            'logoPath' => Company::LOGO_PATH,
            'coverPath' => Company::COVER_PATH,
            'banks' => Bank::orderBy('name')->get(),
            'platforms' => Platform::orderBy('name')->get(),
            'defaults' => [
                'survey_title' => trans('messages.company.defaults.survey_title'),
                'platforms_title' => trans('messages.company.defaults.platforms_title'),
                'banks_title' => trans('messages.company.defaults.banks_title'),
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
            'banks_title' => 'nullable|string|max:255',
            'platforms_title' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'bank_accounts.*.bank_id' => 'nullable|exists:banks,id',
            'bank_accounts.*.iban' => 'nullable|string|max:255',
            'bank_accounts.*.name' => 'nullable|string|max:255',
            'platform_accounts.*.platform_id' => 'nullable|exists:platforms,id',
            'platform_accounts.*.link' => 'nullable|string|url|max:255',
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
        $company->banks_title = $validated['banks_title'];
        $company->platforms_title = $validated['platforms_title'];
        $company->meta_title = $validated['meta_title'];
        $company->meta_description = $validated['meta_description'];
        $company->meta_keywords = $validated['meta_keywords'];

        if (isset($validated['logo']) && $file = $request->file('logo')) {
            $fileName = Str::slug($company->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storeAs(Company::LOGO_STORAGE_PATH, $fileName);
            $company->logo = $fileName;
        }

        if (isset($validated['cover']) && $file = $request->file('cover')) {
            $fileName = Str::slug($company->name) . '-' . rand(10000, 99999) . '.' . $file->extension();
            $file->storeAs(Company::COVER_STORAGE_PATH, $fileName);
            $company->cover = $fileName;
        }

        $company->save();

        if (isset($validated['bank_accounts'])) {
            $bank_accounts = collect($validated['bank_accounts']);

            foreach ($bank_accounts as $row) {
                if (!empty($row['iban'])) {
                    $find = [
                        'bank_id' => $row['bank_id'],
                        'company_id' => $company->id,
                    ];

                    $values = [
                        'bank_id' => $row['bank_id'],
                        'company_id' => $company->id,
                        'iban' => $row['iban'],
                        'name' => $row['name'],
                    ];

                    BankAccount::updateOrCreate($find, $values);
                }
            }

            if ($company->bankAccounts()->exists()) {
                $ids = $bank_accounts->whereNotNull('iban')->pluck('bank_id');
                $company->bankAccounts()->whereNotIn('bank_id', $ids)->delete();
            }
        }

        if (isset($validated['platform_accounts'])) {
            $platform_accounts = collect($validated['platform_accounts']);

            foreach ($validated['platform_accounts'] as $row) {
                if (!empty($row['link'])) {
                    $find = [
                        'platform_id' => $row['platform_id'],
                        'company_id' => $company->id,
                    ];

                    $values = [
                        'platform_id' => $row['platform_id'],
                        'company_id' => $company->id,
                        'link' => $row['link'],
                    ];

                    PlatformAccount::updateOrCreate($find, $values);
                }
            }

            if ($company->platformAccounts()->exists()) {
                $ids = $platform_accounts->whereNotNull('link')->pluck('platform_id');
                $company->platformAccounts()->whereNotIn('platform_id', $ids)->delete();
            }
        }
    }
}
