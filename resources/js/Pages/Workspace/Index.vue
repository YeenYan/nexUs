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
                        <li>
                            <chartColumnIcon class="icon" />
                            <p>Dashboard</p>
                        </li>
                        <li>
                            <notificationIcon class="icon" />
                            <p>Notification</p>
                        </li>
                        <li>
                            <userIcon class="icon" />
                            <p>Members</p>
                        </li>
                    </ul>
                </div>
                <!------------------>
                <!-- COLLECTIONS -->
                <div class="collection__container">
                    <div class="collection-header__wrapper">
                        <p>Collections</p>
                        <plusIcon class="icon" />
                    </div>
                    <ul class="collection-lists__wrapper">
                        <li class="collection-list">
                            <div class="collection">
                                <caretDownIcon class="caretDown-icon" />
                                <p>Collection Name Here</p>
                            </div>
                            <ul class="section-lists__wrapper">
                                <li class="section-list">
                                    <div class="section-listname">
                                        <circleIcon class="icon" />
                                        <p>Section Name Here</p>
                                    </div>
                                    <div class="section-line">
                                        <div></div>
                                        <div></div>
                                    </div>
                                </li>
                                <!-- <li class="section-list">
                                    <div class="section-listname">
                                        <circleIcon class="icon" />
                                        <p>Section Name Here</p>
                                    </div>
                                    <div class="section-line">
                                        <div></div>
                                        <div></div>
                                    </div>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </div>
                <!------------------>
            </nav>
            <section class="workspace-section__wrapper"></section>
        </main>
    </div>
</template>

<script setup>
import caretDownIcon from "@public/svg/icons/caret-down.vue";
import chartColumnIcon from "@public/svg/icons/chart-column.vue";
import notificationIcon from "@public/svg/icons/notification.vue";
import userIcon from "@public/svg/icons/user.vue";
import plusIcon from "@public/svg/icons/plus.vue";
import circleIcon from "@public/svg/icons/circle.vue";
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
    @apply flex h-full;
}

/***************************************************
******************** NAVIGATION ********************
***************************************************/
.workspace-nav__wrapper {
    @apply w-full max-w-[19rem] border-r-[.3px] border-neutral-400;
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
.workspace-nav__group {
    @apply py-[.5rem] border-b-[.3px] border-neutral-400;
}

.workspace-nav__group ul,
.collection-lists__wrapper {
    @apply px-[.8rem];
}

.workspace-nav__group ul li {
    @apply flex gap-5 px-[1rem] py-[.7rem] hover:bg-blue-100 rounded;
    transition: 0.2s ease-in-out;
}

.workspace-nav__group ul li > p {
    @apply text-sm text-neutral-700;
}

/* COLLECTIONS */
.collection-header__wrapper {
    @apply flex items-center justify-between px-[1.5rem] py-[.7rem];
}

.collection-header__wrapper > p {
    @apply text-sm font-medium text-neutral-700;
}

.collection-list {
    @apply grid w-full;
}

.collection {
    @apply flex gap-5 w-full pl-[1rem] py-[.7rem] hover:bg-blue-100 rounded cursor-pointer;
    transition: 0.2s ease-in-out;
}

.collection > p {
    @apply text-sm text-neutral-700;
}

.collection .caretDown-icon {
    @apply -rotate-90;
}

/* SECTIONS */
.section-list {
    @apply relative ml-[1rem];
}

.section-list:hover > .section-listname {
    @apply bg-blue-100;
    transition: 0.2s ease-in-out;
}

.section-listname {
    @apply flex gap-3 ml-[1.5rem] px-[1rem] py-[.7rem] rounded;
}

.section-listname > p {
    @apply text-sm text-neutral-700;
}

.section-line {
    @apply absolute top-0 left-[.4rem] w-full h-full;
}

.section-line > div:first-child {
    @apply absolute top-[50%] w-[1rem] h-[.3px] bg-neutral-500;
}

.section-line > div:last-child {
    @apply absolute w-[.3px] h-[50%] bg-neutral-500;
}

/* LINE FOR THE NEXT SECTION */
.section-list:not(:first-child) > .section-line > div:last-child {
    @apply top-[-50%] h-[150%];
}

/***************************************************
********************* SECTION **********************
***************************************************/
.workspace-section__wrapper {
    @apply w-full;
}
</style>
