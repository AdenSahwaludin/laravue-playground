<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    product: {
        id: number;
        name: string;
        description: string | null;
        price: number;
        stock: number;
        image_path: string | null;
        is_active: boolean;
        created_at: string;
        updated_at: string;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
    {
        title: props.product.name,
        href: `/products/${props.product.id}`,
    },
];

// Format date to readable format
const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

// Format currency to Rupiah
const formatRupiah = (amount) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(amount);
};
</script>

<template>
    <Head :title="product.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold">Product Details</h1>
                <div class="space-x-2">
                    <Link :href="`/products/${product.id}/edit`" class="rounded-md bg-yellow-600 px-4 py-2 text-white hover:bg-yellow-700">
                        Edit
                    </Link>
                    <Link href="/products" class="rounded-md bg-gray-600 px-4 py-2 text-white hover:bg-gray-700"> Back to Products </Link>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
                <div class="md:flex">
                    <div class="p-4 md:w-1/3">
                        <div class="aspect-square w-full overflow-hidden rounded-md bg-gray-100 dark:bg-gray-700">
                            <img
                                v-if="product.image_path"
                                :src="`/storage/${product.image_path}`"
                                :alt="product.name"
                                class="h-full w-full object-cover"
                            />
                            <div v-else class="flex h-full w-full items-center justify-center text-gray-400">No Image</div>
                        </div>
                    </div>

                    <div class="p-6 md:w-2/3">
                        <div class="mb-6">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ product.name }}</h2>
                            <div class="mt-2">
                                <span
                                    :class="[
                                        'rounded-full px-2 py-1 text-xs font-semibold',
                                        product.is_active
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ]"
                                >
                                    {{ product.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</h3>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ formatRupiah(product.price) }}</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock</h3>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ product.stock }} units</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ formatDate(product.created_at) }}</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ formatDate(product.updated_at) }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h3>
                            <div class="prose prose-sm dark:prose-invert mt-3 max-w-none">
                                <p v-if="product.description" class="text-gray-600 dark:text-gray-300">
                                    {{ product.description }}
                                </p>
                                <p v-else class="text-gray-400 italic dark:text-gray-500">No description provided</p>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <Link
                                :href="`/products/${product.id}`"
                                method="delete"
                                as="button"
                                type="button"
                                class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                                onclick="return confirm('Are you sure you want to delete this product?')"
                            >
                                Delete Product
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
