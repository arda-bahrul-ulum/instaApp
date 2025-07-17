<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
const URL = window.URL || window.webkitURL;

const form = useForm({
    caption: "",
    image: null,
});
const page = usePage();
const flash = page.props.flash || {};

function submit() {
    form.post(route("posts.store"), {
        forceFormData: true,
    });
}
</script>
<template>
    <Head title="Create Post" />
    <AuthenticatedLayout>
        <template #header>
            <div class="text-xl font-bold text-white text-center mt-8">
                Create Post
            </div>
        </template>
        <div class="flex justify-center items-start min-h-[60vh] mt-8">
            <div
                class="w-full max-w-5xl bg-[#181818] border border-[#232323] p-16 rounded-2xl shadow-lg"
            >
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-white font-semibold mb-1"
                            >Image</label
                        >
                        <input
                            name="image"
                            @change="(e) => (form.image = e.target.files[0])"
                            type="file"
                            accept="image/*"
                            class="border border-[#232323] bg-[#232323] text-white rounded-lg px-3 py-2 w-full file:bg-[#232323] file:text-white file:border-0 file:rounded file:px-3 file:py-2"
                        />
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
                        <label class="block text-white font-semibold mb-1"
                            >Caption</label
                        >
                        <textarea
                            v-model="form.caption"
                            rows="4"
                            class="border border-[#232323] bg-[#232323] text-white placeholder-gray-400 rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-400 font-medium resize-none"
                            placeholder="What's on your mind?"
                        ></textarea>
                        <div
                            v-if="form.errors.caption"
                            class="text-red-400 text-sm mt-1 font-semibold"
                        >
                            {{ form.errors.caption }}
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-400 text-white px-6 py-2 rounded-lg shadow hover:opacity-90 transition w-full font-bold"
                        :disabled="form.processing"
                    >
                        Create
                    </button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
