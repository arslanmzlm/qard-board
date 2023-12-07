<script setup>
import {ref, watch} from 'vue'
import {Head, useForm} from '@inertiajs/vue3';
import slugify from "slugify";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {formatIncompletePhoneNumber} from "libphonenumber-js";
import Toastify from "toastify-js";
import colors from "tailwindcss/colors.js";

const {company, logoPath, coverPath, banks, platforms} = defineProps({
    company: Object,
    themes: Array,
    logoPath: String,
    coverPath: String,
    banks: Array,
    platforms: Array,
    defaults: Object,
    errors: Object,
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
    banks_title: company.banks_title,
    platforms_title: company.platforms_title,
    meta_title: company.meta_title,
    meta_description: company.meta_description,
    meta_keywords: company.meta_keywords,
    bank_accounts: [],
    platform_accounts: [],
});

banks.forEach((bank) => {
    let account = company.bank_accounts.find((item) => {
        return item.bank_id === bank.id;
    });

    form.bank_accounts.push({
        id: null,
        bank_name: bank.name,
        bank_id: bank.id,
        iban: account ? account.iban : "",
        name: account ? account.name : "",
    });
});

platforms.forEach((platform) => {
    let account = company.platform_accounts.find((item) => {
        return item.platform_id === platform.id;
    });

    form.platform_accounts.push({
        id: null,
        name: platform.name,
        platform_id: platform.id,
        link: account ? account.link : "",
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
                            <div class="col-span-full -mx-6 bg-gray-800 p-4 pl-6 font-medium text-white">Banka
                                Hesapları
                            </div>
                            <div class="col-span-full">
                                <label for="txtBanksTitle">Banka Hesapları Alanı Başlığı</label>
                                <input v-model="form.banks_title"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtBanksTitle" name="banks_title" type="text" autocomplete="off"
                                       :placeholder="`Eğer boş bırakılırsa '${defaults.banks_title}' yazar`">
                                <div class="is-invalid" v-if="errors.banks_title">{{ errors.banks_title }}</div>
                            </div>
                            <div v-for="(bank, index) in form.bank_accounts" :key="bank.bank_id" class="col-span-full">
                                <input type="hidden" :name="`bank_accounts[${index}][bank_id]`" :value="bank.bank_id">
                                <div class="text-lg font-bold">{{ bank.bank_name }}</div>
                                <div class="grid gap-4 xl:grid-cols-3 xl:gap-6">
                                    <div class="xl:col-span-1">
                                        <label :for="`txtBankAccountIban${bank.bank_id}`">IBAN</label>
                                        <input
                                            v-model="bank.iban"
                                            class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            :id="`txtBankAccountIban${bank.bank_id}`"
                                            :name="`bank_accounts[${index}][iban]`"
                                            type="text"
                                            autocomplete="off">
                                        <div class="is-invalid" v-if="errors[`bank_accounts.${index}.iban`]">
                                            {{ errors[`bank_accounts.${index}.iban`] }}
                                        </div>
                                    </div>
                                    <div class="xl:col-span-2">
                                        <label :for="`txtBankAccountName${bank.bank_id}`">İsim</label>
                                        <input
                                            v-model="bank.name"
                                            class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            :id="`txtBankAccountName${bank.bank_id}`"
                                            :name="`bank_accounts[${index}][name]`"
                                            type="text"
                                            autocomplete="off">
                                        <div class="is-invalid" v-if="errors[`bank_accounts.${index}.name`]">
                                            {{ errors[`bank_accounts.${index}.name`] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-full -mx-6 bg-gray-800 p-4 pl-6 font-medium text-white">Platform
                                Hesapları
                            </div>
                            <div class="col-span-full">
                                <label for="txtPlatformsTitle">Platformlar Alanı Başlığı</label>
                                <input v-model="form.platforms_title"
                                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       id="txtPlatformsTitle" name="platforms_title" type="text" autocomplete="off"
                                       :placeholder="`Eğer boş bırakılırsa '${defaults.platforms_title}' yazar`">
                                <div class="is-invalid" v-if="errors.platforms_title">{{ errors.platforms_title }}</div>
                            </div>
                            <div v-for="(platform, index) in form.platform_accounts" :key="platform.platform_id"
                                 class="col-span-full">
                                <input type="hidden" :name="`platform_accounts[${index}][platform_id]`"
                                       :value="platform.platform_id">
                                <label :for="`txtPlatformAccount${platform.platform_id}`">{{ platform.name }}
                                    Linki</label>
                                <input
                                    v-model="platform.link"
                                    class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :id="`txtPlatformAccount${platform.platform_id}`"
                                    :name="`platform_accounts[${index}][link]`" type="text"
                                    autocomplete="off">
                                <div class="is-invalid" v-if="errors[`platform_accounts.${index}.link`]">
                                    {{ errors[`platform_accounts.${index}.link`] }}
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
