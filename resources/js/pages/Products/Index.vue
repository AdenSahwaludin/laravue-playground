<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    products: Object,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];

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
    <Head title="Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold">Products</h1>
                <Link href="/products/create" class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"> Add New Product </Link>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                Image
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                Stock
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                        <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div v-if="product.image_path" class="h-10 w-10 overflow-hidden rounded-full">
                                    <img :src="`/storage/${product.image_path}`" alt="Product image" class="h-full w-full object-cover" />
                                </div>
                                <div v-else class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">No img</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ product.name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ formatRupiah(product.price) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ product.stock }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    v-if="product.is_active"
                                    class="inline-flex rounded-full bg-green-100 px-2 text-xs leading-5 font-semibold text-green-800 dark:bg-green-900 dark:text-green-200"
                                >
                                    Active
                                </span>
                                <span
                                    v-else
                                    class="inline-flex rounded-full bg-red-100 px-2 text-xs leading-5 font-semibold text-red-800 dark:bg-red-900 dark:text-red-200"
                                >
                                    Inactive
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <Link
                                        :href="`/products/${product.id}`"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                    >
                                        View
                                    </Link>
                                    <Link
                                        :href="`/products/${product.id}/edit`"
                                        class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                    >
                                        Edit
                                    </Link>
                                    <Link
                                        :href="`/products/${product.id}`"
                                        method="delete"
                                        as="button"
                                        type="button"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                        onclick="return confirm('Are you sure you want to delete this product?')"
                                    >
                                        Delete
                                    </Link>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="products.data.length === 0">
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No products found</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 dark:border-gray-700 dark:bg-gray-900">
                <div class="flex flex-1 justify-between sm:hidden">
                    <Link
                        v-if="products.prev_page_url"
                        :href="products.prev_page_url"
                        class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Previous
                    </Link>
                    <Link
                        v-if="products.next_page_url"
                        :href="products.next_page_url"
                        class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Next
                    </Link>
                </div>
                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing
                            <span class="font-medium">{{ products.from }}</span>
                            to
                            <span class="font-medium">{{ products.to }}</span>
                            of
                            <span class="font-medium">{{ products.total }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            <Link
                                v-for="(link, i) in products.links"
                                :key="i"
                                :href="link.url"
                                v-html="link.label"
                                class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                :class="{
                                    'border-blue-500 bg-blue-50 text-blue-600': link.active,
                                    'cursor-not-allowed opacity-50': !link.url,
                                    'z-10 border-indigo-500 bg-indigo-50 text-indigo-600': link.active,
                                }"
                            />
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
