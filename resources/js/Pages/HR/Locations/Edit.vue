<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {Link} from "@inertiajs/vue3";
import {ref} from "vue";
import {SwitchGroup, Switch, SwitchLabel} from "@headlessui/vue";

defineProps({
    location: Object,
});

const form = useForm({
    name: usePage().props.location.manager?.name,
    email: usePage().props.location.manager?.email,
    phone: usePage().props.location.manager?.phone,
    regio_manager_name: usePage().props.location.regio_manager_name,
    regio_manager_email: usePage().props.location.regio_manager_email,
    location_address: usePage().props.location.location_address,
    password: '',
});


const updateUser = (location) => {
    form.put(route('locations.update', { location: location.id }));
};
</script>

<template>
    <Head title="Dashboard" />

    <Layout>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">{{ location.name }}</h1>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">

                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">

                        <form @submit.prevent="updateUser(location)" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                            <div class="px-4 py-6 sm:p-8">
                                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Naam manager</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                <input v-model="form.name" type="text" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                            </div>
                                            <p  v-if="form.errors.name"
                                                v-text="form.errors.name"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Gebruikersnaam</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                <input v-model="form.email" type="email" name="email" id="email" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                            </div>
                                            <p  v-if="form.errors.email"
                                                v-text="form.errors.email"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Telefoonnummer</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                <input v-model="form.phone" type="text" name="phone" id="phone" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                            </div>
                                            <p  v-if="form.errors.phone"
                                                v-text="form.errors.phone"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Wachtwoord</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                <input
                                                    :placeholder="usePage().props.location.manager?.password ? '********' : ''"
                                                    v-model="form.password" type="text" name="password" id="password" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                            </div>
                                            <p  v-if="form.errors.password"
                                                v-text="form.errors.password"
                                                class="text-red-500 text-sm mt-1"

                                            ></p>
<!--                                            <p class="block text-sm font-medium leading-6 text-gray-900" v-if="usePage().props.location.manager?.password">Heeft een wachtwoord</p>-->
                                        </div>
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label for="regio_manager_name" class="block text-sm font-medium leading-6 text-gray-900">Naam regiomanager</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                <input v-model="form.regio_manager_name" type="text" name="regio_manager_name" id="regio_manager_name" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                            </div>
                                            <p  v-if="form.errors.regio_manager_name"
                                                v-text="form.errors.regio_manager_name"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label for="regio_manager_email" class="block text-sm font-medium leading-6 text-gray-900">E-mailadres regiomanager</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                <input v-model="form.regio_manager_email" type="text" name="regio_manager_email" id="regio_manager_email" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                            </div>
                                            <p  v-if="form.errors.regio_manager_email"
                                                v-text="form.errors.regio_manager_email"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label for="location_address" class="block text-sm font-medium leading-6 text-gray-900">Adres filiaal</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                <input v-model="form.location_address" type="text" name="location_address" id="location_address" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                            </div>
                                            <p  v-if="form.errors.location_address"
                                                v-text="form.errors.location_address"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                        </div>
                                    </div>
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
