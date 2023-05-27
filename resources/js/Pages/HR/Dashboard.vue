<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, router } from '@inertiajs/vue3';

import { MagnifyingGlassIcon, ArchiveBoxArrowDownIcon } from "@heroicons/vue/24/outline";
import draggable from "vuedraggable/src/vuedraggable";
import {onMounted, ref, watch} from "vue";
import {useAutoAnimate} from "@formkit/auto-animate/vue";
import autoAnimate from "@formkit/auto-animate";
import debounce from 'lodash/debounce';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    statuses : Object
});

const changes = ref({
    oldStatus: null,
    newStatus: null,
    element: null,
});

const onDragEnd = (event, statusIndex) => {
    if (event.added) {
        changes.value.element = event.added.element;
        changes.value.newStatus = statusIndex;
    }

    if (event.removed) {
        changes.value.oldStatus = statusIndex;
    }
};

const revertChanges = () => {
    // TODO: maybe find a way to keep the old indexes?
    props.statuses[changes.value.oldStatus].candidates.push(changes.value.element);
    props.statuses[changes.value.newStatus].candidates.splice(changes.value.element, 1);

    changes.value = {
        oldStatus: null,
        newStatus: null,
        element: null,
    };
};

const saveChanges = () => {
    updateApplicationStatus(changes.value.element.id, props.statuses[changes.value.newStatus].id);
    changes.value = {
        oldStatus: null,
        newStatus: null,
        element: null,
    };
}

const updateApplicationStatus = (application,status) => {
    router.put(route('hr.applications.status.update',application), {
        status: status
    });
};

const showApplication = (application) => {
    router.visit(route('hr.dashboard.application.show',application));
};

let search = ref('');
watch(search, debounce(function(value){
  router.get(
    route('dashboard'),
    { search: value },
    { preserveState: true, replace: true }
  )
},300));
</script>

<template>
    <Head title="Dashboard" />

    <Layout>
        <div class="mb-8 top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6">

            <!-- Separator -->
            <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true" />

            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                <form class="relative flex flex-1" action="#" method="GET">
                    <label for="search-field" class="sr-only">Zoeken</label>
                    <MagnifyingGlassIcon class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400" aria-hidden="true" />
                    <input
                        id="search-field"
                        class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
                        placeholder="Zoeken door alle vacatures"
                        type="search"
                        name="search"
                        v-model="search"
                    />
                </form>
            </div>
        </div>
        <div class="flex gap-8 overflow-auto h-full pb-8">
            <div v-for="(status, index) in statuses" class="bg-white shadow-sm basis-80 flex-shrink-0">
                <div class="text-gray-900 bg-red-400 text-white font-bold text-lg px-4 py-3 border-b border-gray-50">
                    {{ status.name }}</div>
                <draggable
                    :list="statuses[index].candidates"
                    group="candidates"
                    item-key="id"
                    ghost-class="ghosting"
                    drag-class="dragging"
                    @change="onDragEnd($event,index )"
                    class="bg-white min-h-[100px]"
                    ref="parent"
                >
                    <template #item="{ element, index }">
                        <div @click="showApplication(element)" class="p-4 border-b last-of-type:border-0"
                            :class="element"
                        >
                            <div class="flex justify-between items-center">
                                <span class="font-semibold">{{ element.name }}</span>
                                <span class="text-gray-400 text-sm">{{ element.date }}</span>
                            </div>
                            <span class="text-gray-400 text-sm">{{ element.job }}</span>
                        </div>
                    </template>
                </draggable>
            </div>
        </div>

        <TransitionRoot as="template" :show="changes.newStatus !== null">
            <Dialog as="div" class="relative z-50">
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <div class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Status wijzigen</DialogTitle>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">Weet je zeker dat je <span class="font-bold">{{ changes.element?.name }}</span> wilt verplaatsen naar <span class="font-bold">{{ statuses[changes?.newStatus]?.name }}</span>?</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" @click="saveChanges">Wijzigen</button>
                                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="revertChanges" ref="cancelButtonRef">Annuleren</button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
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
