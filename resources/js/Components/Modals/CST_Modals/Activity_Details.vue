<template>
    <div class="activity-details__container">
        <div class="blanket__wrapper" data-aos="show_in">
            <div></div>
        </div>

        <div class="activity-details__wrapper">
            <div class="ad-header__wrapper">
                <p class="ad-header__title">{{ activity.activity_name }}</p>
                <div class="ad-header__action-wrapper">
                    <ellipsisIcon
                        class="icon"
                        @click.prevent="activity_menu = !activity_menu"
                    />
                    <closeIcon class="icon" @click.prevent="close_modal" />
                </div>

                <div
                    class="input__box input-activityName__wrapper"
                    v-if="edit_acName_mode"
                >
                    <input
                        v-model="new_activity_name"
                        class="input__update"
                        type="text"
                        id="update_activity_name"
                    />
                    <button
                        @click="update_activityName"
                        :disabled="!update_activity_button"
                        class="input-updateName__btn"
                        :class="{ active: update_activity_button }"
                    >
                        Update
                    </button>
                    <p
                        class="input-close_icon"
                        @click.prevent="edit_acName_mode = false"
                    >
                        x
                    </p>
                </div>

                <DropdownMenu class="activity-menu" v-if="activity_menu">
                    <template #normal>
                        <div
                            class="normal"
                            @click.prevent="toggle_activity_input"
                        >
                            <editIcon class="icon" />
                            <p>Rename</p>
                        </div>
                        <div
                            class="delete"
                            @click.prevent="toggle_delete_activity_modal"
                        >
                            <deleteIcon class="icon" />
                            <p>Delete</p>
                        </div>
                    </template>
                </DropdownMenu>
            </div>

            <div class="ad-content__wrapper">
                <!-- ACTIVITY INFO => RIGHT SIDE -->
                <div class="ad-info__container">
                    <!-- =================================================== -->
                    <!-- MAIN INFO -->
                    <div class="ad-main__wrapper">
                        <ul class="ad-info__title-group">
                            <li class="ad-info__title-list">
                                <circleIcon class="icon" />
                                <p>Status</p>
                            </li>
                            <li class="ad-info__title-list">
                                <clockIcon class="icon" />
                                <p>Priority</p>
                            </li>
                            <li class="ad-info__title-list">
                                <userIcon class="icon" />
                                <p>Assignee</p>
                            </li>
                            <li class="ad-info__title-list">
                                <dateIcon class="icon" />
                                <p>Due Date</p>
                            </li>
                        </ul>
                        <ul class="ad-info__action-group">
                            <!-- STATUS -->
                            <li class="ad-info__action-list">
                                <div
                                    class="status__wrapper complete"
                                    v-if="activity.status_type == 2"
                                    @click.prevent="toggle_status_menu"
                                >
                                    <checkIcon class="status-icon complete" />
                                    <p>Complete</p>
                                </div>
                                <div
                                    class="status__wrapper inProgress"
                                    v-if="activity.status_type == 1"
                                    @click.prevent="toggle_status_menu"
                                >
                                    <hourGlassIcon
                                        class="status-icon inProgress"
                                    />
                                    <p>In Progress</p>
                                </div>
                                <div
                                    class="status__wrapper toDo"
                                    v-if="activity.status_type == 0"
                                    @click.prevent="toggle_status_menu"
                                >
                                    <circleDotIcon class="status-icon toDo" />
                                    <p>To Do</p>
                                </div>
                                <div
                                    class="status-menu-parent__wrapper"
                                    v-if="store.state.activity_status_menu"
                                >
                                    <StatusMenu />
                                </div>
                            </li>

                            <!-- PRIORITY -->
                            <li class="ad-info__action-list">
                                <div
                                    class="priority__wrapper"
                                    @click.prevent="toggle_priority_menu"
                                >
                                    <div
                                        :class="
                                            priority_type_color(
                                                activity.priority_type
                                            )
                                        "
                                    ></div>
                                    <p>
                                        {{
                                            priority_type_text(
                                                activity.priority_type
                                            )
                                        }}
                                    </p>
                                </div>
                                <!-- PRIORITY MENU -->
                                <div
                                    class="priority-menu-parent__wrapper"
                                    v-if="
                                        active_priority_menu &&
                                        store.state
                                            .active_activity_priority_menu
                                    "
                                >
                                    <PriorityMenu />
                                </div>
                            </li>

                            <!-- ASSIGNEE -->
                            <li class="ad-info__action-list">
                                <ul class="assignee-avatar__wrapper">
                                    <li>
                                        <img :src="avatar" alt="" />
                                    </li>
                                    <li>
                                        <img :src="avatar" alt="" />
                                    </li>
                                    <button class="add-assigneeBtn">+</button>
                                </ul>
                            </li>

                            <!-- DUE DATE -->

                            <li class="ad-info__action-list">
                                <div
                                    class="due-date__wrapper"
                                    :class="date_invalid ? 'input-error' : ''"
                                >
                                    <dateIcon class="icon" />
                                    <p>{{ formatted_date }}</p>
                                    <input
                                        type="date"
                                        class="due-date"
                                        v-model="selectedDate"
                                        @input="updateDateLabel"
                                        @change="update_due_date"
                                    />
                                </div>
                                <p
                                    class="date_invalid_text"
                                    v-if="date_invalid"
                                >
                                    Selected date must be today or in the
                                    future.
                                </p>
                            </li>
                        </ul>
                    </div>

                    <!-- =================================================== -->
                    <!-- DETAILS -->
                    <div class="ad-details__wrapper">
                        <div>
                            <div class="ad-details__header">
                                <p class="ad-subtitle">Description</p>
                                <editIcon
                                    class="icon edit_icon"
                                    @click.prevent="toggle_edit"
                                />
                            </div>
                            <div
                                class="ad-details__content ad_description__wrapper"
                            >
                                <p>
                                    {{ activity.description }}
                                </p>
                                <textarea
                                    v-if="edit_desc_mode"
                                    v-model="new_desc"
                                    type="textarea"
                                    class="ad_description_textarea"
                                    id="ad_description_textarea"
                                />
                            </div>
                            <!-- UPDATE INPUT FIELDS -->
                            <div
                                class="input__box input-desc__wrapper"
                                v-if="edit_desc_mode"
                            >
                                <button
                                    @click="update_description"
                                    :disabled="!update_desc_button"
                                    class="input-updateName__btn"
                                    :class="{ active: update_desc_button }"
                                >
                                    Update
                                </button>
                                <p
                                    class="input-close_icon"
                                    @click.prevent="edit_desc_mode = false"
                                >
                                    x
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- =================================================== -->
                    <!-- ACTIVITY LOGS -->
                    <div class="ad-logs__wrapper">
                        <div>
                            <p class="ad-subtitle">Activity Logs</p>
                            <ul class="ad-logs__lists">
                                <li class="ad-logs__list">
                                    <p>
                                        Username changed status To Do to In
                                        Progress
                                    </p>
                                    <p>April 20, 2000 at 10:00 am</p>
                                </li>
                                <li class="ad-logs__list">
                                    <p>
                                        Username changed status To Do to In
                                        Progress
                                    </p>
                                    <p>April 20, 2000 at 10:00 am</p>
                                </li>
                                <li class="ad-logs__list">
                                    <p>
                                        Username changed status To Do to In
                                        Progress
                                    </p>
                                    <p>April 20, 2000 at 10:00 am</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- COMMENTS => LEFT SIDE -->
                <div class="ad-comment__container">
                    <div class="ad-comment__header">
                        <p class="ad-subtitle">Comments</p>
                    </div>
                    <div class="ad-comment__body-wrapper scroll-style">
                        <ul class="ad-comment__data-lists">
                            <li class="ad-comment__list">
                                <div class="ad-comment__user-wrapper">
                                    <ul class="assignee-avatar__wrapper">
                                        <li>
                                            <img :src="avatar" alt="" />
                                        </li>
                                        <p class="ad-comment__userName">
                                            Juan Dela Cruz
                                        </p>
                                    </ul>
                                    <p class="ad-comment__dateTime">
                                        April 20, 2000 at 10:00 am
                                    </p>
                                </div>
                                <p class="ad-comment__text">
                                    Lorem ipsum dolor sit amet consectetur,
                                    adipisicing elit. Nam inventore odit
                                    officiis ratione error harum placeat velit
                                    amet? Obcaecati, officia.
                                </p>
                            </li>
                            <li class="ad-comment__list">
                                <div class="ad-comment__user-wrapper">
                                    <ul class="assignee-avatar__wrapper">
                                        <li>
                                            <img :src="avatar" alt="" />
                                        </li>
                                        <p class="ad-comment__userName">
                                            Juan Dela Cruz
                                        </p>
                                    </ul>
                                    <p class="ad-comment__dateTime">
                                        April 20, 2000 at 10:00 am
                                    </p>
                                </div>
                                <p class="ad-comment__text">
                                    Lorem ipsum dolor sit amet consectetur,
                                    adipisicing elit. Nam inventore odit
                                    officiis ratione error harum placeat velit
                                    amet? Obcaecati, officia.
                                </p>
                            </li>
                            <li class="ad-comment__list">
                                <div class="ad-comment__user-wrapper">
                                    <ul class="assignee-avatar__wrapper">
                                        <li>
                                            <img :src="avatar" alt="" />
                                        </li>
                                        <p class="ad-comment__userName">
                                            Juan Dela Cruz
                                        </p>
                                    </ul>
                                    <p class="ad-comment__dateTime">
                                        April 20, 2000 at 10:00 am
                                    </p>
                                </div>
                                <p class="ad-comment__text">
                                    Lorem ipsum dolor sit amet consectetur,
                                    adipisicing elit. Nam inventore odit
                                    officiis ratione error harum placeat velit
                                    amet? Obcaecati, officia.
                                </p>
                            </li>
                            <li class="ad-comment__list">
                                <div class="ad-comment__user-wrapper">
                                    <ul class="assignee-avatar__wrapper">
                                        <li>
                                            <img :src="avatar" alt="" />
                                        </li>
                                        <p class="ad-comment__userName">
                                            Juan Dela Cruz
                                        </p>
                                    </ul>
                                    <p class="ad-comment__dateTime">
                                        April 20, 2000 at 10:00 am
                                    </p>
                                </div>
                                <p class="ad-comment__text">
                                    Lorem ipsum dolor sit amet consectetur,
                                    adipisicing elit. Nam inventore odit
                                    officiis ratione error harum placeat velit
                                    amet? Obcaecati, officia.
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="ad-comment__input-wrapper">
                        <input
                            class="ad-comment__input-field"
                            type="text"
                            placeholder="Write a comment..."
                        />
                        <button class="ad-comment__btnSend">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import PriorityMenu from "@resource/js/Components/Dropdowns/Priority_Menu.vue";
import StatusMenu from "@resource/js/Components/Dropdowns/Status_Menu.vue";
import DropdownMenu from "@resource/js/Components/Dropdowns/Dropdown_Menu_Container.vue";

/***************************
 ********** ICONS *********/
import circleIcon from "@public/svg/icons/circle.vue";
import closeIcon from "@public/svg/icons/xmark.vue";
import ellipsisIcon from "@public/svg/icons/ellipsis.vue";
import clockIcon from "@public/svg/icons/clock.vue";
import userIcon from "@public/svg/icons/user.vue";
import dateIcon from "@public/svg/icons/date.vue";
import checkIcon from "@public/svg/icons/check.vue";
import circleDotIcon from "@public/svg/icons/circleDot.vue";
import hourGlassIcon from "@public/svg/icons/hourGlass.vue";
import editIcon from "@public/svg/icons/edit.vue";
import plusIcon from "@public/svg/icons/plus.vue";
import deleteIcon from "@public/svg/icons/delete.vue";

import { computed, ref, onMounted, watch, nextTick } from "vue";
import { useStore } from "vuex";
import axios from "axios";

// JUST REMOVE THIS FOR AVATAR
import avatar from "@public/storage/avatars/mark-693e3de9-97cf-496a-ab32-b63ea739293a.jpg";

const store = useStore();

/*****************************************
 ***** FETCH CURRENT ACTIVITY DETAILS ****
 ****************************************/
// let activity = store.state.current_activity_details;

let activity = computed(() => store.state.current_activity_details);

/*****************************************
 ********* SELECTING A DUE DATE **********
 ****************************************/
let date_value = ref(null);
let formatted_date = ref("Due Date");
let selectedDate = ref("");

const updateDateLabel = () => {
    if (selectedDate.value) {
        date_value.value = selectedDate.value;
        const options = { month: "short", day: "2-digit" };
        formatted_date.value = new Date(selectedDate.value).toLocaleDateString(
            "en-US",
            options
        );
    } else {
        formatted_date.value = "Due Date";
    }
};

let date_invalid = ref(false);

const update_due_date = () => {
    const savedDate = new Date(store.state.current_activity_details.due_date);
    savedDate.setHours(0, 0, 0, 0);

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const targetDate = new Date(selectedDate.value);
    targetDate.setHours(0, 0, 0, 0);

    if (savedDate.getTime() == targetDate.getTime()) {
        date_invalid.value = false;
    } else if (targetDate.getTime() < today.getTime()) {
        date_invalid.value = true;
    } else {
        date_invalid.value = false;
        store.commit("update_due_date", selectedDate.value);
    }
};

onMounted(() => {
    selectedDate.value = store.state.current_activity_details.due_date;
    updateDateLabel();
});

/*****************************************
 ********** PRIORITY TYPE LOGIC **********
 ****************************************/
let priority_type_text = (val) => {
    switch (val) {
        case 3:
            return "Urgent";
        case 2:
            return "High";
        case 1:
            return "Normal";
        case 0:
            return "Low";
        default:
            return "Priority Type";
    }
};

let priority_type_color = (val) => {
    switch (val) {
        case 3:
            return "urgent";
        case 2:
            return "high";
        case 1:
            return "normal";
        case 0:
            return "low";
        default:
            return "default";
    }
};

// SHOW PRIORITY MENU DROPDOWN
let active_priority_menu = ref(false);

const toggle_priority_menu = () => {
    store.state.priority_mode = "update_activity_priority";
    active_priority_menu.value = true;
    store.commit("showActivityPriorityMenu", true);
};

/*****************************************
 *********** STATUS TYPE LOGIC ***********
 ****************************************/
const toggle_status_menu = () => {
    store.state.activity_status_menu = true;
    store.state.status_mode = "update_activity_status";
};

/*****************************************
 ****** EDIT / UPDATE ACTIVITY NAME ******
 ****************************************/
let activity_menu = ref(false);
let edit_acName_mode = ref(false);
let new_activity_name = ref("");
let update_activity_button = ref(false);

let current_activity_name = computed(
    () => store.state.current_activity_details.activity_name
);

const toggle_activity_input = async () => {
    new_activity_name.value = current_activity_name.value;

    edit_acName_mode.value = true;
    activity_menu.value = false;
    update_activity_button.value = false;

    await nextTick();

    document.getElementById("update_activity_name").focus();
};

watch(new_activity_name, (newValue, oldValue) => {
    if (newValue == current_activity_name.value) {
        update_activity_button.value = false;
    } else {
        update_activity_button.value = true;
    }
});

const update_activityName = () => {
    store.commit("update_activity_name", new_activity_name.value);
    edit_acName_mode.value = false;
};

/*****************************************
 ****** EDIT / UPDATE DESCRIPTION ********
 ****************************************/

let edit_desc_mode = ref(false);
let currentDesc = computed(
    () => store.state.current_activity_details.description
);
let new_desc = ref("");
let update_desc_button = ref(false);

const toggle_edit = async () => {
    edit_desc_mode.value = true;
    update_desc_button.value = false;
    new_desc.value = currentDesc.value;

    await nextTick();

    document.getElementById("ad_description_textarea").focus();
};

watch(new_desc, (newValue, oldValue) => {
    if (newValue == currentDesc.value) {
        update_desc_button.value = false;
    } else {
        update_desc_button.value = true;
    }
});

const update_description = () => {
    store.commit("update_description", new_desc.value);
    edit_desc_mode.value = false;
};

/*****************************************
 **** TOGGLING DELETE ACTIVITY MODAL *****
 ****************************************/
const toggle_delete_activity_modal = () => {
    activity_menu.value = false;
    store.commit("setDeleteActivityModalIsClose", true);
};

/*****************************************
 ************** CLOSING MODAL ************
 ****************************************/
const close_modal = () => {
    activity_menu.value = false;
    store.commit("setActivityDetailsModalIsClose", false);
};
</script>

<style lang="postcss" scoped>
.activity-details__container {
    @apply absolute top-0 flex items-center justify-center w-full h-full z-[10];
}

.activity-details__wrapper {
    @apply bg-shades-white w-full max-w-[65rem] h-full max-h-[36rem] rounded-xl overflow-hidden z-[1] drop-shadow-xl px-[1.3rem] pt-[1.3rem];
}

.ad-content__wrapper {
    @apply grid border-r-[.3px] border-neutral-300;
    grid-template-columns: 2fr 1fr;
}

.ad-subtitle {
    @apply text-xs text-neutral-700 font-medium;
}

.ad-info__container {
    @apply pr-[1rem] border-r-[.3px] border-neutral-300;
}

/***************************************************
******************* HEADER PART ********************
***************************************************/
.ad-header__wrapper {
    @apply relative grid border-b-[.3px] border-neutral-300 pb-[1rem];
    grid-template-columns: 95% 5%;
}

.ad-header__title {
    @apply text-base text-neutral-600 font-medium;
}

.ad-header__action-wrapper {
    @apply flex gap-4;
}

.ad-header__action-wrapper > .icon {
    @apply fill-neutral-500 cursor-pointer;
}

.activity-menu {
    @apply absolute right-0;
}

.input-activityName__wrapper {
    @apply absolute flex gap-2;
}

/***************************************************
***************** MAIN INFO PART *******************
***************************************************/
.ad-main__wrapper {
    @apply grid py-[1rem] border-b-[.3px] border-neutral-300;
    grid-template-columns: 0.4fr 2fr;
}

.ad-info__title-group,
.ad-info__action-group {
    @apply grid gap-4 items-center;
    grid-template-rows: repeat(4, 1fr);
}

.ad-info__title-list {
    @apply flex items-center gap-2;
}

.ad-info__title-list > .icon {
    @apply w-[.8rem] fill-neutral-500;
}

.ad-info__title-list > p {
    @apply text-xs text-neutral-600;
}

.ad-info__action-list {
    @apply relative flex cursor-pointer;
}

.status-menu-parent__wrapper {
    @apply absolute top-[-1rem] left-0 z-[10];
}

.priority__wrapper {
    @apply flex gap-2;
}

.priority__wrapper > p {
    @apply text-xs text-neutral-600;
}

.priority-menu-parent__wrapper {
    @apply absolute top-[-1.2rem] left-[1rem] z-[10];
}

/* FOR ACTIVITIES DUE DATES */

.due-date[data-v-4bc80689] {
    @apply absolute w-full outline-none border-none focus:outline-none opacity-0;
}

.date_invalid_text {
    @apply absolute text-xs text-red-500 left-[6rem] top-[.4rem];
}

/***************************************************
****************** DETAILS PART ********************
***************************************************/
.ad-details__wrapper {
    @apply py-[1rem] border-b-[.3px] border-neutral-300 h-fit;
}

.ad-details__wrapper > div {
    @apply relative p-[1rem] border-[.3px] border-neutral-300 rounded-lg;
}

.ad-details__header {
    @apply flex justify-between items-center;
}

.edit_icon {
    @apply cursor-pointer fill-neutral-500;
}

.input-desc__wrapper {
    @apply flex gap-1 justify-end absolute top-[.8rem] right-0 px-[1rem] bg-shades-white w-[20%];
}

.ad-details__content {
    @apply bg-neutral-50 p-[1rem] rounded-lg mt-[.5rem];
}

.ad-details__content > p {
    @apply text-xs text-neutral-600;
}

.ad_description__wrapper {
    @apply relative overflow-hidden;
}

.ad_description_textarea {
    @apply absolute top-0 left-0 text-xs w-full h-full p-[1rem] outline-0 bg-neutral-100;
}

/***************************************************
******************** LOGS PART *********************
***************************************************/
.ad-logs__wrapper {
    @apply py-[1rem];
}

.ad-logs__wrapper > div {
    @apply p-[1rem] border-[.3px] border-neutral-300 rounded-lg;
}

.ad-logs__lists {
    @apply flex flex-col gap-1 mt-[.5rem];
}

.ad-logs__list {
    @apply flex justify-between text-neutral-500 px-[.7rem] py-[.2rem] border-[.3px] rounded-full;
}

.ad-logs__list > p {
    @apply text-[.7rem];
}

/***************************************************
******************* COMMENT PART *******************
***************************************************/
/* PARENT HERE */
.ad-comment__container {
    @apply relative flex flex-col items-center w-full h-full bg-neutral-100;
}

.ad-comment__header {
    @apply px-[1rem] py-[.7rem] bg-shades-white border-b-[.3px] border-neutral-300 w-full;
}

.ad-comment__body-wrapper {
    @apply px-[1rem] max-h-[24rem] overflow-y-scroll;
}

/* COMMENT BOX */
.ad-comment__data-lists {
    @apply flex flex-col gap-2 py-[1rem] h-full;
}

.ad-comment__list {
    @apply p-[.8rem] bg-shades-white rounded-lg;
}

.ad-comment__user-wrapper {
    @apply flex items-center justify-between text-neutral-600;
}
.ad-comment__userName {
    @apply text-xs;
}

.ad-comment__dateTime {
    @apply text-[.6rem];
}

.ad-comment__text {
    @apply text-xs text-neutral-600 py-[.8rem];
}

/* INPUT FIELDS */
.ad-comment__input-wrapper {
    @apply absolute bottom-[1rem] px-[.7rem] py-[.7rem] flex gap-2 bg-shades-white w-[90%] rounded-lg;
}

.ad-comment__input-field {
    @apply text-xs outline-0 w-full;
}

.ad-comment__btnSend {
    @apply text-xs text-shades-white bg-blue-500 px-[1rem] py-[.3rem] rounded;
}
</style>
