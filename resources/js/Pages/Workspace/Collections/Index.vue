<template>
    <Workspace
        :all_workspaces="props.all_workspaces"
        :avatar="props.avatar"
        :all_collections="props.all_collections"
        :collection_id="props.collection_id"
    >
        <div class="breadcrumbs-header">
            <p>Collections</p>
        </div>

        <!------------------------------>
        <!------ SECTIONS SECTION ------>
        <!------------------------------>
        <section class="collection__container container">
            <!------------------------------>
            <!------- LEFT SIDE PART ------>
            <!------------------------------>
            <div class="section__wrapper col-wrapper">
                <div class="section-header col-header__wrapper">
                    <p class="col-header-text">Sections</p>
                    <plusIcon
                        class="icon"
                        @click.prevent="toggle_section_modal"
                    />
                </div>

                <div
                    class="empty-section"
                    v-if="
                        !all_current_sections ||
                        all_current_sections.length <= 0
                    "
                >
                    <p>~ No Sections Available ~</p>
                </div>
                <ul class="section-lists__container" v-else>
                    <li
                        v-for="(section, index) in all_current_sections"
                        :key="section.section_id"
                        class="section-lists__wrapper"
                    >
                        <!--  -->
                        <div
                            class="input__box input-sectionName__wrapper"
                            v-if="section.section_id == update_sectionID"
                        >
                            <input
                                v-model="new_sectionName"
                                class="input__update"
                                type="text"
                                id="update_name"
                            />
                            <!-- <p class="input-error_icon">!</p> -->
                            <button
                                @click="update_sectionName"
                                class="input-updateName__btn"
                                :class="{ active: active_button }"
                            >
                                Update
                            </button>
                            <p
                                class="input-close_icon"
                                @click.prevent="update_sectionID = false"
                            >
                                x
                            </p>
                        </div>
                        <Link
                            :href="
                                route('workspace.collection.sections.show', {
                                    workspace: props.workspace_id,
                                    collection_id: collection.collection_id,
                                    section_id: section.section_id,
                                })
                            "
                        >
                            <div class="section-list-name">
                                <folderIcon class="icon" />
                                <p>
                                    {{ section.section_name }}
                                </p>
                            </div>
                            <!-- Progress bar -->
                            <div class="section-list-progress">
                                <div class="base">
                                    <div class="bar"></div>
                                </div>
                                <p>65%</p>
                            </div>

                            <ellipsisIcon
                                class="section-list-ellipsis icon"
                                @click.prevent="
                                    toggle_sectionDD_menu(
                                        section.section_id,
                                        index
                                    )
                                "
                            />
                            <DropdownMenu
                                class="section-menu"
                                v-if="section.section_id == active_section"
                            >
                                <template #normal>
                                    <div class="normal">
                                        <addUserIcon class="icon" />
                                        <p>Add Member</p>
                                    </div>
                                    <div
                                        class="normal"
                                        @click.prevent="
                                            show_update_input(
                                                section.section_id,
                                                section.section_name
                                            )
                                        "
                                    >
                                        <editIcon class="icon" />
                                        <p>Rename</p>
                                    </div>
                                    <div
                                        class="delete"
                                        @click.prevent="
                                            toggle_delete_section_modal(
                                                section.section_id,
                                                section.section_name,
                                                index
                                            )
                                        "
                                    >
                                        <deleteIcon class="icon" />
                                        <p>Delete</p>
                                    </div>
                                </template>
                            </DropdownMenu>
                        </Link>
                    </li>
                </ul>
            </div>

            <!------------------------------>
            <!------- RIGHT SIDE PART ------>
            <!------------------------------>
            <div class="collection-info__wrapper">
                <!--------------------------------->
                <!-- COLLECTION PROGRESS SECTION -->
                <!--------------------------------->
                <div class="collection-info-progress__wrapper col-wrapper">
                    <div class="collection-info-title__wrapper">
                        <p>{{ collection.collection_name }}</p>
                        <ellipsisIcon
                            class="icon"
                            @click.prevent="toggle_colDD_menu"
                        />

                        <div
                            class="input__box input-collectionName__wrapper"
                            v-if="toggle_col_input"
                        >
                            <input
                                v-model="new_col_name"
                                class="input__update"
                                type="text"
                                id="update_col_name"
                            />
                            <!-- <p class="input-error_icon">!</p> -->
                            <button
                                @click="update_colName"
                                class="input-updateName__btn"
                                :class="{ active: active_col_button }"
                            >
                                Update
                            </button>
                            <p
                                class="input-close_icon"
                                @click.prevent="toggle_col_input = false"
                            >
                                x
                            </p>
                        </div>

                        <DropdownMenu class="col-menu" v-if="active_col">
                            <template #normal>
                                <div
                                    class="normal"
                                    @click.prevent="
                                        show_collection_input(
                                            collection.collection_name
                                        )
                                    "
                                >
                                    <editIcon class="icon" />
                                    <p>Rename</p>
                                </div>
                                <div
                                    class="delete"
                                    @click.prevent="
                                        toggle_delete_collection_modal(
                                            collection.collection_id,
                                            collection.collection_name
                                        )
                                    "
                                >
                                    <deleteIcon class="icon" />
                                    <p>Delete</p>
                                </div>
                            </template>
                        </DropdownMenu>
                    </div>
                    <div class="collection-progress-info__wrapper">
                        <CircleProgress
                            :rValue="50"
                            :percentValue="90"
                            :strokeWidth="1"
                        />
                        <p>
                            Date Created:
                            <span>{{ collection_created_at }}</span>
                        </p>
                    </div>
                </div>

                <!------------------------------>
                <!------ MEMBERS SECTION ------->
                <!------------------------------>
                <div class="collection-info-members__wrapper col-wrapper">
                    <p class="col-header-text">Members</p>
                    <ul class="member-lists__container">
                        <li class="member-list__wrapper">
                            <div class="member-avatar__wrapper">
                                <img :src="avatar" alt="" />
                            </div>
                            <div class="member-details__wrapper">
                                <p class="name">FirstName Lastname</p>
                                <p class="email">useremail@email.com</p>
                            </div>
                            <p class="member-role">Owner</p>
                        </li>
                        <li class="member-list__wrapper">
                            <div class="member-avatar__wrapper">
                                <img :src="avatar" alt="" />
                            </div>
                            <div class="member-details__wrapper">
                                <p class="name">FirstName Lastname</p>
                                <p class="email">useremail@email.com</p>
                            </div>
                            <p class="member-role">Owner</p>
                        </li>
                        <li class="member-list__wrapper">
                            <div class="member-avatar__wrapper">
                                <img :src="avatar" alt="" />
                            </div>
                            <div class="member-details__wrapper">
                                <p class="name">FirstName Lastname</p>
                                <p class="email">useremail@email.com</p>
                            </div>
                            <p class="member-role">Owner</p>
                        </li>
                        <li class="member-list__wrapper">
                            <div class="member-avatar__wrapper">
                                <img :src="avatar" alt="" />
                            </div>
                            <div class="member-details__wrapper">
                                <p class="name">FirstName Lastname</p>
                                <p class="email">useremail@email.com</p>
                            </div>
                            <p class="member-role">Owner</p>
                        </li>
                        <li class="member-list__wrapper">
                            <div class="member-avatar__wrapper">
                                <img :src="avatar" alt="" />
                            </div>
                            <div class="member-details__wrapper">
                                <p class="name">FirstName Lastname</p>
                                <p class="email">useremail@email.com</p>
                            </div>
                            <p class="member-role">Owner</p>
                        </li>
                        <li class="member-list__wrapper">
                            <div class="member-avatar__wrapper">
                                <img :src="avatar" alt="" />
                            </div>
                            <div class="member-details__wrapper">
                                <p class="name">FirstName Lastname</p>
                                <p class="email">useremail@email.com</p>
                            </div>
                            <p class="member-role">Owner</p>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </Workspace>
</template>

<script setup>
import Workspace from "@resource/js/Pages/Workspace/Show.vue";
import CircleProgress from "@resource/js/Components/Circle_Progress.vue";
import DropdownMenu from "@resource/js/Components/Dropdowns/Dropdown_Menu_Container.vue";

import { useStore } from "vuex";
import { watch, ref, nextTick } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import axios from "axios";
/***************************
 ********** ICONS *********/
import plusIcon from "@public/svg/icons/plus.vue";
import ellipsisIcon from "@public/svg/icons/ellipsis.vue";
import folderIcon from "@public/svg/icons/folder.vue";
import addUserIcon from "@public/svg/icons/add_user.vue";
import editIcon from "@public/svg/icons/edit.vue";
import deleteIcon from "@public/svg/icons/delete.vue";

const props = defineProps({
    all_workspaces: Array,
    workspace_id: String,
    avatar: String,
    all_collections: Object,
    collection_id: String,
    all_current_sections: Object,
});

const store = useStore();

const collection = props.all_collections.find(
    (x) => x.collection_id === props.collection_id
);

let collection_created_at = collection.created_at.split("T")[0];

/*****************************************
 * STORING SECTION OBJECT IN VUE STORE ***
 ****************************************/
let all_current_sections = props.all_current_sections;

store.state.sections = props.all_current_sections;

watch(store.state.sections, (newValue, oldValue) => {
    all_current_sections = newValue;
});

/*****************************************
 ******* TOGGLING COLLECTION MODAL *******
 ****************************************/
const toggle_section_modal = () => {
    store.commit("setAddSectionModalIsClose", true);
};

/*****************************************
 *** TOGGLING COLLECTION DROPDOWN MENU ***
 ****************************************/
let active_col = ref("");
const toggle_colDD_menu = (id) => {
    if (active_col.value) {
        active_col.value = "";
    } else {
        active_col.value = id;
    }
};

/*****************************************
 ******* UPDATING COLLECTION NAME ********
 ****************************************/
const col_form = useForm({
    collection_name: "",
});

let toggle_col_input = ref(false);
let current_col_name = ref("");
let new_col_name = ref("");
let active_col_button = ref(false);

const show_collection_input = async (col_name) => {
    active_section.value = "";
    active_col.value = "";
    update_sectionID.value = "";

    toggle_col_input.value = true;
    current_col_name.value = col_name;
    new_col_name.value = col_name;

    await nextTick();

    document.getElementById("update_col_name").focus();
};

// DYNAMIC WATCHING INPUT CHANGES
watch(new_col_name, (newValue, oldValue) => {
    if (newValue == current_col_name.value) {
        active_col_button.value = false;
    } else {
        active_col_button.value = true;
        col_form.collection_name = new_col_name;
    }
});

const update_colName = async () => {
    try {
        const response = await axios.put(
            route("workspace.collections.update", {
                workspace: collection.workspace_id,
                collection_id: props.collection_id,
            }),
            col_form
        );
        if (response.status == 200) {
            // console.log("sucess");
            toggle_col_input.value = false;
            collection.collection_name = col_form.collection_name;
        }
    } catch (error) {
        console.log(error);
    }
};

/*****************************************
 **** TOGGLING SECTION DROPDOWN MENU *****
 ****************************************/
let active_section = ref("");
const toggle_sectionDD_menu = (id, index) => {
    store.state.current_section_index = index;
    if (active_section.value) {
        active_section.value = "";
    } else {
        active_section.value = id;
    }
};

/*****************************************
 ********* UPDATING SECTION NAME ********
 ****************************************/

const form = useForm({
    section_name: "",
});

let update_sectionID = ref("");
let sectionName = ref("");
let new_sectionName = ref("");
let active_button = ref(false);

// TOGGLING INPUT FIELD & AUTO FOCUS
const show_update_input = async (id, section_name) => {
    active_section.value = "";
    toggle_col_input.value = "";

    update_sectionID.value = id;
    sectionName.value = section_name;
    new_sectionName.value = section_name;

    await nextTick();

    document.getElementById("update_name").focus();
};

// DYNAMIC WATCHING INPUT CHANGES
watch(new_sectionName, (newValue, oldValue) => {
    if (newValue == sectionName.value) {
        active_button.value = false;
    } else {
        active_button.value = true;
        form.section_name = new_sectionName;
    }
});

// UPDATE THE DATA TO THE DATABASE
const update_sectionName = async () => {
    try {
        const response = await axios.put(
            route("workspace.collection.sections.update", {
                workspace: collection.workspace_id,
                collection_id: props.collection_id,
                section: update_sectionID.value,
            }),
            form
        );
        if (response.status == 200) {
            update_sectionID.value = "";
            store.commit("updateSection", response.data.updated_section);
        }
    } catch (error) {
        console.log(error);
    }
};

/*****************************************
 ***** TOGGLING DELETE SECTION MODAL *****
 ****************************************/
const toggle_delete_collection_modal = (id, name) => {
    active_col.value = false;
    store.state.current_col_id = id;
    store.state.current_col_name = name;
    store.commit("setDeleteCollectionModalIsClose", true);
};

/*****************************************
 ***** TOGGLING DELETE SECTION MODAL *****
 ****************************************/
const toggle_delete_section_modal = (id, name, index) => {
    active_section.value = false;
    store.state.current_section_index = index;
    store.state.current_section_id = id;
    store.state.current_section_name = name;
    store.commit("setDeleteSectionModalIsClose", true);
};
</script>

<style lang="postcss" scoped>
/***************************************************
******************* SHARED STYLE *******************
***************************************************/

/***************************************************
*************** PARENT COLLECTION ******************
***************************************************/
.collection__container {
    @apply relative flex gap-5 bg-neutral-50 max-h-[40rem] pb-[1.5rem];
}

/***************************************************
********************* SECTIONS *********************
***************************************************/
.section__wrapper {
    @apply w-full max-h-full;
}

.section-header {
    @apply flex justify-between;
}

.section-header > .icon {
    @apply cursor-pointer;
}

.section-lists__container {
    @apply grid gap-4;
}

.section-lists__wrapper {
    @apply relative grid items-center;
}

.section-lists__wrapper > a {
    @apply grid items-center gap-5 border-[.3px] border-neutral-300 p-[.9rem] rounded-lg;
    grid-template-columns: 1fr 0.7fr 0.1fr;
}

.section-list-name {
    @apply relative flex items-center gap-4;
}

.section-list-name > p {
    @apply text-sm text-neutral-700 font-medium;
}

.input-sectionName__wrapper {
    @apply absolute w-[98%] left-[.2rem] h-[90%] flex items-center gap-2 bg-shades-white z-[2];
}

.input-sectionName__wrapper > .input-error_icon {
    @apply relative top-0;
}

.section-list-progress {
    @apply flex gap-4 items-center;
}

.section-list-progress > .base {
    @apply relative w-full h-[.4rem] bg-neutral-300 rounded-full overflow-hidden;
}

.section-list-progress > .base > .bar {
    @apply bg-blue-500 w-[80%] h-full rounded-full;
}

.section-list-progress > p {
    @apply text-xs text-neutral-700 font-medium;
}

.section-list-ellipsis {
    @apply justify-self-end cursor-pointer;
}

.empty-section {
    @apply flex justify-center items-center w-full h-[2.8rem] border-dashed border-[.3px] border-neutral-300 rounded-lg;
}

.empty-section > p {
    @apply text-xs text-neutral-600;
}

/* DROPDOWN MENU */
/* :deep(.dropdown-menu__container) */
.section-menu {
    @apply top-[2rem] right-[1rem];
}

/***************************************************
***************** COLLECTION INFO ******************
***************************************************/
.collection-info__wrapper {
    @apply relative grid gap-5 w-full max-w-[35%];
    /* @apply grid gap-5 max-h-full bg-red-400; */
    /* grid-template-rows: 3fr 2fr; */
}

/***************************************************
************** COLLECTION PROGRESS *****************
***************************************************/
.collection-info-progress__wrapper {
    @apply h-full;
}

.collection-info-title__wrapper {
    @apply relative flex justify-between w-full;
}

.collection-info-title__wrapper > p {
    @apply text-base font-semibold text-neutral-700;
}

.collection-info-title__wrapper > .icon {
    @apply rotate-90 cursor-pointer;
}

.col-menu {
    @apply top-[1.5rem] right-[.5rem] z-[2];
}

.input-collectionName__wrapper {
    @apply absolute flex gap-3 items-center bg-shades-white w-full;
}

.input-collectionName__wrapper > .input__update {
    @apply text-lg;
}

.input-collectionName__wrapper > .input-error_icon {
    @apply static !important;
}

.collection-progress-info__wrapper {
    @apply flex flex-col items-center w-full;
}

.collection-progress-info__wrapper > p {
    @apply text-[.7rem] text-neutral-500;
}

.collection-progress-info__wrapper > p > span {
    @apply text-neutral-600 font-medium;
}

/***************************************************
********************* MEMBERS **********************
***************************************************/
.collection-info-members__wrapper {
    @apply relative overflow-y-hidden pb-[4rem];
}

.collection-info-members__wrapper.col-wrapper {
    @apply pl-[1.25rem] pr-0;
}

.collection-info-members__wrapper > .col-header-text {
    @apply mb-[1.2rem];
}

.member-lists__container {
    @apply grid gap-4 pr-[1.25rem] overflow-y-auto max-h-full;
}

.member-list__wrapper {
    @apply grid gap-4 items-center;
    grid-template-columns: auto 1fr auto;
}

.member-avatar__wrapper {
    @apply h-[2rem] rounded-full overflow-hidden max-w-[2rem] cursor-pointer;
}

.member-avatar__wrapper > img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.member-details__wrapper > .name {
    @apply text-sm text-neutral-700;
}

.member-details__wrapper > .email {
    @apply text-xs text-neutral-500;
}

.member-list__wrapper > .member-role {
    @apply flex items-center text-xs px-[1rem] py-[.2rem] border-[.3px] border-neutral-400 w-fit rounded-full !important;
}

/* SCROLL BAR */
.member-lists__container::-webkit-scrollbar {
    @apply w-[.4rem];
}

.member-lists__container::-webkit-scrollbar-track {
    @apply bg-blue-100 rounded-full;
}

.member-lists__container::-webkit-scrollbar-thumb {
    @apply bg-blue-300 rounded-full;
}
</style>
