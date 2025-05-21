<script setup>
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
    users: Array,
});

const state = ref({
    message: 'Halo, Vue!',
    count: 0,
});

const breadcrumbs = ref([
    {
        title: 'Belajar',
        href: '/belajar',
    },
]);

const updateMessage = () => {
    state.value.message = 'Anda mengklik tombol!';
};

const increment = () => {
    state.value.count++;
};
</script>

<template>
    <Head title="Belajar" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="dark:bg-sidebar m-4 flex flex-col gap-4 bg-gray-100 p-4">
            <h1>{{ state.message }}</h1>
            <Button @click="updateMessage">Klik Saya</Button>
            <!--  -->
            <p>Count {{ state.count }}</p>
            <Button @Click="increment">Increment Count</Button>
            <!--  -->
            <div class="flex w-full flex-col gap-4 md:flex-row">
                <div class="w-full">
                    <Button as="a" :href="route('belajar.say-hello')" class="mr-2 w-full cursor-pointer hover:cursor-pointer"
                        >Pergi ke Say Hello
                    </Button>
                </div>
                <div class="w-full">
                    <Button as="a" :href="route('belajar.style')" class="w-full cursor-pointer hover:cursor-pointer">Pergi ke Style </Button>
                </div>
            </div>
            <div class="flex w-full flex-col gap-4 md:flex-row">
                <div class="w-full">
                    <Button as="a" :href="route('belajar.score')" class="mr-2 w-full cursor-pointer hover:cursor-pointer">Pergi ke Score</Button>
                </div>
                <div class="w-full">
                    <Button as="a" :href="route('todolist')" class="w-full cursor-pointer hover:cursor-pointer">Pergi ke ToDoList</Button>
                </div>
            </div>
            <p>Kamu adalah {{ props.user.name }}</p>
            <ul>
                List semua user:
                <li v-for="(user, index) in props.users" :key="user.id">{{ index + 1 }}. {{ user.name }}</li>
            </ul>
        </div>
    </AppLayout>
</template>
