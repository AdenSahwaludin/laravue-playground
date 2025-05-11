<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const breadcrumbs = ref([
    {
        title: 'Belajar',
        href: '/belajar',
    },
    {
        title: 'Say Hello',
        href: '/belajar/say-hello',
    },
]);

const state = ref({
    count: 0,
    firstName: '',
    lastName: '',
});

const incrementCount = () => {
    console.log('incrementCount called');
    state.value.count++;
};

const click = () => {
    state.value.firstName = document.getElementById('firstName').value;
    state.value.lastName = document.getElementById('lastName').value;
};

const fullName = computed((oldName) => {
    console.log('Old name' + oldName);
    return `${state.value.firstName} ${state.value.lastName}`;
});
</script>

<template>
    <Head title="Say Hello" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="dark:bg-sidebar m-4 bg-gray-100 p-4">
            <div class="flex flex-col md:flex-row">
                <!-- Left column (50%) -->
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4">
                        <button @click="incrementCount">Count {{ state.count }}</button>
                        <input id="firstName" type="text" placeholder="First Name" class="rounded border p-2" />
                        <input id="lastName" type="text" placeholder="Last Name" class="rounded border p-2" />
                        <button @click="click" class="rounded bg-white px-4 py-2 text-black">Click</button>
                        <p class="m-auto text-2xl">Hello {{ fullName }}</p>
                    </div>
                </div>
                <!-- Right column (50%) -->
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4"></div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
