<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import { usePage } from "@inertiajs/vue3";
import { watch } from "vue";
import { ref } from "vue";
const props = defineProps({ posts: Array });

function editPost(postId) {
    router.visit(route("posts.edit", postId));
}
function deletePost(postId) {
    if (confirm("Are you sure you want to delete this post?")) {
        router.delete(route("posts.destroy", postId), {
            onSuccess: () => toast.success("Post deleted successfully."),
            onError: () => toast.error("Failed to delete post."),
        });
    }
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
const page = usePage();
const flash = page.props.flash || {};
const toast = useToast();
watch(
    () => flash.success,
    (val) => {
        if (val) toast.success(val);
    }
);
watch(
    () => flash.error,
    (val) => {
        if (val) toast.error(val);
    }
);
const showDeleteModal = ref(false);
const postToDelete = ref(null);

function openDeleteModal(postId) {
    postToDelete.value = postId;
    showDeleteModal.value = true;
}
function closeDeleteModal() {
    showDeleteModal.value = false;
    postToDelete.value = null;
}
function confirmDeletePost() {
    router.delete(route("posts.destroy", postToDelete.value), {
        onSuccess: () => {
            toast.success("Post deleted successfully.");
            closeDeleteModal();
        },
        onError: () => toast.error("Failed to delete post."),
    });
}
</script>

<template>
    <Head title="Posts" />
    <AuthenticatedLayout>
        <div class="py-8">
            <template v-if="posts.length === 0">
                <div
                    class="flex flex-col items-center justify-center min-h-[60vh]"
                >
                    <div class="text-gray-400 text-xl mb-8 text-center">
                        You have no posts yet.<br />Start sharing your moments!
                    </div>
                    <Link
                        :href="route('posts.create')"
                        class="bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-400 text-white px-12 py-5 rounded-2xl shadow-lg font-bold text-2xl hover:opacity-90 transition"
                    >
                        Create Your First Post
                    </Link>
                </div>
            </template>
            <template v-else>
                <div class="max-w-xl mx-auto mb-8 flex justify-end">
                    <Link
                        :href="route('posts.create')"
                        class="bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-400 text-white px-6 py-2 rounded-lg shadow font-bold hover:opacity-90 transition"
                    >
                        Create Post
                    </Link>
                </div>
                <div class="max-w-xl mx-auto flex flex-col gap-8">
                    <div
                        v-for="post in posts"
                        :key="post.id"
                        class="bg-neutral-900 rounded-xl shadow-lg overflow-hidden flex flex-col border border-neutral-800 hover:shadow-2xl transition relative mb-8"
                    >
                        <div
                            class="flex items-center gap-3 mb-4 p-6 pb-0 justify-between"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-tr from-pink-500 to-yellow-400 rounded-full flex items-center justify-center font-bold text-white"
                                >
                                    {{ post.user.name.charAt(0).toUpperCase() }}
                                </div>
                                <span class="font-semibold text-white">{{
                                    post.user.name
                                }}</span>
                            </div>
                            <div class="flex items-center gap-2 ml-auto">
                                <span class="text-xs text-gray-400">{{
                                    formatDate(post.created_at)
                                }}</span>
                            </div>
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
                                <span
                                    class="text-white text-base align-middle"
                                    >{{ post.caption }}</span
                                >
                            </div>
                            <div class="flex justify-end">
                                <button
                                    class="bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-400 text-white px-4 py-2 rounded-lg shadow font-bold hover:opacity-90 transition mr-2"
                                    @click="editPost(post.id)"
                                >
                                    Edit
                                </button>
                                <button
                                    class="border border-red-600 text-red-600 hover:bg-red-600 hover:text-white px-4 py-2 rounded-lg font-bold transition bg-transparent shadow-none"
                                    @click="openDeleteModal(post.id)"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        >
            <div
                class="bg-[#181818] border border-[#232323] p-8 rounded-2xl shadow-lg w-full max-w-md"
            >
                <h3 class="text-lg font-bold text-white mb-2">
                    Are you sure you want to delete this post?
                </h3>
                <div class="flex gap-4 mt-6">
                    <button
                        type="button"
                        @click="closeDeleteModal"
                        class="flex-1 bg-gray-700 text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-600 transition"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        @click="confirmDeletePost"
                        class="flex-1 border border-red-600 text-red-600 hover:bg-red-600 hover:text-white px-6 py-2 rounded-lg font-bold bg-transparent shadow-none transition"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
