<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import PostCard from "@/Components/PostCard.vue";
import { onMounted } from "vue";
import { useToast } from "vue-toastification";

defineProps({ posts: Array });

const toast = useToast();
const page = usePage();

onMounted(() => {
    if (page.props.flash && page.props.flash.success) {
        toast.success(page.props.flash.success);
    }
});
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="py-8">
            <template v-if="posts.length === 0">
                <div
                    class="flex flex-col items-center justify-center min-h-[60vh]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-24 w-24 text-gray-600 mb-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7M3 7a4 4 0 014-4h10a4 4 0 014 4M3 7h18"
                        />
                    </svg>
                    <div class="text-gray-400 text-2xl mb-2 text-center">
                        No posts yet
                    </div>
                    <div class="text-gray-500 text-lg text-center">
                        Follow someone or create a post to see something here!
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="max-w-xl mx-auto flex flex-col gap-8">
                    <PostCard
                        v-for="post in posts"
                        :key="post.id"
                        :post="post"
                    />
                </div>
            </template>
        </div>
    </AuthenticatedLayout>
</template>
