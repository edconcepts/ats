<style src="@vueform/multiselect/themes/default.css"></style>
<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {Link} from "@inertiajs/vue3";
import {ref} from "vue";
import {SwitchGroup, Switch, SwitchLabel} from "@headlessui/vue";
import Multiselect from '@vueform/multiselect'
defineProps({
    locations: Object,
});

const form = useForm({
    recipients: [],
    message: '',
});



const sendNotification = () => {
    form.post(route('notification-send.store'), {
        onSuccess: () => {
            form.reset();
        }
    })
};
</script>

<template>
    <Head title="Dashboard" />

    <Layout>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Verstuur melding</h1>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">

                </div>
            </div>

            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">

                        <form @submit.prevent="sendNotification" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                            <div class="px-4 py-6 sm:p-8">
                                <div class="grid grid-cols-1 gap-x-6 gap-y-8">
                                    <div class="rounded-md bg-green-50 p-4" v-if="form.recentlySuccessful">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-green-800">Succesvol verstuurd</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:6">
                                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Ontvangers</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600">
                                                <Multiselect v-model="form.recipients" mode="tags" :options="locations"></Multiselect>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="">
                                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Bericht</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 ">
                                                <textarea v-model="form.message" rows="4" name="comment" id="comment" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                                <button
                                type="submit"
                                class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                :disabled="form.processing"
                                >Versturen</button>
                            </div>
                        </form>
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
