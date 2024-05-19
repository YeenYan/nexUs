<template>
    <div class="workspace__container">
        <header class="workspace-header__container">
            <div class="logo__wrapper">
                <img src="@public/Logo-white.svg" alt="NexUs Logo" />
            </div>
            <div class="profile-avatar__wrapper">
                <img src="@public/avatar_images/fox_avatar.svg" alt="" />
            </div>
        </header>

        <main class="workspace-main__wrapper">
            <nav class="workspace-nav__wrapper">
                <!-- WORKSPACE NAME -->
                <div class="workspace-name__container">
                    <div class="workspace-name__wrapper">
                        <img
                            class="workspace-avatar"
                            src="@public/avatar_images/fox_avatar.svg"
                            alt=""
                        />
                        <p>Workspace Name</p>
                    </div>
                    <caretDownIcon class="caretDown-icon" />
                </div>
                <!------------------>
                <!-- WORKSPACE GROUP -->
                <div class="workspace-nav__group">
                    <ul>
                        <Link :href="route('workspace.dashboard.index')">
                            <li :class="{ active: active.dashboard_active }">
                                <chartColumnIcon class="icon" />
                                <p>Dashboard</p>
                            </li>
                        </Link>
                        <Link :href="route('workspace.notifications.index')">
                            <li
                                :class="{ active: active.notifications_active }"
                            >
                                <notificationIcon class="icon" />
                                <p>Notification</p>
                            </li>
                        </Link>
                        <Link :href="route('workspace.members.index')">
                            <li :class="{ active: active.members_active }">
                                <userIcon class="icon" />
                                <p>Members</p>
                            </li>
                        </Link>
                    </ul>
                </div>
                <!------------------>
                <!-- COLLECTIONS -->
                <div class="collection__container">
                    <div class="collection-header__wrapper">
                        <p>Collections</p>
                        <plusIcon class="icon plus-icon" />
                    </div>
                    <Collections
                        :collections="collections_data.collections"
                        class="collection-content__wrapper"
                    />
                </div>
                <!------------------>
            </nav>
            <section class="workspace-section__wrapper">
                <slot></slot>
                <p>{{ user.username }}</p>
                <Link :href="route('logout')" method="delete" as="button"
                    >Logout</Link
                >
            </section>
        </main>
    </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
/***************************
 ********** ICONS *********/
import caretDownIcon from "@public/svg/icons/caret-down.vue";
import chartColumnIcon from "@public/svg/icons/chart-column.vue";
import notificationIcon from "@public/svg/icons/notification.vue";
import userIcon from "@public/svg/icons/user.vue";
import plusIcon from "@public/svg/icons/plus.vue";
/**************************/
import Collections from "@resource/js/Components/Collections.vue";

import collections_data from "@resource/js/collections.json";

const active = defineProps({
    dashboard_active: Boolean,
    members_active: Boolean,
    notifications_active: Boolean,
});

const page = usePage();

const flashSuccess = computed(() => page.props.flash.success);

const user = computed(() => page.props.user);
</script>

<style lang="postcss" scoped>
.workspace__container {
    @apply w-full h-screen;
}

/****************************
*********** HEADER **********
****************************/

.workspace-header__container {
    @apply flex items-center justify-between bg-neutral-700 px-[1.5rem] py-[.4rem] w-full;
}

.logo__wrapper {
    @apply max-w-[5rem];
}

.profile-avatar__wrapper {
    @apply max-w-[2rem];
}

/***************************************************
*********************** MAIN ***********************
***************************************************/
.workspace-main__wrapper {
    @apply flex h-full overflow-hidden;
}

/***************************************************
******************** NAVIGATION ********************
***************************************************/
.workspace-nav__wrapper {
    @apply w-full max-w-[19rem] h-full border-r-[.3px] border-neutral-400;
}

/* WORKSPACE NAME */
.workspace-name__container {
    @apply flex items-center justify-between px-[1.5rem] py-[.5rem] border-b-[.3px] border-neutral-400 hover:bg-blue-100;
    transition: 0.2s ease-in-out;
}

.workspace-name__wrapper {
    @apply flex items-center gap-2;
}

.workspace-name__wrapper > p {
    @apply text-neutral-700;
}

.workspace-avatar {
    @apply max-w-[2rem];
}

/* WORKSPACE NAV GROUP */
.workspace-nav__wrapper {
    @apply h-full;
}

.workspace-nav__group {
    @apply py-[.5rem] border-b-[.3px] border-neutral-400;
}

.workspace-nav__group ul {
    @apply px-[.8rem];
}

.workspace-nav__group ul li {
    @apply flex gap-5 px-[1rem] py-[.7rem] hover:bg-blue-100 rounded cursor-pointer;
    transition: 0.2s ease-in-out;
}

.workspace-nav__group ul li > p {
    @apply text-sm text-neutral-700;
}

.active {
    @apply bg-blue-100;
}

.active > .icon {
    @apply fill-blue-600;
}

.active > p {
    @apply text-blue-600 font-medium !important;
}

/* COLLECTIONS */
.collection__container {
    @apply h-full pb-[18rem];
}

.collection-header__wrapper {
    @apply flex items-center justify-between px-[1.5rem] py-[.7rem] cursor-pointer;
}

.collection-header__wrapper > p {
    @apply text-sm font-medium text-neutral-700;
}

.collection-content__wrapper {
    @apply max-h-full overflow-y-auto;
}

/* SCROLL BAR */
.collection-content__wrapper::-webkit-scrollbar {
    @apply w-[.4rem];
}

.collection-content__wrapper::-webkit-scrollbar-track {
    @apply bg-blue-100 rounded-full;
}

.collection-content__wrapper::-webkit-scrollbar-thumb {
    @apply bg-blue-300 rounded-full;
}

/***************************************************
********************* SECTION **********************
***************************************************/
.workspace-section__wrapper {
    @apply w-full;
}
</style>
