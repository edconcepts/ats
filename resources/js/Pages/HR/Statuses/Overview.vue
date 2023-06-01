<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    statuses : Array
});
// const statuses = ref([
//     { id: 1, name: 'Gesolliciteerd' },
//     { id: 2, name: 'Afgewezen' },
//     { id: 3, name: 'Gebeld geen contact' },
//     { id: 4, name: '2e keer gebeld geen contact' },
//     { id: 5, name: 'Gesprek ingepland' },
//     { id: 6, name: '2e gesprek ingepland' },

// ]);
</script>

<template>
    <Head title="Dashboard" />

    <Layout>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Statussen</h1>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link :href="route('statuses.create')" type="button" class="block rounded-md bg-red-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Status toevoegen</Link>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Naam</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Bewerken</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="status in statuses" :key="status.id">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ status.name }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <Link :href="route('statuses.edit',status)" class="text-red-600 hover:text-red-900"
                                        >Bewerken<span class="sr-only">, {{ status.name }}</span>
                                    </Link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
<style scoped>
    .dragging {
        @apply bg-white opacity-100 border-dashed border-2 border-gray-400;
    }

    .ghosting {
        @apply bg-green-50;
    }
</style>
