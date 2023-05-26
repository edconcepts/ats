<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, router } from '@inertiajs/vue3';
defineProps({
    days: Array,
    week: Number
})
import { MagnifyingGlassIcon, ArchiveBoxArrowDownIcon } from "@heroicons/vue/24/outline";
import draggable from "vuedraggable/src/vuedraggable";
import {onMounted, ref} from "vue";

const saveTimeSlot = (timeslot) => {
    router.post(route('store-manager.timeslot'), {
        timeslot: timeslot
    })
}

const openWeek = (week) => {
    router.visit('/dashboard?week=' + week)
}

</script>

<template>
    <Head title="Dashboard" />

    <Layout>

                <h1 class="font-semibold text-2xl">Agenda</h1>
                <p>Vink de tijdsvakken aan waarin je beschikbaar bent om sollicitatiegesprekken te voeren.</p>

                <div class="flex justify-between mt-8">
                    <button @click="openWeek(week - 1)" type="button" class="flex  gap-1.5  items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                        </svg>
                        Week 12
                    </button>
                    <h1 class="font-bold text-2xl">Week {{ week }}</h1>
                    <button @click="openWeek(parseInt(week) + 1)" type="button" class="flex  gap-1.5  items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        Week 13
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-5 w-full mt-4 gap-4">
                    <div v-for="day in days">
                        <div class="text-gray-900 bg-red-400 text-white font-bold text-lg px-4 py-3 border-b border-gray-50">{{ day.formatted }}</div>
                        <label class="flex bg-white hover:cursor-pointer hover:bg-red-50 items-center gap-2 py-2 px-4 " v-for="timeslot in day.timeslots">
                            <input type="checkbox" :checked="timeslot.is_checked" @change="saveTimeSlot(timeslot)">{{ timeslot.formatted }} - {{ timeslot.end_formatted }}
                        </label>
                    </div>
                </div>
    </Layout>
</template>
