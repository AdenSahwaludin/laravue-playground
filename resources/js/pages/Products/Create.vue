<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
    {
        title: 'Create',
        href: '/products/create',
    },
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

        // Create preview URL
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
                <Link href="/products" class="rounded-md bg-gray-600 px-4 py-2 text-white hover:bg-gray-700"> Back to Products </Link>
            </div>

            <div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800">
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
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                required
                            />
                            <div v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</div>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Price (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    step="1000"
                                    min="0"
                                    placeholder="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 pl-10 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    required
                                />
                            </div>
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
                                min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                required
                            />
                            <div v-if="form.errors.stock" class="mt-1 text-sm text-red-500">{{ form.errors.stock }}</div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Status </label>
                            <select
                                id="is_active"
                                v-model="form.is_active"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
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
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        ></textarea>
                        <div v-if="form.errors.description" class="mt-1 text-sm text-red-500">{{ form.errors.description }}</div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Product Image </label>
                        <div class="mt-1 flex items-center">
                            <div v-if="imagePreview" class="mr-4 h-20 w-20 overflow-hidden rounded-md">
                                <img :src="imagePreview" alt="Preview" class="h-full w-full object-cover" />
                            </div>
                            <label
                                class="cursor-pointer rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            >
                                <span>Upload Image</span>
                                <input id="image" type="file" class="sr-only" @change="handleImageChange" accept="image/*" />
                            </label>
                            <button
                                v-if="form.image"
                                type="button"
                                @click="
                                    form.image = null;
                                    imagePreview = null;
                                "
                                class="ml-2 px-2 py-1 text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                            >
                                Remove
                            </button>
                        </div>
                        <div v-if="form.errors.image" class="mt-1 text-sm text-red-500">{{ form.errors.image }}</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Saving...</span>
                            <span v-else>Save Product</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
