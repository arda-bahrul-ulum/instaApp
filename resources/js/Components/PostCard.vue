<script setup>
import { ref, computed } from "vue";
import { usePage, router } from "@inertiajs/vue3";
const props = defineProps({ post: Object });
const page = usePage();
const userId = page.props.auth.user.id;
const isLiked = computed(() =>
    props.post.likes.some((l) => l.user_id === userId)
);
const commentBody = ref("");
const commentProcessing = ref(false);
const commentError = ref("");

function toggleLike() {
    if (isLiked.value) {
        router.delete(route("like.destroy"), {
            data: { post_id: props.post.id },
            preserveScroll: true,
        });
    } else {
        router.post(
            route("like.store"),
            { post_id: props.post.id },
            { preserveScroll: true }
        );
    }
}

function submitComment() {
    commentProcessing.value = true;
    commentError.value = "";
    router.post(
        route("comment.store"),
        {
            post_id: props.post.id,
            body: commentBody.value,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                commentBody.value = "";
                commentProcessing.value = false;
            },
            onError: (err) => {
                commentError.value = err.body || "Failed to add comment.";
                commentProcessing.value = false;
            },
        }
    );
}

function formatDate(date) {
    return new Date(date).toLocaleString("id-ID", {
        day: "2-digit",
        month: "long",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });
}
</script>

<template>
    <div
        class="bg-neutral-900 rounded-xl shadow-lg overflow-hidden flex flex-col border border-neutral-800 mb-8"
    >
        <div class="flex items-center gap-3 mb-4 p-6 pb-0">
            <div
                class="w-10 h-10 bg-gradient-to-tr from-pink-500 to-yellow-400 rounded-full flex items-center justify-center font-bold text-white"
            >
                {{ post.user.name.charAt(0).toUpperCase() }}
            </div>
            <span class="font-semibold text-white">{{ post.user.name }}</span>
            <span class="text-xs text-gray-400 ml-auto">{{
                formatDate(post.created_at)
            }}</span>
        </div>
        <img
            :src="`/storage/${post.image_path}`"
            :alt="post.caption"
            class="w-full h-96 object-cover"
        />
        <div class="p-6 pt-4 flex flex-col gap-4">
            <div class="px-1 pb-2">
                <span class="font-bold text-white mr-2">{{
                    post.user.name
                }}</span>
                <span class="text-white text-base align-middle">{{
                    post.caption
                }}</span>
            </div>
            <div class="flex items-center gap-6 mt-2">
                <button
                    @click="toggleLike"
                    :class="
                        isLiked
                            ? 'text-pink-500'
                            : 'text-gray-400 hover:text-pink-500'
                    "
                    class="flex items-center gap-1"
                >
                    <svg
                        v-if="isLiked"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        class="w-7 h-7"
                    >
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                        />
                    </svg>
                    <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        class="w-7 h-7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"
                        />
                    </svg>
                    <span>{{ post.likes.length }}</span>
                </button>
                <span class="flex items-center gap-1 text-gray-400">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        class="w-7 h-7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.8l-4 1 1-4A8.96 8.96 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                        />
                    </svg>
                    <span>{{ post.comments.length }}</span>
                </span>
            </div>
            <div class="mt-4">
                <h4 class="font-semibold text-sm mb-1 text-gray-300">
                    Comments
                </h4>
                <ul class="mb-2 max-h-32 overflow-y-auto">
                    <li
                        v-for="comment in post.comments"
                        :key="comment.id"
                        class="text-sm text-gray-300 mb-1 bg-neutral-800 rounded px-2 py-1"
                    >
                        <span class="font-bold text-white"
                            >{{ comment.user.name }}:</span
                        >
                        {{ comment.body }}
                    </li>
                </ul>
                <form @submit.prevent="submitComment" class="flex gap-2 mt-2">
                    <textarea
                        v-model="commentBody"
                        class="border rounded px-2 py-1 text-sm w-3/4 bg-neutral-800 text-white min-h-[40px] resize-y"
                        placeholder="Add a comment..."
                        required
                        rows="2"
                    ></textarea>
                    <button
                        type="submit"
                        class="ml-2 flex items-center justify-center"
                        :disabled="commentProcessing"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 48 48"
                            fill="#2563eb"
                            class="w-6 h-6"
                        >
                            <path d="M6 42L44 24L6 6V20L34 24L6 28V42Z" />
                        </svg>
                    </button>
                </form>
                <div v-if="commentError" class="text-red-400 text-xs mt-1">
                    {{ commentError }}
                </div>
            </div>
        </div>
    </div>
</template>
