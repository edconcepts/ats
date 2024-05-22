<script setup>
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import StoreManagerLayout from "@/Layouts/StoreManagerLayout.vue";
import {onMounted} from "vue";

defineProps({
    notifications: Object,
})

onMounted(() => {
    setInterval(() => {
        fetch(route('store-manager.notifications.get-notifications'))
            .then(response => response.json())
            .then(data => {
                console.log(data)
                usePage().props.auth.notification_count = data.data.length
                usePage().props.notifications = data
            })
    }, 30000)
})

</script>

<template>
    <Head title="Dashboard" />

    <StoreManagerLayout>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Meldingen</h1>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link :href="route('store-manager.notifications.delete')" method="post" class="block rounded-md bg-red-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Gelezen meldingen archiveren</Link>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Datum & tijd</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Bericht</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Bewerken</span>
                                    </th>
                                </tr>

                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="notification in notifications.data" :key="notification.id" :class="{ 'bg-red-50 font-bold': notification.read_at === null }">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ notification.created_at }}</td>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ notification.data.message }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <Link v-if="notification.read_at" :href="route('store-manager.notifications.mark-as-unread', notification)" method="post" class="rounded bg-white px-2 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Markeer als ongelezen</Link>
                                        <Link v-if="! notification.read_at" :href="route('store-manager.notifications.mark-as-read', notification)" method="post" class="rounded bg-white px-2 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Markeer als gelezen</Link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StoreManagerLayout>
</template>
