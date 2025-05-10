<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const breadcrumbs = [
    { name: 'Home', href: '/' },
    { name: 'Belajar', href: '#' },
    { name: 'Form', href: '#', current: true },
];
</script>

<template>
    <Head title="Belajar" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="dark:bg-sidebar m-4 flex flex-col gap-4 bg-gray-100 p-4">JIRRRR</div>
    </AppLayout>
</template>
