<template>
    <div>
<TransitionRoot as="template" :show="sidebarOpen">
    <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-900/80" />
        </TransitionChild>

        <div class="fixed inset-0 flex">
            <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
                <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                    <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                        <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                            <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                <span class="sr-only">Close sidebar</span>
                                <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                            </button>
                        </div>
                    </TransitionChild>
                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-2">
                        <div class="flex h-16 shrink-0 items-center">
                            <img class="h-8 w-auto" src="http://staging.werkenbijkik.nl/wp-content/uploads/2023/03/KiK_Logo_3D_4c.svg" alt="Your Company" />
                        </div>
                        <nav class="flex flex-1 flex-col">
                            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                <li>
                                    <ul role="list" class="-mx-2 space-y-1">
                                        <li v-for="item in navigation" :key="item.name">
                                            <a :href="item.href" :class="[item.current ? 'bg-gray-50 text-red-600' : 'text-gray-700 hover:text-red-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                <component :is="item.icon" :class="[item.current ? 'text-red-600' : 'text-gray-400 group-hover:text-red-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                                {{ item.name }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </DialogPanel>
            </TransitionChild>
        </div>
    </Dialog>
</TransitionRoot>

<!-- Static sidebar for desktop -->
<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6">
        <div class="flex h-24 shrink-0 items-center">
            <img class="h-16 w-auto" src="http://staging.werkenbijkik.nl/wp-content/uploads/2023/03/KiK_Logo_3D_4c.svg" alt="Your Company" />
        </div>
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <li v-for="item in navigation" :key="item.name">
                            <a :href="item.href" :class="[item.current ? 'bg-gray-50 text-red-600' : 'text-gray-700 hover:text-red-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                <component :is="item.icon" :class="[item.current ? 'text-red-600' : 'text-gray-400 group-hover:text-red-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                {{ item.name }}
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>

<div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden">
    <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
        <span class="sr-only">Open sidebar</span>
        <Bars3Icon class="h-6 w-6" aria-hidden="true" />
    </button>
    <div class="flex-1 text-sm font-semibold leading-6 text-gray-900">Dashboard</div>
    <a href="#">
        <span class="sr-only">Your profile</span>
        <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
    </a>
</div>

<main class="py-10 lg:pl-72 ">
    <div class="px-4 sm:px-6 lg:px-8">
        <slot />
    </div>
</main>
</div>
</template>

<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {
    ArrowLeftOnRectangleIcon,
    Bars3Icon,
    CalendarIcon,
    ChartPieIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
    TagIcon,
    MapPinIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'

const navigation = [
    { name: 'Dashboard', href: '#', icon: HomeIcon, current: true },
    { name: 'Locaties', href: '#', icon: MapPinIcon, current: false },
    { name: 'Statussen', href: '#', icon: TagIcon, current: false },
    { name: 'Uitloggen', href: '#', icon: ArrowLeftOnRectangleIcon, current: false },
]

const sidebarOpen = ref(false)
</script>
