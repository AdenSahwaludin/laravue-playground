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
    score: 0,
    attendance: 0, // Adding attendance percentage
    homeworkCompleted: false, // Homework completion status
    participationPoints: 0, // Class participation points
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

// More complex computed property with multiple conditions
const academicStanding = computed(() => {
    const score = state.value.score;
    const attendance = state.value.attendance;
    const homework = state.value.homeworkCompleted;
    const participation = state.value.participationPoints;

    // Outstanding: High score, perfect attendance, completed homework, high participation
    if (score >= 90 && attendance >= 95 && homework && participation >= 8) {
        return { status: 'Outstanding', color: 'text-green-600' };
    }
    // Good standing: Good score, good attendance, homework complete
    else if ((score >= 80 && attendance >= 85 && homework) || (score >= 75 && attendance >= 90 && participation >= 7)) {
        return { status: 'Good Standing', color: 'text-blue-600' };
    }
    // Satisfactory: Average performance overall
    else if ((score >= 70 && attendance >= 75) || (score >= 65 && homework && participation >= 6)) {
        return { status: 'Satisfactory', color: 'text-yellow-600' };
    }
    // Warning: Poor performance in multiple areas
    else if (score < 60 || attendance < 70 || (!homework && participation < 5)) {
        return { status: 'Academic Warning', color: 'text-red-600' };
    }
    // Probation: Very poor performance overall
    else if (score < 50 && attendance < 60 && !homework) {
        return { status: 'Academic Probation', color: 'text-red-800' };
    }
    // Default case
    else {
        return { status: 'Needs Review', color: 'text-gray-600' };
    }
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

                        <!-- Complex conditional component -->
                        <div class="rounded-md bg-white p-4 shadow-sm dark:bg-gray-800">
                            <h3 class="mb-4 font-bold">Academic Performance</h3>

                            <div class="mb-3">
                                <label class="mb-1 block">Attendance (%)</label>
                                <input
                                    type="number"
                                    v-model="state.attendance"
                                    class="w-full rounded border px-3 py-2 dark:bg-gray-700"
                                    placeholder="Enter attendance percentage"
                                    min="0"
                                    max="100"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="flex items-center">
                                    <input type="checkbox" v-model="state.homeworkCompleted" class="mr-2" />
                                    Homework Completed
                                </label>
                            </div>

                            <div class="mb-3">
                                <label class="mb-1 block">Participation (0-10)</label>
                                <input
                                    type="number"
                                    v-model="state.participationPoints"
                                    class="w-full rounded border px-3 py-2 dark:bg-gray-700"
                                    placeholder="Enter participation points"
                                    min="0"
                                    max="10"
                                />
                            </div>

                            <div class="mt-4 rounded-lg border p-3">
                                <div class="font-bold">Academic Standing:</div>
                                <div :class="academicStanding.color">
                                    {{ academicStanding.status }}
                                </div>
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
