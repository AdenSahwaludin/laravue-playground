<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const breadcrumbs = ref([
    {
        title: 'Belajar',
        href: '/belajar',
    },
    {
        title: 'Score',
        href: '/belajar/score',
    },
]);

const state = ref({});

watch(
    () => state.value.score,
    (newScore) => {
        if (newScore > 100) {
            state.value.message = 'Nilai tidak boleh lebih dari 100';
        } else if (newScore < 0) {
            state.value.message = 'Nilai tidak boleh kurang dari 0';
        } else if (newScore >= 81) {
            state.value.message = 'A';
        } else if (newScore >= 61) {
            state.value.message = 'B';
        } else if (newScore >= 41) {
            state.value.message = 'C';
        } else if (newScore >= 21) {
            state.value.message = 'D';
        } else {
            state.value.message = 'E';
        }
    },
);
</script>

<template>
    <Head title="Score" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="dark:bg-sidebar m-4 bg-gray-100 p-4">
            <div class="flex flex-col md:flex-row">
                <!-- Left column (50%) -->
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4">
                        <input
                            type="number"
                            v-model="state.score"
                            class="w-full rounded-md border-2 border-gray-300 p-2"
                            placeholder="Masukkan Nilai"
                            max="100"
                        />
                        <div v-if="!state.score">Silahkan isi nilai kamu</div>
                        <!-- ini akan menjadi hidden -->
                        <div v-else>Nilai angka kamu {{ state.score }} kamu dapat nilai {{ state.message }}</div>
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
