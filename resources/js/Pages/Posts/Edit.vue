<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
const URL = window.URL || window.webkitURL;
const props = defineProps({ post: Object });

const form = useForm({
    caption: props.post.caption,
    image: null,
});

const page = usePage();
const flash = page.props.flash || {};

function submit() {
    form.post(route("posts.update", props.post.id), {
        forceFormData: true,
    });
}
</script>

<template>
    <Head title="Edit Post" />
    <AuthenticatedLayout>
        <template #header>
            <div class="text-xl font-bold text-white text-center mt-8">
                Edit Post
            </div>
        </template>
        <div class="flex justify-center items-start min-h-[60vh] mt-8">
            <div
                class="w-full max-w-5xl bg-[#181818] border border-[#232323] p-16 rounded-2xl shadow-lg"
            >
                <form @submit.prevent="submit" class="mt-4 space-y-6">
                    <div>
                        <label class="block text-gray-200 font-semibold mb-1"
                            >Image</label
                        >
                        <input
                            name="image"
                            @change="(e) => (form.image = e.target.files[0])"
                            type="file"
                            accept="image/*"
                            class="border border-neutral-700 bg-neutral-800 text-white rounded px-3 py-2 w-full file:bg-neutral-800 file:text-white file:border-0 file:rounded file:px-3 file:py-2"
                        />
                        <div
                            v-if="props.post.image_path && !form.image"
                            class="mt-2"
                        >
                            <img
                                :src="`/storage/${props.post.image_path}`"
                                alt="Current Image"
                                class="w-40 rounded"
                            />
                        </div>
                        <div v-if="form.image" class="mt-2">
                            <img
                                :src="
                                    form.image
                                        ? URL.createObjectURL(form.image)
                                        : ''
                                "
                                alt="Preview"
                                class="w-40 rounded"
                            />
                        </div>
                        <div
                            v-if="form.errors.image"
                            class="text-red-400 text-sm mt-1 font-semibold"
                        >
                            {{ form.errors.image }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-200 font-semibold mb-1"
                            >Caption</label
                        >
                        <input
                            v-model="form.caption"
                            type="text"
                            class="border border-neutral-700 bg-neutral-800 text-white placeholder-gray-400 rounded px-3 py-2 w-full focus:ring focus:ring-blue-400 font-medium"
                            placeholder="Edit your caption..."
                        />
                        <div
                            v-if="form.errors.caption"
                            class="text-red-400 text-sm mt-1 font-semibold"
                        >
                            {{ form.errors.caption }}
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="bg-gradient-to-tr from-pink-500 to-yellow-400 text-white px-6 py-2 rounded shadow hover:opacity-90 transition w-full font-bold"
                        :disabled="form.processing"
                    >
                        Update
                    </button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
