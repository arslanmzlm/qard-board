<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

defineProps({counts: Object});
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <div
                        class="relative col-span-1 flex h-40 overflow-hidden rounded-md bg-white p-5 text-teal-400 shadow-md">
                        <div class="flex flex-grow flex-col justify-between">
                            <div class="text-3xl font-semibold">Kayıtlı Firma</div>
                            <div class="text-6xl font-normal">{{ counts.company }}</div>
                        </div>

                        <svg class="absolute -right-5 -bottom-5 w-1/3 -rotate-12" viewBox="2 2 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4 9H12H20C20.5523 9 21 9.44772 21 10V20C21 20.5523 20.5523 21 20 21H16H8H4C3.44772 21 3 20.5523 3 20V10C3 9.44772 3.44772 9 4 9Z"
                                stroke="currentColor" stroke-linejoin="round"/>
                            <path d="M7 12V18" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M17 12V18" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 12V18" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M8 7V4H16V7" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div
                        class="relative col-span-1 flex h-40 overflow-hidden rounded-md bg-white p-5 text-violet-500 shadow-md">
                        <div class="flex flex-grow flex-col justify-between">
                            <div class="text-3xl font-semibold">Kayıtlı Banka</div>
                            <div class="text-6xl font-normal">{{ counts.bank }}</div>
                        </div>

                        <svg class="absolute -right-5 -bottom-5 w-1/3 rotate-12 -scale-x-100" viewBox="2 2 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.16894 21.8995L19.4357 11.6327C19.6505 11.4179 19.756 11.1171 19.7225 10.8152L19.1568 5.72404C19.1051 5.2592 18.7382 4.89224 18.2733 4.84059L13.1822 4.27491C12.8802 4.24136 12.5794 4.34687 12.3646 4.56168L2.09787 14.8284C1.70735 15.219 1.70735 15.8521 2.09787 16.2426L7.75472 21.8995C8.14525 22.29 8.77841 22.29 9.16894 21.8995Z"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="14.1205" cy="9.88055" r="2" transform="rotate(45 14.1205 9.88055)"
                                    stroke="currentColor"
                                    stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div
                        class="relative col-span-1 flex h-40 overflow-hidden rounded-md bg-white p-5 text-rose-500 shadow-md">
                        <div class="flex flex-grow flex-col justify-between">
                            <div class="text-3xl font-semibold">Kayıtlı Platform</div>
                            <div class="text-6xl font-normal">{{ counts.platform }}</div>
                        </div>

                        <svg class="absolute -right-5 -bottom-5 w-1/3 rotate-45 -scale-x-100" viewBox="2 2 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7" cy="12" r="2" stroke="currentColor" stroke-linejoin="round"/>
                            <circle cx="17" cy="6" r="2" stroke="currentColor" stroke-linejoin="round"/>
                            <path d="M15 7L8.5 11" stroke="currentColor"/>
                            <circle cx="17" cy="18" r="2" stroke="currentColor" stroke-linejoin="round"/>
                            <path d="M8.5 13.5L15 17" stroke="currentColor"/>
                        </svg>
                    </div>

                    <div
                        class="relative col-span-1 flex h-40 overflow-hidden rounded-md bg-white p-5 text-blue-500 shadow-md">
                        <div class="flex flex-grow flex-col justify-between">
                            <div class="text-3xl font-semibold">Aktif Firma</div>
                            <div class="text-6xl font-normal">{{ counts.active_company }}</div>
                        </div>

                        <svg class="absolute -right-5 -bottom-5 w-1/3 -rotate-12" viewBox="2 2 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 13.4545L8.97619 15.3409C9.36262 15.7098 9.97072 15.7098 10.3571 15.3409L17 9"
                                  stroke="currentColor"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div
                        class="relative col-span-1 flex h-40 overflow-hidden rounded-md bg-white p-5 text-lime-500 shadow-md">
                        <div class="flex flex-grow flex-col justify-between">
                            <div class="text-3xl font-semibold">Beklemede Firma</div>
                            <div class="text-6xl font-normal">{{ counts.created_company }}</div>
                        </div>

                        <svg class="absolute -right-5 -bottom-5 w-1/3 -rotate-12" viewBox="2 2 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            <path d="M12 11V17" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.75 8V7H12.25V8H11.75Z" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div
                        class="relative col-span-1 flex h-40 overflow-hidden rounded-md bg-white p-5 text-amber-500 shadow-md">
                        <div class="flex flex-grow flex-col justify-between">
                            <div class="text-3xl font-semibold">Pasif Firma</div>
                            <div class="text-6xl font-normal">{{ counts.passive_company }}</div>
                        </div>

                        <svg class="absolute -right-5 -bottom-5 w-1/3 -rotate-12" viewBox="2 2 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 12H17" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
