<script setup>
import { ref, nextTick } from "vue";
import { usePage, router } from "@inertiajs/vue3";
const show = ref(false);
const user = usePage().props.auth.user;
const showLogoutModal = ref(false);

function logout() {
    router.post(route("logout"));
}
function closeDropdown() {
    show.value = false;
}
function toggleDropdown() {
    show.value = !show.value;
    if (show.value)
        nextTick(() => {
            document.getElementById("user-dropdown-logout")?.focus();
        });
}
function askLogout() {
    show.value = false;
    showLogoutModal.value = true;
}
function closeLogoutModal() {
    showLogoutModal.value = false;
}
function confirmLogout() {
    logout();
    showLogoutModal.value = false;
}
</script>
<template>
    <div class="relative z-50">
        <button
            @click="toggleDropdown"
            class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition"
        >
            <div
                class="w-10 h-10 rounded-full bg-gradient-to-tr from-pink-500 to-yellow-400 flex items-center justify-center text-white font-extrabold text-2xl shadow-md"
                style="letter-spacing: 1px"
            >
                {{ user.name.charAt(0).toUpperCase() }}
            </div>
            <span class="font-semibold text-white">{{ user.name }}</span>
        </button>
        <transition name="fade">
            <div v-if="show">
                <div
                    class="fixed inset-0 z-40 pointer-events-auto"
                    @click="closeDropdown"
                ></div>
                <div
                    class="absolute left-0 bottom-14 w-40 bg-neutral-900 border border-neutral-700 rounded shadow-lg z-50"
                >
                    <button
                        id="user-dropdown-logout"
                        @click="askLogout"
                        class="block w-full text-left px-4 py-2 text-red-400 hover:bg-neutral-800"
                    >
                        Logout
                    </button>
                </div>
            </div>
        </transition>
        <div
            v-if="showLogoutModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        >
            <div
                class="bg-[#181818] border border-[#232323] p-8 rounded-2xl shadow-lg w-full max-w-md"
            >
                <h3 class="text-lg font-bold text-white mb-2">
                    Are you sure you want to logout?
                </h3>
                <div class="flex gap-4 mt-6">
                    <button
                        type="button"
                        @click="closeLogoutModal"
                        class="flex-1 bg-gray-700 text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-600 transition"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        @click="confirmLogout"
                        class="flex-1 border border-red-600 text-red-600 hover:bg-red-600 hover:text-white px-6 py-2 rounded-lg font-bold bg-transparent shadow-none transition"
                    >
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.15s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
