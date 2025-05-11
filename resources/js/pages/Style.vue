<script setup>
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs = ref([
    {
        title: 'Belajar',
        href: '/belajar',
    },
    {
        title: 'Style',
        href: '/belajar/style',
    },
]);
const red = ref(false);
const bold = ref(false);

function toggleRed() {
    red.value = !red.value;
}
function toggleBold() {
    bold.value = !bold.value;
}
</script>

<template>
    <Head title="Style" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="dark:bg-sidebar m-4 bg-gray-100 p-4">
            <div class="flex flex-col md:flex-row">
                <!-- Left column (50%) -->
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4">
                        <div class="">
                            <h1 :class="{ 'text-red-500': red, 'font-bold uppercase': bold }">This is a heading</h1>
                            <div class="flex gap-4">
                                <Button class="text-red-500" @click="toggleRed">Red</Button>
                                <Button class="text-bold text-black uppercase" @click="toggleBold">Bold</Button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right column (50%) -->
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4">
                        <div class=""></div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
