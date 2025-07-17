<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
const user = usePage().props.auth.user;
const form = useForm({
    name: user.name,
    email: user.email,
});
const emailInput = ref(null);
watch(
    () => props.status,
    (val) => {
        if (val === "verification-link-sent") {
            setTimeout(() => form.reset("email"), 2000);
        }
    }
);
function submit() {
    form.patch(route("profile.update"), {
        preserveScroll: true,
    });
}
</script>
<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <label class="block text-white font-semibold mb-1">Name</label>
            <input
                v-model="form.name"
                type="text"
                class="border border-[#232323] bg-[#232323] text-white placeholder-gray-400 rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-400 font-medium"
                placeholder="Your name"
                autocomplete="name"
            />
            <div
                v-if="form.errors.name"
                class="text-red-400 text-sm mt-1 font-semibold"
            >
                {{ form.errors.name }}
            </div>
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Email</label>
            <input
                v-model="form.email"
                ref="emailInput"
                type="email"
                class="border border-[#232323] bg-[#232323] text-white placeholder-gray-400 rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-400 font-medium"
                placeholder="Your email"
                autocomplete="username"
            />
            <div
                v-if="form.errors.email"
                class="text-red-400 text-sm mt-1 font-semibold"
            >
                {{ form.errors.email }}
            </div>
        </div>
        <button
            type="submit"
            class="bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-400 text-white px-6 py-2 rounded-lg shadow hover:opacity-90 transition w-full font-bold"
            :disabled="form.processing"
        >
            Save
        </button>
    </form>
</template>
