<template>
    <div class="workspace__container">
        <header class="workspace-header__container">
            <div class="logo__wrapper">
                <img src="@public/Logo-white.svg" alt="NexUs Logo" />
            </div>
            <div
                class="profile-avatar__wrapper"
                @click.prevent="toggle_user_avatar_dd"
            >
                <img :src="avatar" alt="" />
            </div>

            <!------------------------------>
            <!------- AVATAR DROPDOWN ------>
            <!------------------------------>
            <div
                class="profile-avatar-dd__wrapper"
                v-if="user_avatar_dd_active"
            >
                <div
                    class="profile-avatar-dd__profile hover-bg__blue"
                    @click.prevent="toggle_user_profile_nav"
                >
                    <userIcon class="icon" />
                    <p>View Profile</p>
                </div>
                <Link
                    :href="route('logout')"
                    method="delete"
                    as="button"
                    class="profile-avatar-dd__logout hover-bg__blue"
                >
                    <logoutIcon class="icon" />
                    <p>Log out</p>
                </Link>
            </div>
        </header>

        <main class="workspace-main__wrapper">
            <!------------------------------>
            <!----- WORKSPACE DROPDOWN ----->
            <!------------------------------>
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
                                    workspace_avatar
                                "
                                alt=""
                            />
                        </div>
                        <p>{{ workspace_name }}</p>
                    </div>
                    <caretDownIcon
                        class="caretDown-icon"
                        :class="{ active: workspace_dd_active }"
                    />
                </div>
                <!------------------------------>
                <!------- WORKSPACE GROUP ------>
                <!------------------------------>
                <div class="workspace-nav__group">
                    <ul>
                        <Link
                            :href="
                                route('workspace.dashboard.index', {
                                    workspace: workspace_id,
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
                                    workspace: workspace_id,
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
                                    workspace: workspace_id,
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

                <!------------------------------>
                <!--------- COLLECTIONS -------->
                <!------------------------------>
                <div class="collection__container">
                    <div class="collection-header__wrapper">
                        <p>Collections</p>
                        <plusIcon
                            class="icon plus-icon"
                            @click.prevent="toggle_collection_modal"
                        />
                    </div>
                    <Collections
                        :collections="props.all_collections"
                        :all_workspaces="props.all_workspaces"
                        :collection_id="props.collection_id"
                        class="collection-content__wrapper"
                    />
                </div>
                <!------------------>
            </nav>
            <section class="workspace-section__wrapper">
                <slot></slot>
                <!-- <p>THis is from show</p>
                <p>{{ active_workspaces[0].created_by }}</p> -->
            </section>
        </main>

        <!------------------------------>
        <!-- CREATE COLLECTION MODAL --->
        <!------------------------------>
        <CSTContainer
            class="collection-modal__wrapper"
            v-if="CST_container_is_active"
            :workspace_id="workspace_id"
        />
        <!-- :collections="props.all_collections" -->

        <!------------------------------>
        <!---- USER PROFILE SIDE NAV --->
        <!------------------------------>
        <div
            class="user-profile__container"
            :class="{ active: user_profile_nav_active }"
        >
            <div
                class="user-profile-close__wrapper"
                @click.prevent="toggle_user_profile_nav"
            >
                <caretDownIcon class="icon" />
            </div>
            <div class="user-profile__wrapper">
                <div class="user-profile-header__wrapper">
                    <div class="user-profile-avatar">
                        <img :src="avatar" alt="profile image" />
                    </div>

                    <div class="user-profile-information">
                        <p class="username">{{ user.username }}</p>
                        <div class="user-profile-details__wrapper">
                            <div class="user-profile-email user-profile-gap">
                                <p class="user-profile-label">Email</p>
                                <p class="user-profile-data">
                                    {{ user.email }}
                                </p>
                            </div>
                            <div class="user-profile-role user-profile-gap">
                                <p class="user-profile-label">Role</p>
                                <p class="user-profile-data role-data">Owner</p>
                            </div>
                            <div class="user-profile-joined user-profile-gap">
                                <p class="user-profile-label">Joined On</p>
                                <p class="user-profile-data">01/01/2000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="user-profile-activity__wrapper">
                    <p>Activities Content here</p>
                </div>
            </div>
        </div>
        <div
            class="user-profile__blanket"
            data-aos="show_in"
            v-if="user_profile_nav_active"
        >
            <div></div>
        </div>
    </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref, onMounted, watch } from "vue";
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
import logoutIcon from "@public/svg/icons/logout.vue";
/***************************
 ****** COLLECTIONS ********/
import CreateCollection from "@resource/js/Components/Modals/CST_Modals/CreateCollection.vue";
import CSTContainer from "@resource/js/Components/Modals/CST_Modals/CST_Container.vue";
import Collections from "@resource/js/Components/Collections.vue";

const props = defineProps({
    dashboard_active: Boolean,
    members_active: Boolean,
    notifications_active: Boolean,
    all_workspaces: Array,
    avatar: String,
    all_collections: Object,
    collection_id: String,
});

const page = usePage();

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

/**************************************
 * Fetching single Active workspace
 *************************************/
const active_workspaces = props.all_workspaces.filter((e) => e.active == 1);

let workspace_id;
let workspace_name;
let workspace_avatar;
for (let i in active_workspaces) {
    workspace_id = active_workspaces[i].workspace_id;
    workspace_name = active_workspaces[i].workspace_name;
    workspace_avatar = active_workspaces[i].avatar;
}

/*****************************************
 ************ Fetching User **************
 ****************************************/
const user = computed(() => page.props.user);

/*****************************************
 ****** TOGGLING WORKSPACE DROPDOWN ******
 ****************************************/
let workspace_dd_active = ref(false);
let toggle_workspace_dd = () => {
    user_avatar_dd_active.value = false;
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
 **** TOGGLING AVATAR PROFILE DROPDOWN ****
 ****************************************/
let user_avatar_dd_active = ref(false);
let toggle_user_avatar_dd = () => {
    workspace_dd_active.value = false;
    user_avatar_dd_active.value = !user_avatar_dd_active.value;
};

/*****************************************
 **** TOGGLING USER PROFILE SIDE NAV *****
 ****************************************/
let user_profile_nav_active = ref(false);
let toggle_user_profile_nav = () => {
    user_avatar_dd_active.value = false;
    user_profile_nav_active.value = !user_profile_nav_active.value;
};

/*****************************************
 ******* TOGGLING COLLECTION MODAL *******
 ****************************************/
const store = useStore();
const CST_container_is_active = computed(
    () => store.state.active_CST_container
);

const toggle_collection_modal = () => {
    store.commit("setAddCollectionModalIsClose", true);
};
</script>

<style lang="postcss" scoped>
.workspace__container {
    @apply relative w-full h-screen;
}

/***************************************************
******************* USER PROFILE *******************
***************************************************/
.user-profile__container {
    @apply absolute flex gap-3 top-0 right-0 w-full max-w-[45rem] h-full z-[2];
    transform: translateX(60rem);
    transition: all 0.4s ease-in-out;
}

.user-profile__container.active {
    @apply bg-transparent;
    transform: translateX(0);
}

.user-profile-close__wrapper {
    @apply flex items-center justify-center bg-shades-white mt-[1.5rem] w-[3rem] h-[2.7rem] rounded-full rotate-90 hover:rotate-[-90deg];
    transition: all 0.4s ease-in-out;
}

.user-profile-close__wrapper .icon {
    @apply p-[.1rem] cursor-pointer;
}

.user-profile__wrapper {
    @apply bg-shades-white h-full w-full p-[1.5rem];
}

.user-profile-header__wrapper {
    @apply grid gap-6;
}

.user-profile-avatar {
    @apply h-[5rem] max-w-[5rem];
}

.user-profile-header__wrapper {
    @apply flex;
}

.user-profile-information {
    @apply grid gap-6 w-full;
}

.user-profile-information > .username {
    @apply text-lg font-semibold text-neutral-700;
}

.user-profile-details__wrapper {
    @apply grid gap-5 w-full;
    grid-template-columns: 1fr 0.72fr 0.5fr;
}

.user-profile-gap {
    @apply grid gap-1;
}

.user-profile-label {
    @apply text-xs text-neutral-500;
}

.user-profile-data {
    @apply text-sm text-neutral-700 font-medium;
}

.user-profile-role > .role-data {
    @apply px-[1rem] py-[.2rem] border-[.3px] border-neutral-400 w-fit rounded-full;
}

.user-profile-activity__wrapper {
    @apply mt-[4rem];
}

.user-profile__blanket {
    @apply fixed inset-0 bg-neutral-900 z-[1];
}

/***************************************************
********************** HEADER **********************
***************************************************/

.workspace-header__container {
    @apply relative flex items-center justify-between bg-neutral-700 px-[1.5rem] py-[.4rem] w-full;
}

.logo__wrapper {
    @apply max-w-[5rem];
}

.profile-avatar__wrapper {
    @apply h-[2rem] max-w-[2rem] cursor-pointer;
}

.workspace-avatar_wrapper {
    @apply h-[1.5rem] max-w-[1.5rem];
}

.profile-avatar__wrapper,
.workspace-avatar_wrapper,
.user-profile-avatar {
    @apply rounded-full overflow-hidden;
}

.profile-avatar__wrapper > img,
.workspace-avatar_wrapper > img,
.user-profile-avatar > img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-avatar-dd__wrapper {
    @apply absolute right-[1.5rem] top-[2.5rem] bg-shades-white w-full max-w-[15rem] px-[.7rem] py-[.5rem] rounded-lg drop-shadow-md z-[1];
}

.profile-avatar-dd__wrapper p {
    @apply text-sm text-neutral-600;
}

.profile-avatar-dd__profile,
.profile-avatar-dd__logout {
    @apply flex gap-4 w-full px-[.7rem] py-[1rem] cursor-pointer rounded;
}

.profile-avatar-dd__logout p,
.profile-avatar-dd__logout .icon {
    @apply text-red-500 fill-red-500;
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

.caretDown-icon.active {
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
</style>
