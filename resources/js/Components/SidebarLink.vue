<script setup>
import { Link } from "@inertiajs/vue3";
import {
    HomeIcon,
    MagnifyingGlassIcon,
    GlobeAltIcon,
    FilmIcon,
    ChatBubbleLeftRightIcon,
    HeartIcon,
    PlusCircleIcon,
    UserIcon,
    ChartBarIcon,
    Cog6ToothIcon,
} from "@heroicons/vue/24/outline";
const props = defineProps({
    icon: String,
    label: String,
    href: String,
    active: Boolean,
});
const icons = {
    home: HomeIcon,
    search: MagnifyingGlassIcon,
    compass: GlobeAltIcon,
    film: FilmIcon,
    chat: ChatBubbleLeftRightIcon,
    heart: HeartIcon,
    "plus-circle": PlusCircleIcon,
    user: UserIcon,
    "chart-bar": ChartBarIcon,
    cog: Cog6ToothIcon,
};
</script>
<template>
    <component
        :is="href ? Link : 'button'"
        :href="href"
        class="flex items-center gap-4 px-4 py-2 rounded-lg hover:bg-white/10 transition font-medium text-lg"
        :class="active ? 'bg-white/10 text-white' : 'text-gray-400'"
    >
        <component :is="icons[icon]" class="w-6 h-6" />
        <span>{{ label }}</span>
    </component>
</template>
