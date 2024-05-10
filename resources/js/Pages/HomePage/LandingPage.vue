<template>
    <HomeMainLayout>
        <template #nav>
            <Link :href="route('user-account.create')" class="btn btn-blue"
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
