<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import {Link} from "@inertiajs/vue3";
import {ref} from "vue";
import {SwitchGroup, Switch, SwitchLabel} from "@headlessui/vue";

const props = defineProps({
    status : Object
});

const form = useForm({
    name: props.status.name,
    email: {
        subject: props.status.email?.subject,
        body: props.status.email?.body,
    },
});

const shortcodes = [
    'naam',
    'vacature',
    'locatie',
];

const hasEmail = ref(props.status.email?.subject ? true : false);

const updateStatus = (status) => {
    form.put(route('hr.statuses.update',status));
};

const insertIntoBody = (event) => {
    form.values.body += event.target.value;
};
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

                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">

                        <form @submit.prevent="updateStatus(status)" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                            <div class="px-4 py-6 sm:p-8">
                                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="website" class="block text-sm font-medium leading-6 text-gray-900">Naam</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                <input v-model="form.name" type="text" name="website" id="website" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                            </div>
                                            <p  v-if="form.errors.name"
                                                v-text="form.errors.name"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                    <SwitchGroup as="div" class="flex items-center">
                                        <Switch v-model="hasEmail" :class="[hasEmail ? 'bg-red-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2']">
                                            <span aria-hidden="true" :class="[hasEmail ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
                                        </Switch>
                                        <SwitchLabel as="span" class="ml-3 text-sm">
                                            <span class="font-medium text-gray-900">E-mail versturen bij status wijziging</span>
                                        </SwitchLabel>
                                    </SwitchGroup>
                                    </div>

                                    <template v-if="hasEmail">
                                        <div class="sm:col-span-4">
                                            <label for="email_subject" class="block text-sm font-medium leading-6 text-gray-900">Onderwerp</label>
                                            <div class="mt-2">
                                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                    <input type="text" name="email_subject" id="email_subject" v-model="form.email.subject" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                                </div>
                                                <p  v-if="form.errors['email.subject']"
                                                    v-text="form.errors['email.subject']"
                                                    class="text-red-500 text-sm mt-1"
                                                ></p>
                                            </div>
                                        </div>
                                        <div class="col-span-full">
                                            <label for="email_body" class="block text-sm font-medium leading-6 text-gray-900">E-mailtekst</label>
                                            <div class="mt-2">
                                                <textarea id="email_body" name="email_body" v-model="form.email.body" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm sm:leading-6" />
                                            </div>
                                            <!-- TODO make these error components -->
                                            <p  v-if="form.errors['email.body']"
                                                v-text="form.errors['email.body']"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                            <p class="mt-3 text-sm leading-6 text-gray-600">Beschikbare shortcodes:</p>
                                            <div class="flex gap-2">
                                                <span v-for="shortcode in shortcodes" @click="insertIntoBody" class="cursor-pointer hover:bg-gray-100 inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ shortcode }}</span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                                <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                                <button
                                type="submit"
                                class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                :disabled="form.processing"
                                >Opslaan</button>
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
