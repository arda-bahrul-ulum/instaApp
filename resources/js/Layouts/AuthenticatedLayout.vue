<script setup>
import SidebarLink from "../Components/SidebarLink.vue";
import UserDropdown from "../Components/UserDropdown.vue";
</script>
<template>
    <div class="flex min-h-screen bg-black text-white">
        <!-- Sidebar -->
        <aside
            class="w-64 hidden md:flex flex-col border-r border-gray-800 bg-black px-4 py-6 fixed h-full z-20"
        >
            <div class="mb-8 flex items-center justify-center">
                <span class="font-logo text-3xl">InstaApp</span>
            </div>
            <nav class="flex-1 space-y-2">
                <SidebarLink
                    icon="home"
                    label="Home"
                    :active="route().current('dashboard')"
                    :href="route('dashboard')"
                />
                <SidebarLink
                    icon="search"
                    label="Search"
                    :href="route('search')"
                    :active="route().current('search')"
                />
                <SidebarLink
                    icon="plus-circle"
                    label="Post"
                    :href="route('posts.index')"
                />
                <SidebarLink
                    icon="user"
                    label="Profile"
                    :href="route('profile.edit')"
                />
            </nav>
            <div class="mt-auto relative">
                <UserDropdown />
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 md:ml-64 flex flex-col items-center min-h-screen">
            <slot name="header" />
            <div class="w-full max-w-2xl flex flex-col flex-1">
                <slot />
            </div>
        </main>
    </div>
</template>
<style scoped>
.font-logo {
    font-family: "Billabong", cursive, sans-serif;
}
</style>
