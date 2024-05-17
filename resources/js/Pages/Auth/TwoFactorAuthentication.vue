<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="code" value="Beveiligingscode" />

                <TextInput
                    id="code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.code"
                    required
                    autofocus
                    autocomplete="false"
                />

                <InputError class="mt-2" :message="form.errors.code" />
            </div>


            <div class="flex items-center justify-between mt-4">
                <Link
                    :href="route('logout')"
                    class="text-gray-700 hover:text-red-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"
                    method="post">
                    <component :is="ArrowLeftOnRectangleIcon"
                               class="text-gray-400 group-hover:text-red-600 h-6 w-6 shrink-0" aria-hidden="true"/>
                    Uitloggen
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import { ArrowLeftOnRectangleIcon } from '@heroicons/vue/24/outline'

    defineProps({
        canResetPassword: {
            type: Boolean,
        },
        status: {
            type: String,
        },
    });

    const form = useForm({
        code: '',
    });

    const submit = () => {
        form.post(route('2fa'), {
            onFinish: () => form.reset('code'),
        });
    };
</script>
