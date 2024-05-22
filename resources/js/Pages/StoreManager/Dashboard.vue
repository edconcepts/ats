<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
defineProps({
    days: Array,
    week: Number
})
import {MagnifyingGlassIcon, ArchiveBoxArrowDownIcon, ArrowLeftOnRectangleIcon} from "@heroicons/vue/24/outline";
import draggable from "vuedraggable/src/vuedraggable";
import {onMounted, ref} from "vue";
import StoreManagerLayout from "@/Layouts/StoreManagerLayout.vue";

const saveTimeSlot = (timeslot) => {
    router.post(route('store-manager.timeslot'), {
        timeslot: timeslot
    })
}

const openWeek = (week) => {
    router.visit('/dashboard?week=' + week)
}

const showApplication = (application) => {
    router.visit(route('dashboard.application.show',application));
};

onMounted(() => {
    // setInterval(() => {
    //     fetch(route('store-manager.notifications.count'))
    //         .then(response => response.json())
    //         .then(data => {
    //             usePage().props.auth.notification_count = data
    //         })
    // }, 5000)
})

</script>

<template>
    <Head title="Dashboard" />

    <StoreManagerLayout>
        <div class="flex justify-between  items-center ">
            <div>
                <h1 class="font-semibold text-2xl flex items-center gap-8">
                    Agenda
                </h1>
                <p>Vink de tijdsvakken aan waarin je beschikbaar bent om sollicitatiegesprekken te voeren. Vul iedere week minimaal twee blokken beschikbaarheid na 16:00 in.</p>

            </div>
        </div>
        <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
            <span class="block sm:inline">{{ $page.props.flash.success }}</span>
            <button @click="$page.props.flash.success=null" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </button>
        </div>
        <div class="flex justify-between mt-8">
            <button @click="openWeek(week - 1)" type="button" class="flex  gap-1.5  items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                </svg>
                Week {{ week - 1 }}
            </button>
            <h1 class="font-bold text-2xl">Week {{ week }}</h1>
            <button @click="openWeek(parseInt(week) + 1)" type="button" class="flex  gap-1.5  items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Week {{ parseInt(week) + 1 }}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-7 w-full mt-4 gap-4">
            <div v-for="day in days">
                <div class="text-gray-900 bg-red-400 text-white truncate font-bold text-lg px-4 py-3 border-b border-gray-50">{{ day.localized }}</div>
                <template v-for="timeslot in day.timeslots">
                    <div v-if="timeslot.appointment" class="bg-green-200 py-2 px-4" @click="showApplication(timeslot.appointment)">
                        {{ timeslot.appointment.name }}
                    </div>
                    <label  v-if="!timeslot.appointment" class="flex bg-white hover:cursor-pointer hover:bg-red-50 items-center gap-2 py-2 px-4 " >
                            <input type="checkbox"
                                   class="disabled:opacity-10 disabled:cursor-not-allowed"
                                   :disabled="timeslot.is_in_past"
                                   :checked="timeslot.is_checked"
                                   @change="saveTimeSlot(timeslot)"
                            > {{ timeslot.formatted }} - {{ timeslot.end_formatted }}
                    </label>
                </template>
            </div>
        </div>
    </StoreManagerLayout>
</template>
