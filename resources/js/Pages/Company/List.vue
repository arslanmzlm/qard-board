<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import Pagination from "@/Components/Pagination.vue";
import {ref, watch} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import _ from "lodash";
import {formatDateToLocale} from "@/Core/helpers.js"

const states = {
    created: {
        title: "Beklemede",
        classes: "bg-teal-500 border-teal-600",
    },
    active: {
        title: "Aktif",
        classes: "bg-blue-500 border-blue-600",
    },
    passive: {
        title: "Pasif",
        classes: "bg-amber-500 border-amber-600",
    },
};

const {filters} = defineProps({companies: Object, logoPath: String, filters: Object});

const selectedForDeletion = ref(null);

const search = ref(filters?.search ?? null);

watch(search, _.debounce(function (value) {
    let params;
    if (value) {
        params = {
            search: value
        }
    }
    router.get(route('company.list'), params, {preserveState: true});
}, 100));
</script>

<template>
    <Head title="Firmalar"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Firmalar</h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
                <div class="mb-4 flex items-center justify-end gap-4">
                    <input v-model="search"
                           class="w-1/5 rounded-md border border-gray-300 px-2 text-sm shadow-sm py-1.5 focus:border-blue-500 focus:ring-blue-500"
                           id="txtSearch" name="search" type="search" autocomplete="off" placeholder="Arama yapın">

                    <Link
                        :href="route('company.create')"
                        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-gray-900"
                    >Firma Ekle
                    </Link
                    >
                </div>

                <div class="relative overflow-x-auto bg-white p-5 shadow-sm sm:rounded-lg">
                    <table
                        class="table w-full table-auto border-collapse border border-slate-400 bg-white text-sm shadow-sm dark:border-slate-500 dark:bg-slate-200">
                        <thead class="bg-slate-50 dark:bg-slate-700">
                        <tr>
                            <th class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-400">
                                #
                            </th>
                            <th class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-400">
                                Logo
                            </th>
                            <th class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-400">
                                Firma
                            </th>
                            <th class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-400">
                                Durum
                            </th>
                            <th class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-400">
                                Slug (SEO Linki)
                            </th>
                            <th class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-400">
                                Telefon
                            </th>
                            <th class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-400">
                                Son Düzenlenme Tarihi
                            </th>
                            <th class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-400">
                                İşlemler
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(company, index) in companies.data" :key="company.id">
                            <th scope="row"
                                class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                {{ companies.from + index }}
                            </th>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                <img v-if="company.logo" class="mx-auto h-16 max-w-xs object-cover min-w-[4rem]"
                                     :src="`/${logoPath}/${company.logo}`" :alt="company.name">
                            </td>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center font-medium text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                {{ company.name }}
                            </td>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                <span class="rounded border text-sm text-white p-1.5"
                                      :class="states[company.state].classes">
                                    {{ states[company.state].title }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                <a
                                    :href="route('public.card', {company})"
                                    target="_blank"
                                    class="text-blue-600 hover:text-blue-700"
                                >
                                    {{ company.slug }}
                                </a
                                >
                            </td>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                {{ company.phone }}
                            </td>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                {{ formatDateToLocale(company.updated_at) }}
                            </td>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                <div class="text-center space-x-4">
                                    <DangerButton @click="selectedForDeletion = company">Sil</DangerButton>
                                    <Link
                                        :href="route('company.show', {company})"
                                        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-gray-900"
                                    >Önizle
                                    </Link
                                    >
                                    <Link
                                        v-if="company.state === 'created' || company.state === 'passive'"
                                        method="post"
                                        as="button"
                                        :href="route('company.active', {company})"
                                        class="inline-flex items-center rounded-md border border-transparent bg-sky-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-sky-600 focus:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-800 focus:ring-offset-2 active:bg-sky-400"
                                    >Aktif Et
                                    </Link
                                    >
                                    <Link
                                        v-else
                                        method="post"
                                        as="button"
                                        :href="route('company.passive', {company})"
                                        class="inline-flex items-center rounded-md border border-transparent bg-yellow-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-yellow-600 focus:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-800 focus:ring-offset-2 active:bg-yellow-400"
                                    >Pasif Et
                                    </Link
                                    >
                                    <Link
                                        :href="route('company.edit', {company})"
                                        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-gray-900"
                                    >Düzenle
                                    </Link
                                    >
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <pagination v-if="companies.last_page > 1" :links="companies.links"></pagination>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="selectedForDeletion !== null" @close="selectedForDeletion = null">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Veriyi silmek istediğinizden emin misiniz?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Silmek istediğiniz veriler geri getirilemez ve bağlantılı veriler varsa onlarda silinir.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="selectedForDeletion = null">İptal</SecondaryButton>

                <Link
                    v-if="selectedForDeletion"
                    class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out ms-3 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700"
                    method="post"
                    as="button"
                    :href="route('company.destroy', {company: selectedForDeletion})"
                    @click="selectedForDeletion = null"
                >
                    Sil
                </Link>
            </div>
        </div>
    </Modal>
</template>
