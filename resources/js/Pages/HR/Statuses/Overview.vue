<template>
    <Head title="Statussen"/>

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
                                <draggable
                                    :list="statuses"
                                    group="statuses"
                                    item-key="id"
                                    ghost-class="ghosting"
                                    drag-class="dragging"
                                    filter="a"
                                    @change="onDragEnd($event)"
                                    class="divide-y divide-gray-200 bg-white"
                                    tag="tbody"
                                >
                                    <template #item="{ element }">
                                        <tr class="cursor-move" v-show="element.id !== archive_status_id">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 select-none">
                                                {{ element.name }}
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <Link :href="route('statuses.edit', element)" class="text-red-600 hover:text-red-900"
                                                >Bewerken<span class="sr-only">, {{ element.name }}</span>
                                            </Link>
                                            </td>
                                        </tr>
                                    </template>
                                </draggable>
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
<script setup>
    import Layout from '@/Layouts/Layout.vue';
    import {Head, router} from '@inertiajs/vue3';
    // import {ref} from "vue";
    import {Link} from "@inertiajs/vue3";
    import draggable from "vuedraggable";

    defineProps({
        statuses : Array,
        archive_status_id : Number
    });

    const onDragEnd = (event) => {
        router.post(route('statuses.reorder'), {
            id: event.moved.element.id,
            newIndex: event.moved.newIndex,
            oldIndex: event.moved.oldIndex,
        });
    };
</script>
