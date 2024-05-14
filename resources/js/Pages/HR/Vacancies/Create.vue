<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import {Link} from "@inertiajs/vue3";
import {ref} from "vue";
import {SwitchGroup, Switch, SwitchLabel} from "@headlessui/vue";
import Multiselect from '@vueform/multiselect';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
    taxonomies : Object
});

const jobBoardMultiSelectOptions = ref([]);
for (const item of props.taxonomies['job-boards']) {
    jobBoardMultiSelectOptions.value.push({value:item.id, label:item.name});
}


const opleidingniveausOptions = ref([]);
for (const item of props.taxonomies['opleidingsniveau']) {
    opleidingniveausOptions.value.push({value:item.id, label:item.name});
}


const form = useForm({
    title: '',
    end_date: '',
    job_description: '',
    // video_url: '',
    _requirements: '',
    opleidingsniveau: [],
    _responsibilities: '',
    _salary: '',
    vacancyLocation: '',
    categorieen: '',
    jobBoards: [],
    status: 'publish',
});


const createVacancy = () => {
    form.post(route('vacancies.store'));
};


</script>

<template>
    <Head title="Dashboard" />

    <Layout>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Vacature</h1>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">

                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">

                        <form @submit.prevent="createVacancy()">
                            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl  md:col-span-2">
                                <div class="flex">
                                    <div class="px-4 sm:p-8 w-full flex flex-col gap-6">
                                        <div class="lg:col-span-1 ">
                                            <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Titel</label>
                                            <div class="">
                                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                    <input v-model="form.title" type="text" name="title" id="title" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                                </div>
                                                <p  v-if="form.errors.title"
                                                    v-text="form.errors.title"
                                                    class="text-red-500 text-sm mt-1"
                                                ></p>
                                            </div>
                                        </div>


                                        <div class="lg:col-span-1 ">
                                            <label for="_salary" class="block text-sm font-medium leading-6 text-gray-900">Salary:</label>
                                            <div class="mt-2">
                                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                    <input v-model="form._salary" type="text" name="_salary" id="_salary" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                                </div>
                                                <p  v-if="form.errors._salary"
                                                    v-text="form.errors._salary"
                                                    class="text-red-500 text-sm mt-1"
                                                ></p>
                                            </div>
                                        </div>

                                        <div class="lg:col-span-2 ">
                                            <label for="job_description" class="block text-sm font-medium leading-6 text-gray-900">Job description:</label>
                                            <QuillEditor v-model:content="form.job_description" contentType="html" theme="snow" />
                                            <p  v-if="form.errors.job_description"
                                                v-text="form.errors.job_description"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                        </div>

                                        <div class="lg:col-span-2  ">
                                            <label for="_requirements" class="block text-sm font-medium leading-6 text-gray-900">Requirements:</label>
                                            <QuillEditor v-model:content="form._requirements" contentType="html" theme="snow" />
                                            <p  v-if="form.errors._requirements"
                                                v-text="form.errors._requirements"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                        </div>

                                        <div class="lg:col-span-2 ">
                                            <label for="_responsibilities" class="block text-sm font-medium leading-6 text-gray-900">Responsibilities:</label>
                                            <QuillEditor v-model:content="form._responsibilities" contentType="html" theme="snow" />
                                            <p  v-if="form.errors._responsibilities"
                                                v-text="form.errors._responsibilities"
                                                class="text-red-500 text-sm mt-1"
                                            ></p>
                                        </div>
                                    </div>
                                    <div class="px-4 sm:p-8 w-[400px] shrink-0">
                                        <div class="mt-2 flex flex-col gap-6">

                                            <div class="lg:col-span-1">
                                                <label for="status" class="block text-sm font-medium leading-6 text-gray-900">Status:</label>
                                                <div class="relative">
                                                    <select v-model="form.status" class="w-full flex-1 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                        <option value="publish">Gepubliceerd</option>
                                                        <option value="draft">Draft</option>
                                                    </select>

                                                    <p  v-if="form.errors.status"
                                                        v-text="form.errors.status"
                                                        class="text-red-500 text-sm mt-1"
                                                    ></p>

                                                </div>
                                            </div>

                                            <div class="lg:col-span-1 ">
                                                <label for="end date" class="block text-sm font-medium leading-6 text-gray-900">Eind datum:</label>
                                                <Datepicker v-model="form.end_date" />
                                            </div>

                                            <div class="lg:col-span-1">
                                                <label for="opleidingsniveau" class="block text-sm font-medium leading-6 text-gray-900">Opleidingsniveau:</label>
                                                <div class="relative">
                                                    <Multiselect
                                                        v-model="form.opleidingsniveau"
                                                        mode="tags"
                                                        :close-on-select="false"
                                                        :options="opleidingniveausOptions"
                                                        class="multiselect-red"
                                                    />

                                                    <p  v-if="form.errors.opleidingsniveau"
                                                        v-text="form.errors.opleidingsniveau"
                                                        class="text-red-500 text-sm mt-1"
                                                    ></p>

                                                </div>
                                            </div>
                                            <div class="lg:col-span-1">
                                                <label for="jobBoard" class="block text-sm font-medium leading-6 text-gray-900">Job Boards:</label>
                                                <div class="relative">
                                                    <Multiselect
                                                        v-model="form.jobBoards"
                                                        mode="tags"
                                                        :close-on-select="false"
                                                        :options="jobBoardMultiSelectOptions"
                                                        class="multiselect-red"
                                                    />
                                                    <p  v-if="form.errors.jobBoard"
                                                        v-text="form.errors.jobBoard"
                                                        class="text-red-500 text-sm mt-1"
                                                    ></p>

                                                </div>
                                            </div>
                                            <div class="lg:col-span-1">
                                                <label for="vacancyLocation" class="block text-sm font-medium leading-6 text-gray-900">Filiaal:</label>
                                                <div class="relative">
                                                    <select v-model="form.vacancyLocation" class="w-full flex-1 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                        <option v-for="vacancyLocation in taxonomies['vacancy-location']" :value="vacancyLocation.id">{{vacancyLocation.name}}</option>
                                                    </select>

                                                    <p  v-if="form.errors.vacancyLocation"
                                                        v-text="form.errors.vacancyLocation"
                                                        class="text-red-500 text-sm mt-1"
                                                    ></p>

                                                </div>
                                            </div>
                                            <div class="lg:col-span-1 ">
                                                <label for="categorieen" class="block text-sm font-medium leading-6 text-gray-900">Categorie:</label>
                                                <div class="relative">
                                                    <select v-model="form.categorieen" class="w-full flex-1 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                        <option v-for="categorieen in taxonomies['categorieen']" :value="categorieen.id">{{categorieen.name}}</option>
                                                    </select>

                                                    <p  v-if="form.errors.categorieen"
                                                        v-text="form.errors.categorieen"
                                                        class="text-red-500 text-sm mt-1"
                                                    ></p>

                                                </div>
                                            </div>

<!--                                            <div class="flex flex-col  justify-center ">-->
<!--                                                <label for="video_url" class="block text-sm font-medium leading-6 text-gray-900">Video URL:</label>-->
<!--                                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 ">-->
<!--                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">-->
<!--                                                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>-->
<!--                                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">Selecteer of drag & drop</p>-->
<!--                                                        <p class="text-xs text-gray-500 dark:text-gray-400">.mp4, .gif</p>-->
<!--                                                    </div>-->
<!--                                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">-->
<!--                                                        {{ form.progress.percentage }}%-->
<!--                                                    </progress>-->
<!--                                                    <input id="dropzone-file" @input="form.video_url = $event.target.files[0]" type="file" class="hidden" />-->
<!--                                                </label>-->
<!--                                            </div>-->
                                        </div>
                                        <div class="mt-2  lg:col-span-1" v-if="form.video_url">

                                            <div class="mt-2">
                                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-red-600 sm:max-w-md">
                                                    <input v-model="form.video_url" type="text" name="video_url" id="video_url" class="block flex-1 border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" />
                                                </div>
                                                <p  v-if="form.errors.video_url"
                                                    v-text="form.errors.video_url"
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
<style>
    .dragging {
        @apply bg-white opacity-100 border-dashed border-2 border-gray-400;
    }

    .ghosting {
        @apply bg-green-50;
    }
    .multiselect-red {
        --ms-tag-bg: rgb(239 68 68 / var(--tw-bg-opacity));
    }
    .ql-container {
        height: auto !important;
    }
</style>
<style src="@vueform/multiselect/themes/default.css"></style>
