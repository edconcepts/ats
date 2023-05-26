<script setup>
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from "@headlessui/vue"
import {router, useForm} from "@inertiajs/vue3";
import { useModal } from "momentum-modal"
defineProps({
    application: Object,
    statuses: Object,
})

const { show, close, redirect } = useModal()

const statusForm = useForm({
    status: null,
})

const changeStatus = (application, status) => {
    statusForm.put(route('hr.applications.status.update', application), {
        status: status
    })
    close()
}

const saveTimeSlot = (application, timeSlot) => {
    statusForm.post(route('hr.interviews.store', application), {
        application: application,
        timeSlot : timeSlot
    })
    close()
}

const archive = (application) => {
    // TODO: implement
    close()
}
</script>

<template>
    <TransitionRoot appear as="template" :show="show">
        <Dialog as="div" class="relative z-50" @close="close">
            <TransitionChild
                @after-leave="redirect"
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">
                        <DialogPanel class="w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <div>
                                <div class="px-4 sm:px-0 flex items-center justify-between">
                                    <h3 class="text-base font-semibold leading-7 text-gray-900">Sollicitatie details</h3>
                                    <button @click="archive(application)" type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3  gap-x-1.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                                        Archiveren
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mr-0.5 h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                        </svg>

                                    </button>
                                </div>
                                <div class="mt-6 border-t border-gray-100">
                                    <div class="flex gap-24">
                                        <dl class="divide-y divide-gray-100 w-full">
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm font-medium leading-6 text-gray-900">Naam</dt>
                                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ application.name }}</dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm font-medium leading-6 text-gray-900">Gesolliciteerd voor</dt>
                                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                    {{ application.vacancy.title }}
                                                </dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm font-medium leading-6 text-gray-900">Gesolliciteerd op</dt>
                                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                    {{ application.created_at }}
                                                </dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm font-medium leading-6 text-gray-900">Status</dt>
                                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                    {{ application.status.name }}
                                                </dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm font-medium leading-6 text-gray-900">Locatie</dt>
                                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                    {{ application.vacancy.location.name }}
                                                </dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm font-medium leading-6 text-gray-900">E-mailadres</dt>
                                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                    <a class="underline underline-offset-4 hover:no-underline" :href="'mailto:' + application.email">{{  application.email }}</a>
                                                </dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm font-medium leading-6 text-gray-900">Telefoonnummer</dt>
                                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                    <a class="underline underline-offset-4 hover:no-underline" :href="'tel:' + application.phone_number">{{ application.phone_number }}</a>
                                                </dd>
                                            </div>
                                        </dl>
                                        <div class="w-64 py-4 shrink-0">
                                            <div class="flex flex-col gap-2">
                                                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Status wijzigen</label>
                                                <select
                                                    class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                    v-model="statusForm.status" >
                                                    <option v-for="status in statuses" :value="status.id">
                                                        {{ status.name }}
                                                    </option>
                                                </select>
                                                <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto" @click="changeStatus(application)">Wijzigen</button>
                                            </div>

                                            <div class="flex flex-col gap-2 mt-4 pt-4 border-t">
                                                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Gesprek inplannen</label>
                                                <select
                                                    class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                    v-model="application.status_id" >
                                                    <option v-for="timeSlot in application.vacancy.location.manager?.timeSlots" :value="timeSlot.id" >
                                                        {{ timeSlot.from_date_time }}
                                                    </option>
                                                </select>
                                                <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto" @click="saveTimeSlot(application,timeSlot)">Inplannen</button>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
