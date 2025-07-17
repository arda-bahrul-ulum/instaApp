<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
const confirmingUserDeletion = ref(false);
const form = useForm({
    password: "",
});
function confirmUserDeletion() {
    confirmingUserDeletion.value = true;
}
function deleteUser() {
    form.delete(route("profile.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => form.reset("password"),
    });
}
function closeModal() {
    confirmingUserDeletion.value = false;
    form.reset();
}
</script>

<template>
    <div class="bg-[#181818] border border-[#232323] p-8 rounded-2xl shadow-lg">
        <h2 class="text-lg font-bold text-white mb-2">Delete Account</h2>
        <p class="text-gray-400 mb-4">
            Once your account is deleted, all of its resources and data will be
            permanently deleted. Please enter your password to confirm you would
            like to permanently delete your account.
        </p>
        <button
            @click="confirmUserDeletion"
            class="border border-red-600 text-red-600 hover:bg-red-600 hover:text-white px-6 py-2 rounded-lg font-bold mb-4 w-full bg-transparent shadow-none transition"
        >
            Delete Account
        </button>
        <div
            v-if="confirmingUserDeletion"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        >
            <div
                class="bg-[#181818] border border-[#232323] p-8 rounded-2xl shadow-lg w-full max-w-md"
            >
                <h3 class="text-lg font-bold text-white mb-2">
                    Are you sure you want to delete your account?
                </h3>
                <form @submit.prevent="deleteUser" class="space-y-6">
                    <div>
                        <label class="block text-white font-semibold mb-1"
                            >Password</label
                        >
                        <input
                            v-model="form.password"
                            type="password"
                            class="border border-[#232323] bg-[#232323] text-white placeholder-gray-400 rounded-lg px-3 py-2 w-full focus:ring focus:ring-pink-400 font-medium"
                            placeholder="Password"
                            autocomplete="current-password"
                        />
                        <div
                            v-if="form.errors.password"
                            class="text-red-400 text-sm mt-1 font-semibold"
                        >
                            {{ form.errors.password }}
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <button
                            type="button"
                            @click="closeModal"
                            class="flex-1 bg-gray-700 text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-600 transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="flex-1 border border-red-600 text-red-600 hover:bg-red-600 hover:text-white px-6 py-2 rounded-lg font-bold bg-transparent shadow-none transition"
                        >
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
