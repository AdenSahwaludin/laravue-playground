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
        title: 'Score',
        href: '/belajar/score',
    },
]);

const state = ref({
    count: 0,
    firstName: '',
    lastName: '',
    score: 0, // Adding score property
});

// Computed property to determine the grade based on score
const grade = computed(() => {
    const score = state.value.score;
    if (score >= 90) return 'A';
    if (score >= 80) return 'B';
    if (score >= 70) return 'C';
    if (score >= 60) return 'D';
    return 'E';
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
                        <div v-if="state.count > 0" class="rounded-md bg-white p-4 shadow-sm dark:bg-gray-800">
                            Count is greater than 0: {{ state.count }}
                        </div>

                        <div v-else class="rounded-md bg-white p-4 shadow-sm dark:bg-gray-800">Count is 0</div>

                        <div class="rounded-md bg-white p-4 shadow-sm dark:bg-gray-800">
                            <div v-if="state.firstName && state.lastName">Hello, {{ state.firstName }} {{ state.lastName }}!</div>
                            <div v-else-if="state.firstName">Hello, {{ state.firstName }}!</div>
                            <div v-else>Please enter your name</div>
                        </div>

                        <!-- Score and grade display -->
                        <div class="rounded-md bg-white p-4 shadow-sm dark:bg-gray-800">
                            <div>Score: {{ state.score }}</div>
                            <div>Grade: {{ grade }}</div>
                            <div class="mt-2">
                                <input
                                    type="number"
                                    v-model="state.score"
                                    class="w-full rounded border px-3 py-2 dark:bg-gray-700"
                                    placeholder="Enter score"
                                    min="0"
                                    max="100"
                                />
                            </div>
                        </div>
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
