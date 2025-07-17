<script setup>
import { useForm } from "@inertiajs/vue3";
defineProps({ postId: Number });
const form = useForm({
    post_id: postId,
    body: "",
});
function submit() {
    form.post(route("comment.store"), {
        preserveScroll: true,
        onSuccess: () => form.reset("body"),
    });
}
</script>
<template>
    <form @submit.prevent="submit" class="flex gap-2 mt-2">
        <input
            v-model="form.body"
            type="text"
            class="border rounded px-2 py-1 text-sm w-3/4"
            placeholder="Add a comment..."
            required
        />
        <button
            type="submit"
            class="text-green-600 ml-2"
            :disabled="form.processing"
        >
            Comment
        </button>
    </form>
    <div v-if="form.errors.body" class="text-red-600 text-sm">
        {{ form.errors.body }}
    </div>
</template>
