<template>
    <HomeMainLayout>
        <template #nav>
            <div class="nav__wrapper">
                <p class="nav-text">Don't have an account?</p>
                <Link :href="route('user-account.create')" class="btn btn-blue"
                    >Sign up</Link
                >
            </div>
        </template>
        <div class="right-bar"></div>

        <form>
            <section class="login__wrapper">
                <div class="input__container">
                    <div class="login__header">
                        <p>Welcome back!</p>
                        <p>Keep using NexUs</p>
                    </div>

                    <div class="input__wrapper">
                        <label class="input-label">Email</label>
                        <input
                            class="input"
                            type="text"
                            placeholder="Enter your email"
                        />
                    </div>

                    <div class="input__wrapper">
                        <label class="input-label">Password</label>
                        <input
                            class="input"
                            type="text"
                            placeholder="Enter your password"
                        />
                    </div>

                    <div class="btn__wrapper">
                        <button class="btn btn-blue">Log In</button>
                    </div>
                </div>
            </section>
        </form>
    </HomeMainLayout>
</template>

<script setup>
import HomeMainLayout from "@resource/js/Layouts/HomeMainLayout.vue";
import { Link } from "@inertiajs/vue3";
</script>

<style lang="postcss" scoped>
.login__wrapper {
    @apply grid gap-20 px-[8rem] py-[8rem];
    grid-template-columns: 1fr 1.2fr;
}

.login__header {
    @apply mb-[1rem];
}

.login__header p:first-child {
    @apply text-lg font-semibold text-neutral-700;
}

.login__header p:last-child {
    @apply text-sm text-neutral-700;
}

.input__container {
    @apply grid gap-5;
}

.btn__wrapper {
    @apply mt-[1rem];
}
</style>
