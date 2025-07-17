<script setup>
import { useForm } from "@inertiajs/vue3";
const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});
function submit() {
    form.put(route("password.update"));
}
</script>
<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <label class="block text-white font-semibold mb-1"
                >Current Password</label
            >
            <input
                v-model="form.current_password"
                type="password"
                class="border border-[#232323] bg-[#232323] text-white placeholder-gray-400 rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-400 font-medium"
                placeholder="Current Password"
                autocomplete="current-password"
            />
            <div
                v-if="form.errors.current_password"
                class="text-red-400 text-sm mt-1 font-semibold"
            >
                {{ form.errors.current_password }}
            </div>
        </div>
        <div>
            <label class="block text-white font-semibold mb-1"
                >New Password</label
            >
            <input
                v-model="form.password"
                type="password"
                class="border border-[#232323] bg-[#232323] text-white placeholder-gray-400 rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-400 font-medium"
                placeholder="New Password"
                autocomplete="new-password"
            />
            <div
                v-if="form.errors.password"
                class="text-red-400 text-sm mt-1 font-semibold"
            >
                {{ form.errors.password }}
            </div>
        </div>
        <div>
            <label class="block text-white font-semibold mb-1"
                >Confirm Password</label
            >
            <input
                v-model="form.password_confirmation"
                type="password"
                class="border border-[#232323] bg-[#232323] text-white placeholder-gray-400 rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-400 font-medium"
                placeholder="Confirm Password"
                autocomplete="new-password"
            />
            <div
                v-if="form.errors.password_confirmation"
                class="text-red-400 text-sm mt-1 font-semibold"
            >
                {{ form.errors.password_confirmation }}
            </div>
        </div>
        <button
            type="submit"
            class="bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-400 text-white px-6 py-2 rounded-lg shadow hover:opacity-90 transition w-full font-bold"
            :disabled="form.processing"
        >
            Update Password
        </button>
    </form>
</template>
