<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs = ref([
    {
        title: 'Belajar',
        href: '/belajar',
    },
    {
        title: 'ToDoList',
        href: '/belajar/score',
    },
]);
const items = [
    {
        id: 1,
        name: 'Belajar Vue.js',
        done: true,
    },
    {
        id: 2,
        name: 'Belajar Laravel',
        done: false,
    },
    {
        id: 3,
        name: 'Belajar Inertia.js',
        done: true,
    },
];
</script>

<template>
    <Head title="Score" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="dark:bg-sidebar m-4 bg-gray-100 p-4">
            <div class="flex flex-col md:flex-row">
                <!-- Left column (50%) -->
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4">
                        <template v-for="item in items">
                            <ul v-if="item.done" :key="item.id" class="flex flex-col gap-4">
                                <!-- <li v-for="(value, key) in item">{{ key }} : {{ value }}</li> -->
                                <li>{{ item.name }}</li>
                            </ul>
                        </template>
                    </div>
                </div>
                <!-- Right column (50%) -->
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4">
                        <h1 v-for="n in 10">Angka {{ n }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
