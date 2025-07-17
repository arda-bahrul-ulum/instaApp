<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import ProfileForm from "./ProfileForm.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import { watch } from "vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const page = usePage();
const toast = useToast();
let lastFlash = { success: null, error: null };

watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success && flash.success !== lastFlash.success) {
            toast.success(flash.success);
            lastFlash.success = flash.success;
        }
        if (flash?.error && flash.error !== lastFlash.error) {
            toast.error(flash.error);
            lastFlash.error = flash.error;
        }
    },
    { deep: true }
);
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div class="text-xl font-bold text-white text-center mt-8">
                Profile
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-5xl space-y-16 px-2">
                <div class="flex justify-center items-start w-full">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-16 w-full mx-auto"
                    >
                        <div
                            class="bg-[#181818] border border-[#232323] p-16 rounded-2xl shadow-lg w-full col-span-2"
                        >
                            <ProfileForm
                                :must-verify-email="mustVerifyEmail"
                                :status="status"
                            />
                        </div>
                    </div>
                </div>
                <div
                    class="bg-[#181818] border border-[#232323] p-20 rounded-2xl shadow-lg max-w-4xl mx-auto"
                >
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
