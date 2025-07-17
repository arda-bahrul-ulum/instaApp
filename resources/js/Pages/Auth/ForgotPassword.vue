<script setup>
import { Head, useForm } from "@inertiajs/vue3";

defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <Head title="Forgot Password" />
    <div
        class="min-h-screen flex flex-col justify-center items-center bg-black"
    >
        <div
            class="w-full max-w-md bg-[#181818] border border-[#232323] rounded-2xl shadow-lg p-10 flex flex-col items-center"
        >
            <div
                class="mb-8 text-4xl font-logo text-white select-none"
                style="
                    font-family: 'Billabong', cursive, sans-serif;
                    letter-spacing: 2px;
                "
            >
                Instagram
            </div>
            <div class="mb-6 text-gray-300 text-center text-base">
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.
            </div>
            <form @submit.prevent="submit" class="w-full flex flex-col gap-6">
                <div>
                    <input
                        v-model="form.email"
                        type="email"
                        placeholder="Email"
                        class="w-full bg-neutral-800 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 text-base placeholder-gray-400 border border-neutral-700"
                        autocomplete="username"
                        required
                        autofocus
                    />
                    <div
                        v-if="form.errors.email"
                        class="text-red-400 text-xs mt-1 font-semibold"
                    >
                        {{ form.errors.email }}
                    </div>
                </div>
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-400 text-white font-bold py-3 rounded-lg shadow hover:opacity-90 transition text-lg mt-2 disabled:opacity-60"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
                </button>
                <div
                    v-if="status"
                    class="text-green-400 text-center text-sm mt-2"
                >
                    {{ status }}
                </div>
            </form>
            <div class="mt-8 text-center w-full">
                <span class="text-gray-400">Back to</span>
                <a
                    href="/login"
                    class="text-pink-400 font-semibold ml-2 hover:underline"
                    >Login</a
                >
            </div>
        </div>
    </div>
</template>

<style scoped>
.font-logo {
    font-family: "Billabong", cursive, sans-serif;
}
</style>
