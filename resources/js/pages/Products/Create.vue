<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Products', href: '/products' },
    { title: 'Create', href: '/products/create' },
];

const form = useForm({
    name: '',
    description: '',
    price: '',
    stock: '',
    is_active: true,
    image: null as File | null,
});

const imagePreview = ref<string | null>(null);

const handleImageChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const file = target.files[0];
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    form.post('/products', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            imagePreview.value = null;
        },
    });
};
</script>

<template>
    <Head title="Create Product" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold">Create New Product</h1>
                <Link href="/products" class="hover:bg-sidebar/50 bg-sidebar rounded-md px-4 py-2 text-white"> Back to Products </Link>
            </div>

            <div class="dark:bg-sidebar rounded-lg bg-white p-6 shadow">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-gray-900 focus:ring-gray-900 dark:border-gray-900 dark:bg-black dark:text-white"
                                required
                            />
                            <div v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</div>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Price (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="price"
                                v-model="form.price"
                                type="number"
                                class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-gray-900 focus:ring-gray-900 dark:border-gray-900 dark:bg-black dark:text-white"
                                required
                            />
                            <div v-if="form.errors.price" class="mt-1 text-sm text-red-500">{{ form.errors.price }}</div>
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Stock <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="stock"
                                v-model="form.stock"
                                type="number"
                                class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-gray-900 focus:ring-gray-900 dark:border-gray-900 dark:bg-black dark:text-white"
                                required
                            />
                            <div v-if="form.errors.stock" class="mt-1 text-sm text-red-500">{{ form.errors.stock }}</div>
                        </div>

                        <!-- Active Status -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Active Status </label>
                            <select
                                id="is_active"
                                v-model="form.is_active"
                                class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-gray-900 focus:ring-gray-900 dark:border-gray-900 dark:bg-black dark:text-white"
                            >
                                <option :value="true">Active</option>
                                <option :value="false">Inactive</option>
                            </select>
                            <div v-if="form.errors.is_active" class="mt-1 text-sm text-red-500">{{ form.errors.is_active }}</div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Description </label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-gray-900 focus:ring-gray-900 dark:border-gray-900 dark:bg-black dark:text-white"
                        ></textarea>
                        <div v-if="form.errors.description" class="mt-1 text-sm text-red-500">{{ form.errors.description }}</div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Product Image </label>
                        <input
                            id="image"
                            type="file"
                            @change="handleImageChange"
                            accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold hover:file:bg-gray-200 dark:file:bg-gray-700 dark:file:text-white dark:hover:file:bg-gray-600"
                        />
                        <div v-if="form.errors.image" class="mt-1 text-sm text-red-500">{{ form.errors.image }}</div>

                        <div v-if="imagePreview" class="mt-4">
                            <img :src="imagePreview" alt="Image Preview" class="max-w-xs rounded border p-2" />
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="rounded bg-gray-900 px-6 py-2 text-white transition hover:bg-gray-700">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
