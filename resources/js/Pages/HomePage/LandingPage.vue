<template>
    <HomeMainLayout>
        <template #nav>
            <Link
                :href="route('signup')"
                class="btn btn-blue"
                @click="testClick"
                >Sign up</Link
            >
            <Link :href="route('login')" class="btn btn-ghost">Log in</Link>
        </template>
        <p>Landing Page</p>
    </HomeMainLayout>
</template>

<script setup>
import HomeMainLayout from "@resource/js/Layouts/HomeMainLayout.vue";
import { Link } from "@inertiajs/vue3";
</script>
