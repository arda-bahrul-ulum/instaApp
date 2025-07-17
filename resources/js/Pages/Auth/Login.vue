<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Login" />
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
                InstaApp
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
                <div>
                    <div class="relative">
                        <input
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            placeholder="Password"
                            class="w-full bg-neutral-800 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 text-base placeholder-gray-400 border border-neutral-700"
                            autocomplete="current-password"
                            required
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white"
                        >
                            <svg
                                v-if="showPassword"
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10 0-1.657.336-3.234.938-4.675M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                            </svg>
                            <svg
                                v-else
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.938-4.675A9.956 9.956 0 0022 9c0 5.523-4.477 10-10 10a9.956 9.956 0 01-4.675-.938"
                                />
                            </svg>
                        </button>
                    </div>
                    <div
                        v-if="form.errors.password"
                        class="text-red-400 text-xs mt-1 font-semibold"
                    >
                        {{ form.errors.password }}
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-gray-300">
                        <input
                            type="checkbox"
                            v-model="form.remember"
                            class="rounded border-gray-600 bg-neutral-800 text-pink-500 focus:ring-pink-500"
                        />
                        <span class="text-sm">Remember me</span>
                    </label>
                    <Link
                        v-if="props.canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-pink-400 hover:underline"
                        >Forgot password?</Link
                    >
                </div>
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-400 text-white font-bold py-3 rounded-lg shadow hover:opacity-90 transition text-lg mt-2 disabled:opacity-60"
                    :disabled="form.processing"
                >
                    Log In
                </button>
                <div
                    v-if="props.status"
                    class="text-green-400 text-center text-sm mt-2"
                >
                    {{ props.status }}
                </div>
            </form>
            <div class="mt-8 text-center w-full">
                <span class="text-gray-400">Don't have an account?</span>
                <Link
                    :href="route('register')"
                    class="text-pink-400 font-semibold ml-2 hover:underline"
                    >Sign up</Link
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
