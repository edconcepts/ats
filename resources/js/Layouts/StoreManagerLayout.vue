<template>
    <Modal />
    <div>
        <nav class="bg-white shadow-sm">
            <div class="mx-auto  px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex flex-shrink-0 items-center">
                            <img class="h-12 w-auto" src="/KiK_Logo_3D_4c.svg" alt="Kik" />
                        </div>
                        <div class=" -my-px ml-6 flex space-x-8">
                            <Link
                                :href="route('dashboard')"
                                class="text-gray-500 inline-flex items-center px-1 pt-1 text-sm font-medium"
                                :class="{ 'border-b-2 border-red-500 text-gray-900': route().current('dashboard') }"
                                aria-current="page"
                            >
                                Agenda
                            </Link>
                            <Link
                                :href="route('store-manager.notifications')"
                                class="border-transparent flex-inline gap-1 text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium"
                                :class="{ 'border-b-2 border-red-500 text-gray-900': route().current('store-manager.notifications') }"
                            >
                                Meldingen
                                <span
                                    v-if="usePage().props.auth.notification_count > 0"
                                    class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700"
                                >{{ usePage().props.auth.notification_count }}</span>
                            </Link>

                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <Link :href="route('logout')" method="post" class="border-transparent gap-2 text-gray-400 hover:text-gray-500 inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                        </Link>
                    </div>

                </div>
            </div>

        </nav>
        <main class="py-4 sm:py-6 lg:py-8 ">
            <div class="px-4 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import {Link, usePage} from "@inertiajs/vue3";
import {onMounted} from "vue";
import {Modal} from "momentum-modal";
</script>
