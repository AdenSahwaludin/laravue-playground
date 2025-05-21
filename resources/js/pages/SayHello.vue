<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

// Breadcrumb navigasi
const breadcrumbs = [
    { title: 'Belajar', href: '/belajar' },
    { title: 'Say Hello', href: '/belajar/say-hello' },
];

// State utama
const count = ref(0);
const form = ref({
    firstName: '',
    lastName: '',
});
const submitted = ref({
    firstName: '',
    lastName: '',
});

// Handler untuk tombol submit
const handleSubmit = () => {
    submitted.value.firstName = form.value.firstName;
    submitted.value.lastName = form.value.lastName;
};

// Nama lengkap setelah submit
const fullName = computed(() => {
    return `${submitted.value.firstName} ${submitted.value.lastName}`.trim();
});
</script>

<template>
    <Head title="Say Hello" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="dark:bg-sidebar m-4 bg-gray-100 p-4">
            <div class="flex flex-col md:flex-row">
                <!-- Kolom kiri -->
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4">
                        <button class="rounded-4xl bg-white p-2 text-black" @click="count++">Count {{ count }}</button>
                        <input type="text" placeholder="First Name" class="rounded border p-2" v-model="form.firstName" />
                        <input type="text" placeholder="Last Name" class="rounded border p-2" v-model="form.lastName" />
                        <button class="rounded bg-white px-4 py-2 text-black" @click="handleSubmit">Submit</button>
                        <div v-if="fullName">Halo, {{ fullName }}</div>
                    </div>
                </div>

                <!-- Kolom kanan -->
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4"></div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
