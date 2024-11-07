<script setup>
import {ref} from 'vue'
import {Head, useForm} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Toastify from "toastify-js";
import colors from "tailwindcss/colors.js";
import DangerButton from "@/Components/DangerButton.vue";
import {getTypeTitle} from "@/utilities.js";

defineProps({
    types: Array,
    errors: Object
});

const logoPreview = ref();

function logoChanged(event) {
    const file = event.target.files[0];

    if (file) {
        if (!file.type.startsWith("image/")) {
            Toastify({
                text: "Yüklenen dosya görsel olmalıdır!",
                duration: 3000,
                gravity: "top",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: colors.red["500"],
                },
                offset: {
                    y: 80,
                },
            }).showToast();

            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            logoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);

        form.logo = file;
    }
}

const form = useForm({
    type: null,
    name: null,
    logo: null,
    values: [],
});

function addValue() {
    if (form.type === 'card') {
        form.values.push('');
    }
}

function deleteValue(index) {
    form.values.splice(index, 1)
}
</script>

<template>
    <Head title="Alan Ekle"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Alan Ekle</h2>
        </template>

        <div class="py-8">
            <form @submit.prevent="form.post(route('field.store'))">
                <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg">
                        <div class="grid grid-cols-1 gap-5 lg:gap-6">
                            <div class="col-span-1">
                                <label for="txtName">İsim</label>
                                <input v-model="form.name"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtName" name="name" type="text" autocomplete="off">
                                <div class="is-invalid" v-if="errors.name">{{ errors.name }}</div>
                            </div>
                            <div class="col-span-1">
                                <label for="selectType">Tip</label>
                                <select v-model="form.type" name="type" id="selectType"
                                        class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option v-for="(type, index) in types" :value="type" :key="index">{{
                                            getTypeTitle(type)
                                        }}
                                    </option>
                                </select>
                                <div class="is-invalid" v-if="errors.type">{{ errors.type }}</div>
                            </div>
                            <div v-if="form.type === 'card'" class="border border-gray-300 p-4 rounded-md">
                                <div>Firma eklerken girilmesi gereken başlıkları belirtiniz.</div>
                                <hr class="my-3 border-gray-300">
                                <div class="space-y-4">
                                    <div v-for="(value, index) in form.values" :key="index"
                                         class="flex items-center gap-3">
                                        <input v-model="form.values[index]"
                                               class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                               :id="`txtValue${index}`" :name="`values[${index}]`" type="text"
                                               autocomplete="off">
                                        <DangerButton @click="deleteValue(index)" type="button">Kaldır</DangerButton>
                                    </div>
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-gray-900"
                                        @click="addValue"
                                    >Başlık Ekle
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <label for="fileLogo">Logo</label>
                                <input
                                    class="mt-1 block w-full rounded-md border border-gray-300 p-2 placeholder:text-slate-400/70 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="fileLogo" name="logo" type="file" accept="image/*"
                                    @change="logoChanged($event)">
                                <div class="is-invalid" v-if="errors.logo">{{ errors.logo }}</div>
                                <div v-if="logoPreview" class="mt-2">
                                    <img
                                        :src="logoPreview"
                                        alt="Logo Önizlemesi"
                                        class="max-w-full max-h-[500px]"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button
                            type="submit"
                            class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-gray-900"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >Gönder
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
