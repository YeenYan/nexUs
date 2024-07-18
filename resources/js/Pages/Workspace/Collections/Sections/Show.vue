<template>
    <Workspace
        :all_workspaces="props.all_workspaces"
        :avatar="props.avatar"
        :all_collections="props.all_collections"
        :collection_id="props.collection_id"
    >
        <div class="breadcrumbs-header">
            <p>Collections / {{ props.section_data.section_name }}</p>
        </div>

        <!------------------------------>
        <!-------- TASKS SECTION ------->
        <!------------------------------>
        <section class="task__container container">
            <!------------------------------>
            <!------- LEFT SIDE PART ------->
            <!------------------------------>
            <div class="task__wrapper col-wrapper">
                <div class="task-header col-header__wrapper">
                    <p class="col-header-text">Tasks</p>
                    <plusIcon
                        class="icon add-tast__icon"
                        @click.prevent="toggle_task_modal"
                    />
                </div>
                <div class="search-input__wrapper">
                    <input type="text" placeholder="Search Task" />
                </div>

                <div class="task-group__wrapper scroll-style">
                    <div class="task-group-header__wrapper">
                        <p>Name</p>
                        <p>Progress</p>
                        <p>Priority</p>
                        <p>Assignee</p>
                        <p>Starred</p>
                    </div>
                    <ul class="task-group-data__wrapper">
                        <!-- <Link> -->
                        <li
                            class="task-list__wrapper"
                            v-for="task in current_tasks_list"
                            :key="task.task_id"
                        >
                            <!-- Task Title -->
                            <p class="task-name">{{ task.task_name }}</p>

                            <!-- Progress Bar -->
                            <div class="task-list-progress">
                                <div class="base">
                                    <div class="bar"></div>
                                </div>
                                <p>6 / 10</p>
                            </div>

                            <!-- Priority -->
                            <div
                                class="priority__wrapper"
                                @click.prevent="toggle_priority_menu"
                            >
                                <div
                                    :class="priority_type(task.priority_type)"
                                ></div>
                            </div>

                            <!-- Assignee -->
                            <ul class="assignee-avatar__wrapper">
                                <li>
                                    <img :src="avatar" alt="" />
                                </li>
                                <li>
                                    <img :src="avatar" alt="" />
                                </li>
                            </ul>

                            <!-- Starred -->
                            <div class="starred-icon">
                                <starIcon
                                    class="icon"
                                    :class="is_starred(task.starred)"
                                />
                            </div>
                            <!-- PRIORITY MENU -->
                            <div
                                class="priority-menu-parent__wrapper"
                                v-if="
                                    active_priority_menu &&
                                    store.state.active_priority_menu
                                "
                            >
                                <PriorityMenu />
                            </div>
                        </li>

                        <!-- </Link> -->
                    </ul>
                </div>
            </div>

            <!------------------------------>
            <!------- RIGHT SIDE PART ------>
            <!------------------------------>
            <div class="activity__wrapper col-wrapper">
                <div class="task-header col-header__wrapper">
                    <p class="col-header-text">Task Name Here Activities</p>
                    <ellipsisIcon class="icon" />
                </div>

                <div class="search-input__wrapper">
                    <input type="text" placeholder="Search Activity" />
                </div>

                <div class="activity-group__wrapper scroll-style">
                    <!----------- COMPLETE STATUS ------------>
                    <div class="activity-complete__wrapper">
                        <!-- HEADER -->
                        <div
                            class="activity-group-header"
                            @click.prevent="toggle_actComplete_list"
                        >
                            <caretDownIcon
                                class="icon activity-caretDown-icon"
                                :class="{ active: show_actComplete_list }"
                            />
                            <div class="status__wrapper complete">
                                <checkIcon class="status-icon complete" />
                                <p>Complete</p>
                            </div>
                        </div>

                        <!-- TABLE -->
                        <ul
                            class="activity-table__container scroll-style"
                            v-if="show_actComplete_list"
                        >
                            <div class="activity-table__static">
                                <p class="activity-table-header__text">
                                    Activity name
                                </p>
                                <li class="activity-table-list__text">
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur
                                        adipisicing elit. Odit, commodi.
                                    </p>
                                </li>
                            </div>

                            <div
                                class="activity-table__scrollable scroll-style"
                            >
                                <div class="activity-table-header__group">
                                    <p>Priority</p>
                                    <p>Due Date</p>
                                    <p>Assignee</p>
                                </div>
                                <li class="activity-table-list__group">
                                    <div
                                        class="priority__wrapper"
                                        @click.prevent="toggle_priority_menu"
                                    >
                                        <div></div>
                                    </div>
                                    <p>01/01/20</p>
                                    <ul class="assignee-avatar__wrapper">
                                        <li>
                                            <img :src="avatar" alt="" />
                                        </li>
                                        <li>
                                            <img :src="avatar" alt="" />
                                        </li>
                                        <button class="add-assigneeBtn">
                                            +
                                        </button>
                                    </ul>
                                </li>
                            </div>
                        </ul>
                    </div>

                    <!----------- IN PROGRESS STATUS ------------>
                    <div class="activity-inProgress__wrapper">
                        <!-- HEADER -->
                        <div
                            class="activity-group-header"
                            @click.prevent="toggle_actInProgress_list"
                        >
                            <caretDownIcon
                                class="icon activity-caretDown-icon"
                                :class="{ active: show_actInProgress_list }"
                            />
                            <div class="status__wrapper inProgress">
                                <hourGlassIcon class="status-icon inProgress" />
                                <p>In Progress</p>
                            </div>
                        </div>

                        <!-- TABLE -->
                        <ul
                            class="activity-table__container scroll-style"
                            v-if="show_actInProgress_list"
                        >
                            <div class="activity-table__static">
                                <p class="activity-table-header__text">
                                    Activity name
                                </p>
                                <li class="activity-table-list__text">
                                    <p>Activity Name Here</p>
                                </li>
                            </div>

                            <div
                                class="activity-table__scrollable scroll-style"
                            >
                                <div class="activity-table-header__group">
                                    <p>Priority</p>
                                    <p>Due Date</p>
                                    <p>Assignee</p>
                                </div>
                                <li class="activity-table-list__group">
                                    <div class="priority__wrapper">
                                        <div></div>
                                    </div>
                                    <p>01/01/20</p>
                                    <ul class="assignee-avatar__wrapper">
                                        <li>
                                            <img :src="avatar" alt="" />
                                        </li>
                                        <li>
                                            <img :src="avatar" alt="" />
                                        </li>
                                        <button class="add-assigneeBtn">
                                            +
                                        </button>
                                    </ul>
                                </li>
                            </div>
                        </ul>
                    </div>

                    <!----------- TO DO STATUS ------------>
                    <div class="activity-toDo__wrapper">
                        <!-- HEADER -->
                        <div
                            class="activity-group-header"
                            @click.prevent="toggle_actToDo_list"
                        >
                            <caretDownIcon
                                class="icon activity-caretDown-icon"
                                :class="{ active: show_actToDo_list }"
                            />
                            <div class="status__wrapper toDo">
                                <circleDotIcon class="status-icon toDo" />
                                <p>To Do</p>
                            </div>
                        </div>

                        <!-- TABLE -->
                        <ul
                            class="activity-table__container scroll-style"
                            v-if="show_actToDo_list"
                        >
                            <div class="activity-table__static">
                                <p class="activity-table-header__text">
                                    Activity name
                                </p>
                                <li class="activity-table-list__text">
                                    <p>Activity Name Here</p>
                                </li>
                            </div>

                            <div
                                class="activity-table__scrollable scroll-style"
                            >
                                <div class="activity-table-header__group">
                                    <p>Priority</p>
                                    <p>Due Date</p>
                                    <p>Assignee</p>
                                </div>
                                <li class="activity-table-list__group">
                                    <div class="priority__wrapper">
                                        <div></div>
                                    </div>
                                    <p>01/01/20</p>
                                    <ul class="assignee-avatar__wrapper">
                                        <li>
                                            <img :src="avatar" alt="" />
                                        </li>
                                        <li>
                                            <img :src="avatar" alt="" />
                                        </li>
                                        <button class="add-assigneeBtn">
                                            +
                                        </button>
                                    </ul>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </Workspace>
</template>

<script setup>
import Workspace from "@resource/js/Pages/Workspace/Show.vue";
import PriorityMenu from "@resource/js/Components/Dropdowns/Priority_Menu.vue";

import { Link, useForm } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue";
import { useStore } from "vuex";

/***************************
 ********** ICONS *********/
import caretDownIcon from "@public/svg/icons/caret-down.vue";
import plusIcon from "@public/svg/icons/plus.vue";
import ellipsisIcon from "@public/svg/icons/ellipsis.vue";
import starIcon from "@public/svg/icons/star.vue";
import checkIcon from "@public/svg/icons/check.vue";
import hourGlassIcon from "@public/svg/icons/hourGlass.vue";
import circleDotIcon from "@public/svg/icons/circleDot.vue";

const props = defineProps({
    all_workspaces: Array,
    workspace_id: String,
    avatar: String,
    all_collections: Object,
    collection_id: String,
    all_current_sections: Object,
    section_data: Object,
    tasks_list: Object,
});

const store = useStore();

/*****************************************
 * STORING SECTION OBJECT IN VUE STORE ***
 ****************************************/
let all_current_sections = props.all_current_sections;

store.state.sections = props.all_current_sections;

/*****************************************
 *** STORING TASKS OBJECT IN VUE STORE ***
 ****************************************/
let current_tasks_list = props.tasks_list;
store.state.tasks = props.tasks_list;

watch(store.state.tasks, (newValue, oldValue) => {
    current_tasks_list = newValue[0];
});

/*****************************************
 ****** IDENTIFYING PRIORITY STATUS ******
 ****************************************/
let priority_type = (val) => {
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

/*****************************************
 ****** IDENTIFYING STARRED STATUS ******
 ****************************************/
let is_starred = (val) => {
    switch (val) {
        case 1:
            return "is_starred";
        case 0:
            return "not_starred";
        default:
            return "not_starred";
    }
};

/*****************************************
 ******* TOGGLING ACTIVITIES LIST ********
 ****************************************/
let show_actComplete_list = ref(false);
let show_actInProgress_list = ref(false);
let show_actToDo_list = ref(false);

const toggle_actComplete_list = () => {
    show_actComplete_list.value = !show_actComplete_list.value;
};

const toggle_actInProgress_list = () => {
    show_actInProgress_list.value = !show_actInProgress_list.value;
};

const toggle_actToDo_list = () => {
    show_actToDo_list.value = !show_actToDo_list.value;
};

/*****************************************
 ******** TOGGLING PRIORITY MENU *********
 ****************************************/
let active_priority_menu = ref(false);

const toggle_priority_menu = () => {
    active_priority_menu.value = true;
    store.commit("showPriorityMenu", true);
};

/*****************************************
 ********* TOGGLING TASK MODAL ***********
 ****************************************/
const toggle_task_modal = () => {
    store.state.current_section_id = props.section_data.section_id;
    store.state.selected_priority_type = null;
    store.commit("setAddTaskModalIsClose", true);
};
</script>

<style lang="postcss" scoped>
/***************************************************
******************* SHARED STYLE *******************
***************************************************/
.task__wrapper > .search-input__wrapper,
.activity__wrapper > .search-input__wrapper {
    @apply text-right;
}

.starred-icon {
    @apply flex justify-center cursor-pointer;
}

/* Task Header Part */
.task-group-header__wrapper,
.task-list__wrapper {
    @apply grid;
    /* grid-template-columns: 1.5fr 0.8fr 0.4fr 0.8fr 0.4fr; */
    grid-template-columns: 55% 15rem 4rem 7rem 4rem;
}

/***************************************************
******************* PARENT TASK ********************
***************************************************/
.task__container {
    @apply relative flex gap-5 bg-neutral-50 h-full max-h-[40rem];
}

/***************************************************
**************** TASK LEFT SIDE ********************
***************************************************/
.add-tast__icon {
    @apply cursor-pointer;
}

.task__wrapper {
    @apply flex flex-col w-[80%] max-w-[45rem] max-h-full;
}

.task-group__wrapper {
    @apply w-full overflow-x-scroll pb-[1rem] h-full;
}

.task-header {
    @apply flex justify-between;
}

/* Task Header Part */

.task-group-header__wrapper > p {
    @apply text-xs text-neutral-500 h-full border-b-[.3px] border-neutral-300 px-[.8rem] py-[.5rem];
}

/* Task Data Part */

.task-group-data__wrapper {
    @apply relative;
}
.task-list__wrapper {
    @apply grid items-center;
}

.task-list__wrapper > * {
    @apply h-full items-center border-b-[.3px] border-neutral-300 px-[.8rem] py-[.7rem];
}

.task-name {
    @apply text-sm text-neutral-700;
}

/* Task Progress Bar */
.task-list-progress {
    @apply flex gap-4 items-center;
}

.task-list-progress > .base {
    @apply relative w-full h-[.4rem] bg-neutral-300 rounded-full overflow-hidden;
}

.task-list-progress > .base > .bar {
    @apply bg-blue-500 w-[80%] h-full rounded-full;
}

.task-list-progress > p {
    @apply text-xs text-neutral-700 font-medium text-nowrap;
}

.priority-menu-parent__wrapper {
    @apply absolute top-0 right-[0rem] w-full max-w-[11rem];
}

/***************************************************
************* ACTIVITY RIGHT SIDE ******************
***************************************************/

.activity__wrapper {
    @apply w-[50%] max-h-full overflow-y-hidden;
}

.activity-group__wrapper {
    @apply relative grid w-full h-full pb-[20rem] overflow-y-scroll px-[1.5rem] mt-[.8rem];
}

.activity-group__wrapper.scroll-style {
    @apply absolute right-0;
}

.activity-complete__wrapper,
.activity-inProgress__wrapper,
.activity-toDo__wrapper {
    @apply mb-[3rem];
}

.activity-group-header {
    @apply sticky top-0 pb-[.5rem] bg-shades-white;
}

.activity-group-header {
    @apply flex gap-3 cursor-pointer;
}

.activity-caretDown-icon {
    @apply w-[.6rem] fill-neutral-500 rotate-[-90deg] !important;
    transition: all 0.2s ease-in-out;
}

.activity-caretDown-icon.active {
    @apply rotate-0 !important;
}

/* ============= */
/* TABLE STYLES */
.activity-table__container {
    @apply w-full grid overflow-x-hidden max-h-full;
    grid-template-columns: 60% 40%;
    /* overflow-y-scroll */
}

.activity-table__static {
    @apply h-full pb-[1rem];
}

.activity-table__scrollable {
    @apply w-full overflow-x-scroll pb-[1rem];
}

.activity-table__scrollable > div,
.activity-table__scrollable > li {
    @apply grid items-center;
    grid-template-columns: 4rem 6rem 10rem;
}

.activity-table-header__text,
.activity-table-header__group > p {
    @apply text-xs text-neutral-500 py-[.5rem] border-b-[.3px];
}

.activity-table-list__text {
    @apply py-[.5rem] border-b-[.3px];
}

.activity-table-list__text > p {
    @apply max-w-[14rem];
    white-space: nowrap; /* Prevent text from wrapping */
    overflow: hidden; /* Hide overflowed text */
    text-overflow: ellipsis; /* Add ellipsis (...) */
    /* max-width: 200px; */
    display: block;
}

.activity-table-list__group > div,
.activity-table-list__group > p,
.activity-table-list__group > ul {
    @apply py-[.325rem] border-b-[.3px] h-full flex items-center;
}

.activity-table-list__text,
.activity-table-list__group > p {
    @apply text-sm text-neutral-700;
}

.add-assigneeBtn {
    @apply bg-shades-white border-[.3px] border-neutral-300 px-[.45rem] rounded-full cursor-pointer;
}
/* ============= */
</style>
