<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-blue-500 text-start text-base font-medium bg-blue-200 focus:outline-none focus:text-slate-800 focus:bg-blue-200 focus:border-blue-500 transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:text-gray-800 focus:bg-blue-50 focus:border-blue-300 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
