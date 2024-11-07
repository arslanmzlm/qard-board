<script setup>
import {ref, watch} from 'vue'
import {Head, useForm} from '@inertiajs/vue3';
import slugify from "slugify";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {formatIncompletePhoneNumber} from "libphonenumber-js";
import Toastify from "toastify-js";
import colors from "tailwindcss/colors.js";
import Checkbox from "@/Components/Checkbox.vue";
import _ from "lodash";

const {company, fields, logoPath, coverPath} = defineProps({
    company: Object,
    themes: Array,
    logoPath: String,
    coverPath: String,
    fields: Array,
    errors: Object,
    defaults: Object,
});

const form = useForm({
    name: company.name,
    slug: company.slug,
    theme: company.theme,
    logo: null,
    cover: null,
    title: company.title,
    subtitle: company.subtitle,
    description: company.description,
    phone: company.phone !== null ? formatIncompletePhoneNumber(company.phone, "TR") : company.phone,
    phone_title: company.phone_title,
    email: company.email,
    email_title: company.email_title,
    website: company.website,
    website_title: company.website_title,
    address: company.address,
    address_link: company.address_link,
    address_link_title: company.address_link_title,
    survey_link: company.survey_link,
    survey_title: company.survey_title,
    fields_title: company.fields_title,
    meta_title: company.meta_title,
    meta_description: company.meta_description,
    meta_keywords: company.meta_keywords,
    fields: [],
});

fields.forEach((field) => {
    let data = company.fields.find((item) => {
        return _.parseInt(item.field_id) === _.parseInt(field.id);
    });

    let val = data ? data.value : null;

    if (val === null) {
        if (field.type === 'field') {
            val = '';
        } else if (field.type === 'bank') {
            val = {
                iban: '',
                name: '',
            };
        } else if (field.type === 'card') {
            val = [];
            if (field.values && Array.isArray(field.values) && field.values.length) {
                field.values.forEach((item) => {
                    val.push({
                        label: item,
                        value: '',
                        copy: false,
                    })
                });
            }
        }
    }

    form.fields.push({
        id: data ? data.id : null,
        field_type: field.type,
        field_name: field.name,
        field_id: field.id,
        field_logo_url: field.logo_url,
        order: data ? data.order : null,
        value: val
    });
});

const logoPreview = ref(company.logo ? `/${logoPath}/${company.logo}` : null);

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

const coverPreview = ref(company.cover ? `/${coverPath}/${company.cover}` : null);

function coverChanged(event) {
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
            coverPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);

        form.cover = file;
    }
}

watch(
    () => form.slug,
    (slug) => {
        if (!slug.endsWith(' ') && !slug.endsWith('-')) {
            form.slug = slugify(slug, {lower: true});
        }
    }
);

watch(
    () => form.phone,
    (phone) => {
        if (phone.length > 1 && !['0', '4', '+', '('].includes(phone[0])) {
            phone = `0 ${phone}`;
        }
        form.phone = formatIncompletePhoneNumber(phone, 'TR');
    }
);
</script>

<template>
    <Head :title="`Firma Düzenle #${company.id}`"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Firma Düzenle #{{ company.id }}</h2>
        </template>

        <div class="py-8">
            <form @submit.prevent="form.post(route('company.update', {company}))">
                <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                        <div class="grid grid-cols-1 gap-6 xl:grid-cols-6">
                            <div class="col-span-full -mx-6 -mt-6 bg-gray-800 p-4 pl-6 font-medium text-white">Genel
                                Bilgiler
                            </div>
                            <div class="col-span-full xl:col-span-2">
                                <label for="txtName">İsim</label>
                                <input v-model="form.name"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtName" name="name" type="text" autocomplete="off">
                                <div class="is-invalid" v-if="errors.name">{{ errors.name }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-2">
                                <label for="txtSlug">Slug (SEO Linki)</label>
                                <input v-model="form.slug"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtSlug" name="slug" type="text" autocomplete="off">
                                <div class="is-invalid" v-if="errors.slug">{{ errors.slug }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-2">
                                <label for="selectTheme">Tema</label>
                                <select v-model="form.theme" name="theme" id="selectTheme"
                                        class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option v-for="(theme, index) in themes" :key="index">{{ theme }}</option>
                                </select>
                                <div class="is-invalid" v-if="errors.theme">{{ errors.theme }}</div>
                            </div>
                            <div class="col-span-full -mx-6 bg-gray-800 p-4 pl-6 font-medium text-white">Sayfa
                                Bilgileri
                            </div>
                            <div class="col-span-full xl:col-span-3">
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
                            <div class="col-span-full xl:col-span-3">
                                <label for="fileCover">Kapak Görseli</label>
                                <input
                                    class="mt-1 block w-full rounded-md border border-gray-300 p-2 placeholder:text-slate-400/70 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="fileCover" name="cover" type="file" accept="image/*"
                                    @change="coverChanged($event)">
                                <div class="is-invalid" v-if="errors.cover">{{ errors.cover }}</div>
                                <div v-if="coverPreview" class="mt-2">
                                    <img
                                        :src="coverPreview"
                                        alt="Kapak Görseli Önizlemesi"
                                        class="max-w-full max-h-[500px]"
                                    />
                                </div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtTitle">Başlık</label>
                                <input v-model="form.title"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtTitle" name="title" type="text" autocomplete="off">
                                <div class="is-invalid" v-if="errors.title">{{ errors.title }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtSubtitle">Alt Başlık</label>
                                <input v-model="form.subtitle"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtSubtitle" name="subtitle" type="text" autocomplete="off">
                                <div class="is-invalid" v-if="errors.subtitle">{{ errors.subtitle }}</div>
                            </div>
                            <div class="col-span-full">
                                <label for="textareaDescription">Açıklama</label>
                                <textarea v-model="form.description"
                                          class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          id="textareaDescription" name="description" rows="5"></textarea>
                                <div class="is-invalid" v-if="errors.description">{{ errors.description }}</div>
                            </div>
                            <div class="col-span-full -mx-6 bg-gray-800 p-4 pl-6 font-medium text-white">İletişim
                                Bilgileri
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtPhone">Telefon Numarası</label>
                                <input v-model="form.phone"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtPhone" name="phone" type="text" autocomplete="off">
                                <div class="is-invalid" v-if="errors.phone">{{ errors.phone }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtPhoneTitle">Telefon Numarası Alanı Başlığı</label>
                                <input v-model="form.phone_title"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtPhoneTitle" name="phone_title" type="text" autocomplete="off"
                                       placeholder="Eğer boş bırakılırsa telefon numarası yazar">
                                <div class="is-invalid" v-if="errors.phone_title">{{ errors.phone_title }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtEmail">E-Posta Adresi</label>
                                <input v-model="form.email"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtEmail" name="email" type="text" autocomplete="off">
                                <div class="is-invalid" v-if="errors.email">{{ errors.email }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtEmailTitle">E-Posta Adresi Alanı Başlığı</label>
                                <input v-model="form.email_title"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtEmailTitle" name="email_title" type="text" autocomplete="off"
                                       placeholder="Eğer boş bırakılırsa e-posta adresi yazar">
                                <div class="is-invalid" v-if="errors.email_title">{{ errors.email_title }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtWebsite">Websitesi</label>
                                <input v-model="form.website"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtWebsite" name="website" type="text" autocomplete="off"
                                       placeholder="https:// veya http:// ile başlamalı">
                                <div class="is-invalid" v-if="errors.website">{{ errors.website }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtWebsiteTitle">Website Alanı Başlığı</label>
                                <input v-model="form.website_title"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtWebsiteTitle" name="website_title" type="text" autocomplete="off"
                                       placeholder="Eğer boş bırakılırsa websitesi yazar">
                                <div class="is-invalid" v-if="errors.website_title">{{ errors.website_title }}</div>
                            </div>
                            <div class="col-span-full">
                                <label for="textareaAddress">Adres</label>
                                <textarea v-model="form.address"
                                          class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          id="textareaAddress" name="address" rows="4" autocomplete="off"></textarea>
                                <div class="is-invalid" v-if="errors.address">{{ errors.address }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtAddressLink">Adres Linki</label>
                                <input v-model="form.address_link"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtAddressLink" name="address_link" type="text" autocomplete="off"
                                       placeholder="Google maps vb. link">
                                <div class="is-invalid" v-if="errors.address_link">{{ errors.address_link }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtAddressLinkDescription">Adres Linki Başlığı</label>
                                <input v-model="form.address_link_title"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtAddressLinkDescription" name="address_link_title" type="text"
                                       autocomplete="off"
                                       :placeholder="`Eğer boş bırakılırsa '${defaults.address_link_title}' yazar`">
                                <div class="is-invalid" v-if="errors.address_link_title">{{
                                        errors.address_link_title
                                    }}
                                </div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtSurveyLink">Anket Linki</label>
                                <input v-model="form.survey_link"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtSurveyLink" name="survey_link" type="text" autocomplete="off">
                                <div class="is-invalid" v-if="errors.survey_link">{{ errors.survey_link }}</div>
                            </div>
                            <div class="col-span-full xl:col-span-3">
                                <label for="txtSurveyLinkTitle">Anket Linki Başlığı</label>
                                <input v-model="form.survey_title"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtSurveyLinkTitle" name="survey_title" type="text" autocomplete="off"
                                       :placeholder="`Eğer boş bırakılırsa '${defaults.survey_title}' yazar`">
                                <div class="is-invalid" v-if="errors.survey_title">{{
                                        errors.survey_title
                                    }}
                                </div>
                            </div>
                            <div class="col-span-full -mx-6 bg-gray-800 p-4 pl-6 font-medium text-white">Meta Etiketleri
                            </div>
                            <div class="col-span-full">
                                <label for="txtMetaTitlte">Meta Başlığı</label>
                                <input v-model="form.meta_title"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtMetaTitlte" name="meta_title" type="text" autocomplete="off">
                                <div class="is-invalid" v-if="errors.meta_title">{{ errors.meta_title }}</div>
                            </div>
                            <div class="col-span-full">
                                <label for="textareaMetaDescription">Meta Açıklaması</label>
                                <textarea v-model="form.meta_description"
                                          class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          id="textareaMetaDescription" name="meta_description" rows="5"></textarea>
                                <div class="is-invalid" v-if="errors.meta_description">{{
                                        errors.meta_description
                                    }}
                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="txtMetaKeywords">Meta Anahtar Kelimeleri</label>
                                <input v-model="form.meta_keywords"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtMetaKeywords" name="meta_keywords" type="text" autocomplete="off">
                                <div class="is-invalid" v-if="errors.meta_keywords">{{ errors.meta_keywords }}</div>
                            </div>
                            <div class="col-span-full -mx-6 bg-gray-800 p-4 pl-6 font-medium text-white">Hesaplar</div>
                            <div class="col-span-full">
                                <label for="txtBanksTitle">Hesaplar Alanı Başlığı</label>
                                <input v-model="form.fields_title"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtBanksTitle" name="banks_title" type="text" autocomplete="off"
                                       :placeholder="`Eğer boş bırakılırsa '${defaults.fields_title}' yazar`">
                                <div class="is-invalid" v-if="errors.fields_title">{{ errors.fields_title }}</div>
                            </div>
                            <div class="text-xl col-span-full">
                                Değerlerin doğru şekilde çalışması için kurallar;
                                <ul class="list-disc pl-6">
                                    <li>Telefon numaraları için başına "<b>tel:</b>" koymalısınız.</li>
                                    <li>E-Posta adresleri için başına "<b>mailto:</b>" koymalısınız.</li>
                                    <li>Geçerli bir url için "<b>http://</b>" veya "<b>https://</b>" ile başlamalı.</li>
                                </ul>
                            </div>
                            <div class="col-span-full space-y-4">
                                <div v-for="(field, index) in form.fields" :key="field.field_id"
                                     class="p-5 border border-gray-200 rounded-md">
                                    <input type="hidden" :name="`fields[${index}][field_id]`" :value="field.field_id">
                                    <div class="text-lg font-bold">{{ field.field_name }}</div>

                                    <img :src="field.field_logo_url" class="h-12 my-4 inline-block" alt="">

                                    <div class="flex items-start gap-4 xl:gap-6">
                                        <div>
                                            <label :for="`numberFieldOrder${field.field_id}`">Sıra Numarası</label>
                                            <input
                                                v-model="field.order"
                                                class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                :id="`numberFieldOrder${field.field_id}`"
                                                :name="`fields[${index}][order]`"
                                                type="number"
                                                autocomplete="off">
                                        </div>

                                        <div v-if="field.field_type === 'basic'" class="flex-grow">
                                            <label :for="`txtFieldValue${field.field_id}`">Değer</label>
                                            <input
                                                v-model="field.value"
                                                class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                :id="`txtFieldValue${field.field_id}`"
                                                :name="`fields[${index}][value]`"
                                                type="text"
                                                autocomplete="off">
                                        </div>
                                        <div v-else-if="field.field_type === 'bank'"
                                             class="flex flex-grow gap-4 xl:gap-6">
                                            <div class="flex-grow">
                                                <label :for="`txtFieldBankIban${field.field_id}`">IBAN</label>
                                                <input
                                                    v-model="field.value.iban"
                                                    class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                    :id="`txtFieldBankIban${field.field_id}`"
                                                    :name="`fields[${index}][iban]`"
                                                    type="text"
                                                    autocomplete="off">
                                                <div class="is-invalid" v-if="errors[`fields.${index}.iban`]">
                                                    {{ errors[`fields.${index}.value.iban`] }}
                                                </div>
                                            </div>
                                            <div class="flex-grow">
                                                <label :for="`txtFieldBankName${field.field_id}`">İsim</label>
                                                <input
                                                    v-model="field.value.name"
                                                    class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                    :id="`txtFieldBankName${field.field_id}`"
                                                    :name="`fields[${index}][name]`"
                                                    type="text"
                                                    autocomplete="off">
                                                <div class="is-invalid" v-if="errors[`fields.${index}.name`]">
                                                    {{ errors[`fields.${index}.value.name`] }}
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else-if="field.field_type === 'card'"
                                             class="flex-grow gap-4 xl:gap-6 space-y-3">
                                            <div v-for="(row, valueIndex) in field.value" :key="valueIndex"
                                                 class="flex-grow p-4 border border-gray-200 rounded-md">
                                                <div>
                                                    <label
                                                        :for="`txtFieldInputLabel${field.field_id}${valueIndex}`">Başlık</label>
                                                    <input
                                                        v-model="row.label"
                                                        class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                        :id="`txtFieldInputLabel${field.field_id}${valueIndex}`"
                                                        :name="`fields[${index}][value][${valueIndex}][label]`"
                                                        type="text"
                                                        autocomplete="off">
                                                </div>
                                                <div class="mt-2">
                                                    <label
                                                        :for="`txtFieldInput${field.field_id}${valueIndex}`"
                                                        class="mt-4">Değer</label>
                                                    <input
                                                        v-model="row.value"
                                                        class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                        :id="`txtFieldInput${field.field_id}${valueIndex}`"
                                                        :name="`fields[${index}][value][${valueIndex}][value]`"
                                                        type="text"
                                                        autocomplete="off">
                                                    <div class="is-invalid"
                                                         v-if="errors[`fields.${index}.value.${valueIndex}.value`]">
                                                        {{ errors[`fields.${index}.value.${valueIndex}.value`] }}
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <Checkbox :checked="row.copy"
                                                              :id="`chkFieldCopy${field.field_id}${valueIndex}`"
                                                              :value="true" @update:checked="row.copy = !row.copy"/>
                                                    <label :for="`chkFieldCopy${field.field_id}${valueIndex}`"
                                                           class="ml-2">Kopyalanabilir</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
                        </button
                        >
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
