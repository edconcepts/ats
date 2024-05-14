<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import { MagnifyingGlassIcon, ArchiveBoxArrowDownIcon } from "@heroicons/vue/24/outline";
import {computed, onMounted, ref} from "vue";

import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

const { vacancies, locations, pages, current_page } = defineProps({
    vacancies: Object,
    locations: Object,
    pages: Number,
    current_page: Number,
});

const changeStatus = (vacancy, status) => {
    router.post(route('vacancies.change-status', {
        vacancy: vacancy,
        status: status,
    }), {}, {
        preserveScroll: true,
        onSuccess: () => {
            vacancy.status = status;
        }
    });
    // vacancy.status = status;
    close()
}

const filteredVacancies = computed(() => {
    if (!location.value) {
        return vacancies;
    }
    return vacancies.filter(v => v.location_id === location.value);
});

const location = ref('');

const searchVacancies = () => {

}

const page = ref(current_page);
const paginate = () => {
    router.visit('/vacancies?page=' + page.value);
}

</script>

<template>
    <Head title="Dashboard" />

    <Layout>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Vacatures</h1>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link :href="route('vacancies.create')" type="button" class="block rounded-md bg-red-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Vacature toevoegen</Link>
                </div>
            </div>
            <select @change="searchVacancies" id="location" name="location" v-model="location" class="rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option selected value="">Alle filialen</option>
                <option v-for="location in locations" :value="location.kik_id">{{ location.name }}</option>
            </select>
<!--            <select @change="paginate" v-model="page" class="ml-4 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">-->
<!--                <option v-for="p in parseInt(pages)" :value="p">Pagina {{ p }} van {{ pages }}</option>-->
<!--            </select>-->


            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Titel</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Status</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Locatie</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Aantal sollicitaties</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Einddatum</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Bewerken</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="vacancy in filteredVacancies" :key="vacancy.id">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6" v-html="vacancy.title.rendered">

                                    </td>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        <span v-if="vacancy.status !== 'publish'" @click="changeStatus(vacancy, 'publish')" class="inline-flex items-center gap-x-1.5 rounded-full bg-red-100 hover:bg-red-200 cursor-pointer px-2 py-1 text-xs font-medium text-red-700">
                                            <svg class="h-1.5 w-1.5 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                                                <circle cx="3" cy="3" r="3" />
                                            </svg>
                                            Inactief
                                        </span>
                                        <span v-if="vacancy.status === 'publish'" @click="changeStatus(vacancy, 'draft')" class="inline-flex items-center gap-x-1.5 rounded-full bg-green-100 hover:bg-green-200 cursor-pointer px-2 py-1 text-xs font-medium text-green-700">
                                            <svg class="h-1.5 w-1.5 fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
                                                <circle cx="3" cy="3" r="3" />
                                            </svg>
                                            Actief
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6" v-html="vacancy.location"></td>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ vacancy.applications_count }}</td>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ vacancy.end_date }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <Link :href="route('vacancies.edit', vacancy)" class="rounded bg-white px-2 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Vacature beheren</Link>
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
