<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=sofia-sans:400,600,700" rel="stylesheet"/>

    <!-- Assets -->
    @vite(['resources/css/app.css', 'resources/js/public.js'])
</head>
<body class="antialiased font-public">
<div class="mx-auto bg-gray-50 pb-4 lg:my-5 lg:max-w-screen-sm lg:border">
    @if($company->cover)
        <img src="{{ asset($company->cover_url) }}" class="w-full" alt="{{ $company->title }} Cover">
    @endif

    @if($company->logo)
        <div class="relative z-10 flex justify-center" style="margin-top: -12.5%;">
            <div class="grid h-36 w-36 place-items-center rounded-full bg-white p-6">
                <img src="{{ asset($company->logo_url) }}" class="w-full" alt="{{ $company->title }} Logo">
            </div>
        </div>
    @endif

    <div class="px-6 text-center">
        <h2 class="mt-3 text-3xl font-bold">{{ $company->title }}</h2>
        @if($company->subtitle)
            <h3 class="mt-2 text-lg text-slate-500">{{ $company->subtitle }}</h3>
        @endif

        @if($company->description)
            <p class="py-4 text-gray-800">{!! $company->description_text !!}</p>
        @endif

        <div class="flex flex-wrap gap-3">
            @if($company->phone)
                <div class="flex-1">
                    <a href="tel:{{ $company->phone }}"
                       class="flex flex-col items-center justify-center gap-1 bg-white px-4 py-5 text-xs text-red-600 transition-colors duration-300 hover:bg-red-600 hover:text-white lg:text-base">
                        <svg class="h-10 w-10"
                             viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="5.75" y="1.75" width="12.5" height="20.5" rx="1.75" stroke="currentColor"
                                  stroke-width="1.5"/>
                            <path
                                d="M9 2C9 1.44772 9.44772 1 10 1H14C14.5523 1 15 1.44772 15 2V3C15 3.55228 14.5523 4 14 4H10C9.44772 4 9 3.55228 9 3V2Z"
                                fill="currentColor"/>
                            <path d="M9 19.5H15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        @if ($company->phone_title)
                            {{ $company->phone_title }}
                        @else
                            <span class="phone">{{ $company->phone }}</span>
                        @endif
                    </a>
                </div>
            @endif

            @if($company->website)
                <div class="flex-1">
                    <a href="{{ $company->website }}" target="_blank"
                       class="flex flex-col items-center justify-center gap-1 bg-white px-4 py-5 text-xs text-red-600 transition-colors duration-300 hover:bg-red-600 hover:text-white lg:text-base">
                        <svg class="h-10 w-10"
                             viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M15.4177 9.01399C17.4205 9.17939 18.5 10.5484 18.5 12.1904C18.5 13.8241 17.4287 15.1736 15.4177 15.3396C15.4365 15.3381 15.4202 15.3382 15.3496 15.3388C15.3052 15.3392 15.2394 15.3397 15.1473 15.3401C14.9463 15.3411 14.6668 15.3416 14.334 15.342C13.9464 15.3423 13.4881 15.3423 13 15.3421L13 17.3421C13.4884 17.3423 13.9474 17.3423 14.3359 17.342C14.6693 17.3416 14.9518 17.3411 15.1565 17.3401L15.1773 17.34L15.1774 17.34C15.339 17.3393 15.5137 17.3385 15.5823 17.3328C18.6252 17.0816 20.5 14.8701 20.5 12.1904C20.5 9.51886 18.6334 7.27275 15.5823 7.02078C15.5137 7.01511 15.3389 7.01432 15.1773 7.01359L15.1565 7.01349C14.9518 7.01256 14.6693 7.01197 14.3359 7.01165C13.9474 7.01128 13.4884 7.01127 13 7.01149L13 9.01149C13.4881 9.01127 13.9464 9.01128 14.334 9.01165C14.6667 9.01197 14.9463 9.01255 15.1473 9.01347C15.2393 9.01389 15.3051 9.01444 15.3495 9.01481L15.3496 9.01481C15.4201 9.0154 15.4364 9.01554 15.4177 9.01399ZM11 15.3403C10.0331 15.339 9.16041 15.3375 8.6924 15.3367L8.69133 15.3367L8.3356 15.3362C7.18885 15.3362 6.37375 14.9553 5.84591 14.4174C5.31231 13.8737 5 13.0958 5 12.1766C5 11.2575 5.31231 10.4797 5.84588 9.93603C6.37371 9.39821 7.18881 9.01737 8.3356 9.01737L8.68952 9.0168C9.15681 9.01601 10.0311 9.01453 11 9.01331L11 7.01331C10.0274 7.01453 9.15265 7.01602 8.68662 7.01681L8.68648 7.01681L8.3356 7.01737C6.7207 7.01737 5.36801 7.56761 4.41846 8.53515C3.47465 9.49684 3 10.7987 3 12.1766C3 13.5546 3.47465 14.8565 4.41843 15.8182C5.36796 16.7858 6.72066 17.3362 8.3356 17.3362L8.68798 17.3367C9.15436 17.3375 10.0284 17.339 11 17.3403L11 15.3403Z"
                                  fill="currentColor"/>
                            <path d="M15.5 12.1681L8 12.1681" stroke="currentColor" stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                        {{ $company->website_title ?? $company->website }}
                    </a>
                </div>
            @endif

            @if($company->email)
                <div class="flex-1">
                    <a href="mailto:{{ $company->email }}"
                       class="flex flex-col items-center justify-center gap-1 bg-white px-4 py-5 text-xs text-red-600 transition-colors duration-300 hover:bg-red-600 hover:text-white lg:text-base">
                        <svg class="h-10 w-10"
                             viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4 7L10.94 11.3375C11.5885 11.7428 12.4115 11.7428 13.06 11.3375L20 7M5 18H19C20.1046 18 21 17.1046 21 16V8C21 6.89543 20.1046 6 19 6H5C3.89543 6 3 6.89543 3 8V16C3 17.1046 3.89543 18 5 18Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"/>
                        </svg>
                        {{ $company->email_title ?? $company->email }}
                    </a>
                </div>
            @endif
        </div>

        <div class="mt-3 flex gap-3">
            @if ($company->address)
                <div class="flex-1">
                    <a href="{{ $company->address_link }}" target="_blank"
                       class="flex flex-col items-center justify-center gap-1 bg-white px-4 py-5 text-xs text-red-600 transition-colors duration-300 hover:bg-red-600 hover:text-white lg:text-base">
                        <svg class="h-10 w-10"
                             viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="2"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M15.5349 8.46449L10.5852 10.5858L8.46387 15.5356L13.4136 13.4142L15.5349 8.46449ZM10.9996 13C11.5519 13.5523 12.4474 13.5523 12.9997 13C13.5519 12.4477 13.5519 11.5523 12.9997 11C12.4474 10.4477 11.5519 10.4477 10.9996 11C10.4473 11.5523 10.4473 12.4477 10.9996 13Z"
                                  fill="currentColor"/>
                            <path
                                d="M10.5852 10.5858L10.1256 10.3888C10.1762 10.2708 10.2702 10.1768 10.3882 10.1262L10.5852 10.5858ZM15.5349 8.46449L15.338 8.00491C15.5259 7.92438 15.7439 7.96636 15.8885 8.11093C16.0331 8.2555 16.075 8.47352 15.9945 8.66145L15.5349 8.46449ZM8.46387 15.5356L8.66083 15.9951C8.47291 16.0757 8.25488 16.0337 8.11031 15.8891C7.96574 15.7445 7.92376 15.5265 8.00429 15.3386L8.46387 15.5356ZM13.4136 13.4142L13.8732 13.6112C13.8226 13.7292 13.7286 13.8232 13.6106 13.8738L13.4136 13.4142ZM12.9997 13L12.6461 12.6465L12.6461 12.6465L12.9997 13ZM12.9997 11L12.6461 11.3535L12.6461 11.3535L12.9997 11ZM10.9996 11L11.3532 11.3535L11.3532 11.3535L10.9996 11ZM10.3882 10.1262L15.338 8.00491L15.7319 8.92406L10.7821 11.0454L10.3882 10.1262ZM8.00429 15.3386L10.1256 10.3888L11.0448 10.7828L8.92344 15.7325L8.00429 15.3386ZM13.6106 13.8738L8.66083 15.9951L8.26691 15.076L13.2167 12.9547L13.6106 13.8738ZM15.9945 8.66145L13.8732 13.6112L12.954 13.2173L15.0754 8.26753L15.9945 8.66145ZM13.3532 13.3536C12.6056 14.1011 11.3936 14.1011 10.6461 13.3536L11.3532 12.6465C11.7102 13.0035 12.2891 13.0035 12.6461 12.6465L13.3532 13.3536ZM13.3532 10.6464C14.1008 11.394 14.1008 12.606 13.3532 13.3536L12.6461 12.6465C13.0031 12.2894 13.0031 11.7106 12.6461 11.3535L13.3532 10.6464ZM10.6461 10.6464C11.3936 9.89886 12.6056 9.89886 13.3532 10.6464L12.6461 11.3535C12.2891 10.9965 11.7102 10.9965 11.3532 11.3535L10.6461 10.6464ZM10.6461 13.3536C9.89849 12.606 9.89849 11.394 10.6461 10.6464L11.3532 11.3535C10.9961 11.7106 10.9961 12.2894 11.3532 12.6465L10.6461 13.3536Z"
                                fill="currentColor"/>
                        </svg>
                        <addres>{!! $company->address_text !!}</addres>
                    </a>
                </div>
            @endif

            @if($company->survey_link)
                <div class="flex-1">
                    <a href="{{ $company->address_link }}" target="_blank"
                       class="flex h-full flex-col items-center justify-center gap-1 bg-white px-4 py-5 text-xs text-red-600 transition-colors duration-300 hover:bg-red-600 hover:text-white lg:text-base">
                        <svg class="h-10 w-10"
                             viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.5245 3.46353C11.6741 3.00287 12.3259 3.00287 12.4755 3.46353L14.1329 8.56434C14.1998 8.77035 14.3918 8.90983 14.6084 8.90983H19.9717C20.4561 8.90983 20.6575 9.52964 20.2656 9.81434L15.9266 12.9668C15.7514 13.0941 15.678 13.3198 15.745 13.5258L17.4023 18.6266C17.552 19.0873 17.0248 19.4704 16.6329 19.1857L12.2939 16.0332C12.1186 15.9059 11.8814 15.9059 11.7061 16.0332L7.3671 19.1857C6.97524 19.4704 6.448 19.0873 6.59768 18.6266L8.25503 13.5258C8.32197 13.3198 8.24864 13.0941 8.07339 12.9668L3.73438 9.81434C3.34253 9.52964 3.54392 8.90983 4.02828 8.90983H9.39159C9.6082 8.90983 9.80018 8.77035 9.86712 8.56434L11.5245 3.46353Z"
                                fill="currentColor"/>
                        </svg>
                        {{ $company->survey_title ?? trans('messages.company.defaults.survey_title') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if ($company->platformAccounts()->exists())
        <div
            class="mt-8 text-center text-2xl font-bold text-slate-800">{{ $company->platforms_title ?? trans('messages.company.defaults.platforms_title') }}</div>
        <div class="mt-3 flex flex-wrap justify-center gap-4">
            @foreach($company->platformAccounts as $account)
                <a href="{{ $account->link }}" target="_blank"
                   class="rounded-full transition-transform duration-300 hover:scale-125"
                   title="{{$account->platform->name}}">
                    <img class="h-[4.125rem]" src="{{ $account->platform->logo_url }}"
                         alt="{{ $account->platform->name }} Logo">
                </a>
            @endforeach
        </div>
    @endif

    @if ($company->bankAccounts()->exists())
        <div class="my-8 bg-slate-300 h-[2px]"></div>

        <div
            class="text-center text-2xl font-bold text-slate-800">{{ $company->banks_title ?? trans('messages.company.defaults.banks_title') }}</div>
        <div class="mt-3 space-y-6">
            @foreach($company->bankAccounts as $account)
                <div class="text-center">
                    <img class="mx-auto h-14" src="{{ asset($account->bank->logo_url) }}"
                         alt="{{ $account->bank->name }} Logo">

                    <div class="font-semibold mt-1.5">{{ $account->name }}</div>

                    <button
                        class="border border-transparent bg-red-600 px-8 py-2 text-sm font-semibold tracking-widest text-white transition duration-150 ease-in-out clipboard-btn mt-1.5 hover:bg-red-500 focus:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700"
                        data-clipboard-text="{{ $account->iban }}">
                        IBAN'ı Kopyala
                    </button>
                </div>
            @endforeach
        </div>
    @endif

</div>
</body>
</html>
