<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

defineOptions({ layout: CustomerLayout })

</script>

<template>
    <Head title="Profile" />

    <!-- <h2
        class="text-xl font-semibold leading-tight text-gray-800 text-center"
    >
        Profile
    </h2> -->


<div class="py-12 flex justify-center">

    <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div
            class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
        >
            <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
                class="max-w-xl"
            />
        </div>

        <div
            class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
        >
            <UpdatePasswordForm class="max-w-xl" />
        </div>
<!-- 
        <div
            class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
        >
            <DeleteUserForm class="max-w-xl" />
        </div> -->
    </div>
</div>
</template>
