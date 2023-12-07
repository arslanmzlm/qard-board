<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <nav class="mt-4 flex justify-center gap-3" aria-label="Page navigation example">
        <template v-for="(link, index) in links" :key="index">
            <Link v-if="link.url"
                  v-html="link.label"
                  class="flex h-9 items-center justify-center rounded px-3 leading-tight shadow-sm dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                  :class="{
                      'border border-gray-900 bg-gray-800 text-white': link.active === true,
                      'border border-gray-300 bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800': link.active === false,
                  }"
                  :aria-current="link.active ? 'page' : 'step'"
                  :href="link.url"></Link>
            <span v-else v-html="link.label" class="pointer-events-none flex h-9 cursor-pointer items-center justify-center rounded border border-gray-300 bg-white px-3 leading-tight text-gray-500 opacity-75 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"></span>
        </template>
    </nav>
</template>
