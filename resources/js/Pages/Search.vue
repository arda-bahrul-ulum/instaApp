<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import PostCard from "@/Components/PostCard.vue";

const props = defineProps({ posts: Array, search: String });
const search = ref(props.search || "");
// recent search dihapus

let debounceTimeout = null;
watch(search, (val) => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        router.get(
            route("search"),
            { q: val },
            { preserveState: true, replace: true }
        );
    }, 400);
});

function clearSearch() {
    search.value = "";
}
</script>

<template>
    <Head title="Search" />
    <AuthenticatedLayout>
        <div class="py-8">
            <div class="max-w-xl mx-auto">
                <h1 class="text-2xl font-bold text-white mb-6">Search</h1>
                <div class="relative mb-6">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search"
                        class="w-full bg-neutral-800 text-white rounded-xl px-5 py-3 pl-12 pr-10 focus:outline-none focus:ring-2 focus:ring-pink-500 text-lg placeholder-gray-400"
                    />
                    <svg
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <button
                        v-if="search"
                        @click="clearSearch"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white"
                    >
                        <svg
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
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
                <template v-if="search">
                    <div class="text-white text-lg font-semibold mb-2">
                        Results
                    </div>
                    <div
                        v-if="props.posts.length === 0"
                        class="text-gray-400 text-center py-12"
                    >
                        No posts found.
                    </div>
                    <div
                        v-if="props.posts.length > 0"
                        class="flex flex-col gap-8"
                    >
                        <PostCard
                            v-for="post in props.posts"
                            :key="post.id"
                            :post="post"
                        />
                    </div>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
