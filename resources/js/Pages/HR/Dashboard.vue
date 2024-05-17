<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, router } from '@inertiajs/vue3';

import { MagnifyingGlassIcon, ArchiveBoxArrowDownIcon, PlusCircleIcon, EllipsisVerticalIcon } from "@heroicons/vue/24/outline";
import draggable from "vuedraggable/src/vuedraggable";
import {onMounted, ref, watch} from "vue";
import {useAutoAnimate} from "@formkit/auto-animate/vue";
import autoAnimate from "@formkit/auto-animate";
import debounce from 'lodash/debounce';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    statuses: Object,
    locations: Object,
    archived_status_id : Number
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
    router.put(route('applications.status.update',application), {
        status: status
    });
};

const showApplication = (application) => {
    router.visit(route('dashboard.application.show',application));
};

const addCandidate = () => {
    router.visit(route('dashboard.application.create'));
};

const archiveeStatus = ref(null);

const archiveStatus = (status) => {
    archiveeStatus.value = status;
}

const saveArchiveStatus = () => {
    router.post(route('statuses.applications.archive', archiveeStatus.value));
    archiveeStatus.value = null;
};

const revertArchiveStatus = () => {
    archiveeStatus.value = null;
};

const invisibleToggled = ref(false);
const toggleVisible = () =>{
    // props.statuses.forEach((item, index) => {
    //     item.visible = true;
    // })
    invisibleToggled.value = !invisibleToggled.value;
}

let search = ref('');
let location = ref('');

watch(search, debounce(function(value){
  searchApplications()
},300));

const searchApplications = () => {
    console.log(search.value, location.value)
    props.statuses.forEach((item, index) => {
        item.candidates.forEach((candidate, index) => {
            if (
                (
                    candidate.name.toLowerCase().includes(search.value.toLowerCase()) &&
                    search.value.toLowerCase() !== ''
                ) ||
                (
                    candidate.location_name.toLowerCase().includes(location.value.toLowerCase()) &&
                    location.value.toLowerCase() !== ''
                )
            ) {
                candidate.visible = true;
            } else {
                candidate.visible = false;
            }

            if (search.value.toLowerCase() === '' && location.value.toLowerCase() === '') {
                candidate.visible = true;
            }
        });
    });
}

</script>

<template>
    <Head title="Dashboard" />

    <Layout>
<!--         <pre>-->
<!--        {{ statuses }}-->
<!--    </pre>-->
        <div class="mb-8 top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 pr-2 shadow-sm sm:gap-x-6" style="
    width: 100%;
    flex-wrap: wrap;height: fit-content;">
            <!-- Separator -->
            <!--<div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true" />-->
            <select @change="searchApplications" id="location" name="location" v-model="location" class="rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option selected value="">Alle filialen</option>
                <option v-for="location in locations" :value="location.name">{{ location.name }}</option>
            </select>
            <div class="flex justify-between flex-1 gap-x-4 self-stretch lg:gap-x-2 py-2">
                <div class="relative flex flex-1">
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
                </div>
                <button @click="toggleVisible" class="flex gap-4 items-center rounded bg-red-400 px-4 py-1 font-semibold text-white  shadow-sm  hover:bg-red-500">
                    <ArchiveBoxArrowDownIcon class="h-6 w-6 rounded text-white hover:text-red-500" aria-hidden="true" />
                    <span v-if="invisibleToggled">Verberg archief</span>
                    <span v-if="! invisibleToggled">Toon archief</span>
                </button>
                <button @click="addCandidate" class="flex gap-4 items-center rounded bg-green-500 px-4 py-1 font-semibold text-white  shadow-sm  hover:bg-green-600"
                        v-if="$page.props.auth.user.role !== 'area_manager'">
                    <PlusCircleIcon class="h-6 w-6 rounded text-white hover:text-green-600" aria-hidden="true" />
                    <span>Kandidaat toevoegen</span>
                </button>
            </div>
        </div>
        <div class="flex gap-8 pb-8" style="overflow: scroll hidden;">
            <div v-for="(status, index) in statuses" v-show="status.visible == true || invisibleToggled" class="bg-white shadow-sm basis-80 flex-shrink-0 mb-8" style="height: 75vh;">
                <div  class="text-gray-900 bg-red-400 text-white font-bold text-lg px-4 py-3 border-b border-gray-50 flex justify-between">
                    {{ status.name }}
                    <button
                        v-if="status.id != archived_status_id && status.candidates.length > 0 && $page.props.auth.user.role !== 'area_manager'"
                        class="text-center px-2 py-1" @click="archiveStatus(status)" >
                        <ArchiveBoxArrowDownIcon class="h-5 w-5 rounded text-white hover:text-red-200" aria-hidden="true" />
                    </button>
                </div>
                <draggable
                    :list="statuses[index].candidates"
                    handle=".handle"
                    group="candidates"
                    item-key="id"
                    ghost-class="ghosting"
                    drag-class="dragging"
                    @change="onDragEnd($event,index )"
                    class="bg-white min-h-[100px]"
                    :disabled="$page.props.auth.user.role === 'area_manager'"
                    style="overflow-y: scroll; height:100%;"
                    ref="parent"
                >
                    <template #item="{ element, index }">
                        <div v-if="element.visible" @tap="showApplication(element)" @click="showApplication(element)" class="p-3 pl-8 border-b last-of-type:border-0 relative"
                            :class="element"
                        >
                            <div class="handle" style="
                                position: absolute;
                                left: 5px;
                                top: 50%;
                                transform: translateY(-50%);
                            " v-if="$page.props.auth.user.role !== 'area_manager'">
                                <EllipsisVerticalIcon class="pointer-events-none h-full w-5 text-gray-400" aria-hidden="true" />
                            </div>
                            <div class="flex justify-between items-center space-y-1.5">
                                <span class="font-semibold">{{ element.name }}</span>
                                <span class="text-gray-400 text-sm" style="white-space: nowrap;">{{ element.date }}</span>
                            </div>
                            <div class="flex flex-col justify-between">
                                <span class="text-gray-400 text-sm" v-html="element.job"></span>
                                <span class="text-sm" v-html="element.location_name"></span>

                            </div>
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

                <div class="fixed inset-0 z-50 overflow-y-auto" style="max-width: 100vw;">
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
        <TransitionRoot as="template" :show="archiveeStatus !== null">
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

                <div class="fixed inset-0 z-50 overflow-y-auto" style="max-width: 100vw;">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Archiveren</DialogTitle>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">Weet je zeker dat je alle sollicitaties in <span class="font-bold">{{ archiveeStatus?.name }}</span> wilt archiveren?</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                    <button type="button"
                                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                                            @click="saveArchiveStatus">Archiveren</button>
                                    <button type="button"
                                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                            @click="revertArchiveStatus"
                                            ref="cancelButtonRef">Annuleren</button>
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
