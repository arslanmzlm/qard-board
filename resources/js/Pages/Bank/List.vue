<script setup>
import {ref} from "vue";
import {Head, Link} from '@inertiajs/vue3';
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import {formatDateToLocale} from "@/Core/helpers.js";

defineProps({banks: Object, logoPath: String});

const selectedForDeletion = ref(null);
</script>

<template>
    <Head title="Bankalar"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Bankalar</h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
                <div class="mb-4 text-end">
                    <Link
                        :href="route('bank.create')"
                        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-gray-900"
                    >Banka Ekle
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
                                Banka
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
                        <tr v-for="(bank, index) in banks.data" :key="bank.id">
                            <th scope="row" class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                {{ banks.from + index }}
                            </th>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                <img v-if="bank.logo" class="mx-auto max-h-20 max-w-sm"
                                     :src="`/${logoPath}/${bank.logo}`" :alt="bank.name">
                            </td>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                {{ bank.name }}
                            </td>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                {{ formatDateToLocale(bank.updated_at) }}
                            </td>
                            <td class="whitespace-nowrap border border-slate-300 p-4 text-center text-slate-500 dark:border-slate-700 dark:text-slate-600">
                                <div class="text-center space-x-4">
                                    <DangerButton @click="selectedForDeletion = bank">Sil</DangerButton>
                                    <Link
                                        :href="route('bank.edit', {bank})"
                                        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-gray-900"
                                    >Düzenle
                                    </Link
                                    >
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <pagination v-if="banks.last_page > 1" :links="banks.links"></pagination>
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
                    :href="route('bank.destroy', {bank: selectedForDeletion})"
                    @click="selectedForDeletion = null"
                >
                    Sil
                </Link>
            </div>
        </div>
    </Modal>
</template>
