<template>
    <Modal />
    <div>

<main class="py-4 sm:py-6 lg:py-8 ">
    <div class="px-4 sm:px-6 lg:px-8">

        <slot />
    </div>
</main>
</div>
</template>

<script setup>
import { ref } from 'vue'
import {Link, usePage} from '@inertiajs/vue3';
import { Modal } from "momentum-modal";
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

// if (usePage().props.user)
const navigation =
    {
        hr: [
            { name: 'Dashboard', href: route('dashboard'), icon: HomeIcon, current: route().current('hr.dashboard.index'), method:false },
            { name: 'Locaties', href: route('hr.locations.index'), icon: MapPinIcon, current: route().current('hr.locations.index'), method:false },
            { name: 'Statussen', href: route('hr.statuses.index'), icon: TagIcon, current: route().current('hr.statuses*'), method:false },
            { name: 'Uitloggen', href: route('logout'), icon: ArrowLeftOnRectangleIcon, current: false, method: 'post' },
        ],
        store_manager: [
            { name: 'Dashboard', href: route('dashboard'), icon: HomeIcon, current: route().current('hr.dashboard.index'), method:false },
            { name: 'Uitloggen', href: route('logout'), icon: ArrowLeftOnRectangleIcon, current: false, method: 'post' },
        ]
    }


console.log(navigation)

const sidebarOpen = ref(false)
</script>
