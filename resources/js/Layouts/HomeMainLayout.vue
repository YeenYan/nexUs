<template>
    <div class="home-page__container">
        <header class="nav__container">
            <Link :href="route('home')" class="logo__wrapper"
                ><img src="@public/Logo.svg" alt="NexUs Logo"
            /></Link>

            <nav class="action__container">
                <!-- NAVIGATION HERE -->
                <slot name="nav"></slot>
            </nav>
        </header>

        <!-- Other Vue Template Here -->
        <slot></slot>

        <div class="footer__container">
            <p>© {{ currentYear }} NexUs | Mark Ian Reyes</p>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const currentYear = computed(() => new Date().getFullYear());

const testClick = () => {
    console.log(test);
};
</script>

<style lang="postcss" scoped>
/* =====> GUIDE OUTLINE <=====*/
.guide {
    @apply outline-[1px] outline-red-500 outline;
}
/* ========================== */

.home-page__container {
    @apply relative w-full h-screen max-w-[71rem] mx-auto;
}

.link {
    @apply bg-red-500;
}
/* ****************************** */
/* NAVIGATION */
.nav__container {
    @apply flex py-[1rem];
}

.logo__wrapper {
    @apply w-full;
}

.logo__wrapper img {
    @apply max-w-[8.25rem];
}

/* SIGNUP & LOGIN */
:deep(.nav__wrapper) {
    @apply flex w-full justify-end items-center gap-3 pr-[11rem];
}

:deep(.right-bar) {
    @apply absolute top-0 right-[-86%] bg-blue-500 w-full h-screen;
}

:deep(.nav-text) {
    @apply text-xs text-neutral-700;
}

.action__container {
    @apply flex justify-end items-center w-full gap-2;
}
/* ****************************** */

/* ****************************** */
/* FOOTER */
.footer__container {
    @apply absolute bottom-0 w-full text-xs text-neutral-600 grid justify-center items-end py-[1rem];
}
/* ****************************** */
</style>
