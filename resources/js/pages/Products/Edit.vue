<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue'; // Added watch for props

interface Props {
    product: {
        id: number;
        name: string;
        description: string | null;
        price: number;
        stock: number;
        image_path: string | null;
        is_active: boolean;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
    {
        title: 'Edit',
        href: `/products/${props.product.id}/edit`,
    },
];

const form = useForm({
    name: props.product.name,
    description: props.product.description || '',
    price: props.product.price.toString(),
    stock: props.product.stock.toString(),
    is_active: props.product.is_active,
    image: null as File | null,
    _method: 'put', // For Laravel method spoofing
});

// Initialize imagePreview with the existing product image or null
const imagePreview = ref<string | null>(props.product.image_path ? `/storage/${props.product.image_path}` : null);

// Watch for changes in props.product.image_path to update preview if needed (e.g., after successful save without page reload)
watch(
    () => props.product.image_path,
    (newPath) => {
        if (!form.image) {
            // Only update if no new image is staged
            imagePreview.value = newPath ? `/storage/${newPath}` : null;
        }
    },
);

const handleImageChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const file = target.files[0];
        form.image = file; // Store the new file object
        imagePreview.value = URL.createObjectURL(file); // Preview the new file
    } else {
        // No file selected or file selection was cancelled
        form.image = null; // Clear any new file object
        // Revert preview to the original product image, if it exists
        imagePreview.value = props.product.image_path ? `/storage/${props.product.image_path}` : null;
    }
};

const clearSelectedImage = () => {
    form.image = null;
    const fileInput = document.getElementById('image') as HTMLInputElement;
    if (fileInput) {
        fileInput.value = ''; // Reset the file input visually
    }
    imagePreview.value = props.product.image_path ? `/storage/${props.product.image_path}` : null; // Revert preview to original
};

const submit = () => {
    form.post(`/products/${props.product.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            if (form.image) {
                form.image = null; // Clear the file from the form object after successful upload
            }
            // Reset the file input field visually after submission
            const fileInput = document.getElementById('image') as HTMLInputElement;
            if (fileInput) {
                fileInput.value = '';
            }
            // imagePreview should ideally be updated by props change or if the page reloads.
            // If props.product.image_path is updated by Inertia, the watcher will handle it.
        },
    });
};
</script>

<template>
    <Head :title="`Edit Product: ${product.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold">Edit Product: {{ product.name }}</h1>
                <div class="space-x-2">
                    <Link :href="`/products/${product.id}`" class="hover:bg-sidebar/80 bg-sidebar rounded-md px-4 py-2 text-white transition">
                        View Details
                    </Link>
                    <Link href="/products" class="hover:bg-sidebar/50 bg-sidebar rounded-md px-4 py-2 text-white transition"> Back to Products </Link>
                </div>
            </div>

            <div class="dark:bg-sidebar rounded-lg bg-white p-6 shadow">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Price (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm dark:text-gray-400">Rp</span>
                                </div>
                                <input
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    step="1000"
                                    min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 p-2 pl-10 shadow-sm focus:border-gray-900 focus:ring-gray-900 dark:border-gray-900 dark:bg-black dark:text-white"
                                    required
                                />
                            </div>
                            <div v-if="form.errors.price" class="mt-1 text-sm text-red-500">{{ form.errors.price }}</div>
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Stock <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="stock"
                                v-model="form.stock"
                                type="number"
                                min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-gray-900 focus:ring-gray-900 dark:border-gray-900 dark:bg-black dark:text-white"
                                required
                            />
                            <div v-if="form.errors.stock" class="mt-1 text-sm text-red-500">{{ form.errors.stock }}</div>
                        </div>

                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Status </label>
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

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Product Image </label>

                        <div v-if="imagePreview" class="mt-4">
                            <img :src="imagePreview" alt="Image Preview" class="max-w-xs rounded border p-2" />
                        </div>
                        <div v-else class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">No image available or selected.</p>
                        </div>

                        <input
                            id="image"
                            type="file"
                            @change="handleImageChange"
                            accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold hover:file:bg-gray-200 dark:text-gray-300 dark:file:bg-gray-700 dark:file:text-white dark:hover:file:bg-gray-600"
                        />
                        <div v-if="form.errors.image" class="mt-1 text-sm text-red-500">{{ form.errors.image }}</div>

                        <button
                            v-if="form.image"
                            type="button"
                            @click="clearSelectedImage"
                            class="mt-2 rounded bg-red-600 px-3 py-1 text-xs text-white transition hover:bg-red-700"
                        >
                            Clear Selected Image
                        </button>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button
                            type="submit"
                            class="rounded bg-gray-900 px-6 py-2 text-white transition hover:bg-gray-700"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Saving...</span>
                            <span v-else>Update Product</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
