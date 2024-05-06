<template>
    <HomeMainLayout>
        <template #nav>
            <div class="nav__wrapper">
                <p class="nav-text">Already have an account?</p>
                <Link :href="route('login')" class="btn btn-ghost">Log in</Link>
            </div>
        </template>
        <div class="right-bar"></div>

        <form>
            <section class="signup__wrapper">
                <div class="input__container">
                    <div class="signup__header">
                        <p>Sign up</p>
                        <p>and begin using NexUs!</p>
                    </div>

                    <div class="input__wrapper">
                        <label class="input-label">Username</label>
                        <input
                            class="input"
                            type="text"
                            placeholder="Enter your username"
                        />
                    </div>

                    <div class="input__wrapper">
                        <label class="input-label">Email</label>
                        <input
                            class="input"
                            type="email"
                            placeholder="Enter your email"
                        />
                    </div>

                    <div class="input__wrapper">
                        <label class="input-label">Create Password</label>
                        <input
                            class="input"
                            type="password"
                            placeholder="Enter your password"
                        />
                    </div>

                    <div class="input__wrapper">
                        <label class="input-label">Confirm Password</label>
                        <input
                            class="input"
                            type="password"
                            placeholder="Confirm password"
                        />
                    </div>

                    <div class="btn__wrapper">
                        <button class="btn btn-blue">Create Account</button>
                    </div>
                </div>

                <!-- IMAGE SELECTION -->
                <div>
                    <p>Choose Avatar</p>
                    <!-- <img src="@public/avatar_images/avatar_1.svg" alt="" /> -->
                    <!-- <input type="file" /> -->
                </div>
            </section>
        </form>
    </HomeMainLayout>
</template>

<script setup>
import HomeMainLayout from "@resource/js/Layouts/HomeMainLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
</script>

<style lang="postcss" scoped>
.signup__wrapper {
    @apply grid gap-20 px-[8rem] py-[4rem];
    grid-template-columns: 1fr 1.2fr;
}

.signup__header {
    @apply mb-[1rem];
}

.signup__header p:first-child {
    @apply text-lg font-semibold text-neutral-700;
}

.signup__header p:last-child {
    @apply text-sm text-neutral-700;
}

.input__container {
    @apply grid gap-5;
}

.btn__wrapper {
    @apply mt-[1rem];
}

.btn {
    @apply px-[1rem] max-w-fit;
}
</style>
