<template>
    <div class="workspace__container">
        <header class="workspace-header__container">
            <div class="logo__wrapper">
                <img src="@public/Logo-white.svg" alt="NexUs Logo" />
            </div>
            <div class="profile-avatar__wrapper">
                <img :src="avatar" alt="" />
            </div>
        </header>

        <main class="workspace-main__wrapper">
            <div class="workspace-dd__container" v-if="workspace_dd_active">
                <div
                    class="workspace-dd__settings workspace-dd__flex hover-bg__blue"
                >
                    <settingsIcon class="icon" />
                    <p>Settings</p>
                </div>
                <div class="workspace-dd__titles">
                    <p>Switch Workspace</p>
                    <ul class="workspace-dd__lists">
                        <li
                            v-for="workspaces in not_active_workspaces"
                            :key="workspaces.workspace_id"
                        >
                            <form
                                :action="switch_workspace"
                                method="POST"
                                class="workspace-dd__list workspace-dd__flex hover-bg__blue"
                            >
                                <input
                                    type="hidden"
                                    name="workspace_id"
                                    :value="workspaces.workspace_id"
                                />
                                <input
                                    type="hidden"
                                    name="_token"
                                    :value="csrfToken"
                                />
                                <div class="workspace-avatar_wrapper">
                                    <img
                                        :src="
                                            workspace_avatar_base_path +
                                            workspaces.avatar
                                        "
                                        alt=""
                                        class="workspace-avatar"
                                    />
                                </div>
                                <button type="submit" class="workspaces_btn">
                                    {{ workspaces.workspace_name }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <Link
                    :href="route('workspace.create')"
                    class="workspace-dd_add workspace-dd__flex hover-bg__blue"
                >
                    <plusIcon class="icon" />
                    <p>New Workspace</p>
                </Link>
            </div>

            <nav class="workspace-nav__wrapper">
                <!-- WORKSPACE NAME -->
                <div
                    class="workspace-name__container hover-bg__blue"
                    @click.prevent="toggle_workspace_dd"
                >
                    <div class="workspace-name__wrapper">
                        <div class="workspace-avatar_wrapper">
                            <img
                                class="workspace-avatar"
                                :src="
                                    workspace_avatar_base_path +
                                    props.workspace.avatar
                                "
                                alt=""
                            />
                        </div>
                        <p>{{ props.workspace.workspace_name }}</p>
                    </div>
                    <caretDownIcon
                        class="caretDown-icon"
                        :class="{ active: workspace_dd_active }"
                    />
                </div>
                <!------------------>
                <!-- WORKSPACE GROUP -->
                <div class="workspace-nav__group">
                    <ul>
                        <Link
                            :href="
                                route('workspace.dashboard.index', {
                                    workspace: props.workspace.workspace_id,
                                })
                            "
                        >
                            <li :class="{ active: props.dashboard_active }">
                                <chartColumnIcon class="icon" />
                                <p>Dashboard</p>
                            </li>
                        </Link>
                        <Link
                            :href="
                                route('workspace.notifications.index', {
                                    workspace: props.workspace.workspace_id,
                                })
                            "
                        >
                            <li :class="{ active: props.notifications_active }">
                                <notificationIcon class="icon" />
                                <p>Notification</p>
                            </li>
                        </Link>
                        <Link
                            :href="
                                route('workspace.members.index', {
                                    workspace: props.workspace.workspace_id,
                                })
                            "
                        >
                            <li :class="{ active: props.members_active }">
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
                        <plusIcon
                            class="icon plus-icon"
                            @click.prevent="toggle_collection_modal"
                        />
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
                <p>THis is from show</p>
                <Link :href="route('logout')" method="delete" as="button"
                    >Logout</Link
                >
            </section>
        </main>

        <CreateCollection class="collection-modal__wrapper" v-if="show_modal" />
    </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref, onMounted } from "vue";
import { useStore } from "vuex";
import axios from "axios";
/***************************
 ********** ICONS *********/
import caretDownIcon from "@public/svg/icons/caret-down.vue";
import chartColumnIcon from "@public/svg/icons/chart-column.vue";
import notificationIcon from "@public/svg/icons/notification.vue";
import userIcon from "@public/svg/icons/user.vue";
import plusIcon from "@public/svg/icons/plus.vue";
import settingsIcon from "@public/svg/icons/settings.vue";
/***************************
 ****** COLLECTIONS ********/
import CreateCollection from "@resource/js/Components/Modals/CST_Modals/CreateCollection.vue";
import Collections from "@resource/js/Components/Collections.vue";
import collections_data from "@resource/js/collections.json";

const props = defineProps({
    dashboard_active: Boolean,
    members_active: Boolean,
    notifications_active: Boolean,
    all_workspaces: Array,
    workspace: Object,
    avatar: String,
});

const page = usePage();

// console.log(props.workspace.workspace_id);

/**************************************
 * Using Global Environment Variable
 * for the path of Workspace avatars
 *************************************/
const workspace_avatar_base_path = import.meta.env
    .VITE_WORKSPACE_AVATAR_BASE_URL;

/**************************************
 * Filtering & fetching all workspaces
 * which is not active
 *************************************/
const not_active_workspaces = props.all_workspaces.filter(
    (e) => e.active !== 1
);

const user = computed(() => page.props.user);

/*****************************************
 ****** TOGGLING WORKSPACE DROPDOWN ******
 ****************************************/
let workspace_dd_active = ref(false);
let toggle_workspace_dd = () => {
    workspace_dd_active.value = !workspace_dd_active.value;
};

/*****************************************
 ********** SWITCHING WORKSPACE **********
 ****************************************/
// CSRF token is included in the form for security
const csrfToken = ref(
    document.querySelector('meta[name="csrf-token"]').getAttribute("content")
);

const switch_workspace = "/workspace/switch";

/*****************************************
 ******* TOGGLING COLLECTION MODAL *******
 ****************************************/
const store = useStore();
const show_modal = computed(() => store.state.is_close);

const toggle_collection_modal = () => {
    store.commit("setIsClose", true);
};
</script>

<style lang="postcss" scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

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
    @apply h-[2rem] max-w-[2rem];
}

.workspace-avatar_wrapper {
    @apply h-[1.5rem] max-w-[1.5rem];
}

.profile-avatar__wrapper,
.workspace-avatar_wrapper {
    @apply rounded-full overflow-hidden;
}

.profile-avatar__wrapper > img,
.workspace-avatar_wrapper > img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/***************************************************
*********************** MAIN ***********************
***************************************************/
.workspace-main__wrapper {
    @apply relative flex h-full overflow-hidden;
}

/***************************************************
************** WORKSPACE DROPDOWN ******************
***************************************************/
.workspace-dd__container {
    @apply absolute top-[3rem] left-[1rem] w-full max-w-[19rem] bg-shades-white px-[.7rem] py-[.5rem] rounded-lg z-[1] drop-shadow-md;
}

.workspace-dd__container p {
    @apply text-sm text-neutral-600;
}

.workspace-dd__flex {
    @apply flex gap-4 items-center px-[.7rem] py-[1rem];
}

.workspace-dd__settings {
    @apply rounded;
}

.workspace-dd__titles {
    @apply pt-[1.25rem] pb-[5rem] border-t-[.3px] border-b-[.3px] border-neutral-300 my-[.5rem];
}

.workspace-dd__titles > p:first-child {
    @apply text-xs text-neutral-500;
}

.workspace-dd__lists {
    @apply mt-[.5rem];
}

.workspace-dd__list {
    @apply flex gap-3 items-center py-[.8rem] rounded;
}

.workspaces_btn {
    @apply text-neutral-600 text-sm;
}

.workspace-dd_add {
    @apply rounded;
}

/***************************************************
******************** NAVIGATION ********************
***************************************************/
.workspace-nav__wrapper {
    @apply w-full max-w-[19rem] h-full border-r-[.3px] border-neutral-400;
}

/* WORKSPACE NAME */
.workspace-name__container {
    @apply flex items-center justify-between px-[1.5rem] py-[.5rem] border-b-[.3px] border-neutral-400;
}

.workspace-name__container > .caretDown-icon {
    transition: 0.3s ease-in-out;
}

.caretDown-icon.active[data-v-f64b02b9] {
    @apply bg-transparent;
}

.workspace-name__container > .caretDown-icon.active {
    @apply rotate-180;
}

.workspace-name__wrapper {
    @apply flex items-center gap-3 py-[.25rem];
}

.workspace-name__wrapper > p {
    @apply text-base text-neutral-700;
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

/***************************************************
*************** COLLECTION MODAL *******************
***************************************************/
.collection-modal__wrapper {
    @apply z-[1];
}
</style>
