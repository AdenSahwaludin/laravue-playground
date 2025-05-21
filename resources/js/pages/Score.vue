<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const breadcrumbs = [
    { title: 'Belajar', href: '/belajar' },
    { title: 'Score', href: '/belajar/score' },
];

const score = ref(0);

const message = computed(() => {
    if (score.value > 100) return 'Nilai tidak boleh lebih dari 100';
    if (score.value < 0) return 'Nilai tidak boleh kurang dari 0';
    if (score.value >= 81) return 'A';
    if (score.value >= 61) return 'B';
    if (score.value >= 41) return 'C';
    if (score.value >= 21) return 'D';
    return 'E';
});
</script>

<template>
    <Head title="Score" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="dark:bg-sidebar m-4 bg-gray-100 p-4">
            <div class="flex flex-col md:flex-row">
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4">
                        <input
                            type="number"
                            v-model.number="score"
                            class="w-full rounded-md border-2 border-gray-300 p-2"
                            placeholder="Masukkan Nilai"
                            max="100"
                            min="0"
                        />
                        <div v-if="!score">Silahkan isi nilai kamu</div>
                        <div v-else>Nilai angka kamu {{ score }} kamu dapat nilai {{ message }}</div>
                    </div>
                </div>
                <div class="w-full p-2 md:w-1/2">
                    <div class="flex flex-col gap-4"></div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
