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

                    <div
                        class="empty_task"
                        v-if="
                            !current_tasks_list ||
                            current_tasks_list.length <= 0
                        "
                    >
                        <p>~ No Task Available ~</p>
                    </div>

                    <ul class="task-group-data__wrapper">
                        <!-- <Link> -->
                        <li
                            class="task-list__wrapper"
                            v-for="(task, index) in current_tasks_list"
                            :key="task.task_id"
                        >
                            <!-- Task Title -->
                            <p
                                class="task-name"
                                @click.prevent="show_activities(index, task)"
                            >
                                {{ task.task_name }}
                            </p>

                            <!-- Progress Bar -->
                            <div class="task-list-progress">
                                <div class="base">
                                    <div
                                        class="bar"
                                        :class="
                                            percentage_color(
                                                task.total_activities,
                                                task.completed_activities
                                            )
                                        "
                                        :style="{
                                            width:
                                                percentage(
                                                    task.total_activities,
                                                    task.completed_activities
                                                ) + '%',
                                        }"
                                    ></div>
                                </div>
                                <p>
                                    {{ task.completed_activities }}
                                    / {{ task.total_activities }}
                                </p>

                                <!-- PRIORITY MENU -->
                                <div
                                    class="priority-menu-parent__wrapper"
                                    v-if="
                                        active_priority_menu == index &&
                                        store.state.active_task_priority_menu
                                    "
                                >
                                    <PriorityMenu />
                                </div>
                            </div>

                            <!-- Priority -->
                            <div
                                class="priority__wrapper"
                                @click.prevent="
                                    toggle_priority_menu(
                                        index,
                                        task.section_id,
                                        task.task_id
                                    )
                                "
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
                            <div
                                class="starred-icon"
                                @click.prevent="
                                    update_starred(
                                        index,
                                        task.section_id,
                                        task.task_id,
                                        task.starred
                                    )
                                "
                            >
                                <starIcon
                                    class="icon"
                                    :class="is_starred(task.starred)"
                                />
                            </div>
                        </li>

                        <!-- </Link> -->
                    </ul>
                </div>
            </div>

            <!------------------------------>
            <!------- RIGHT SIDE PART ------>
            <!------------------------------>
            <div
                class="activity__wrapper col-wrapper"
                :class="!is_activities ? 'minimize' : ''"
            >
                <div class="task-header col-header__wrapper">
                    <p class="col-header-text">
                        {{
                            store.state.current_task.task_name
                                ? store.state.current_task.task_name
                                : "———"
                        }}
                    </p>
                    <ellipsisIcon
                        class="icon"
                        @click.prevent="toggle_taskDD_menu"
                    />

                    <!-- UPDATE INPUT FIELDS -->
                    <div
                        class="input__box input-taskName__wrapper"
                        v-if="toggle_task_input"
                    >
                        <input
                            v-model="new_task_name"
                            class="input__update"
                            type="text"
                            id="update_task_name"
                        />
                        <button
                            @click="update_taskName"
                            :disabled="!update_task_button"
                            class="input-updateName__btn"
                            :class="{ active: update_task_button }"
                        >
                            Update
                        </button>
                        <p
                            class="input-close_icon"
                            @click.prevent="toggle_task_input = false"
                        >
                            x
                        </p>
                    </div>
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
                        <div v-if="show_actComplete_list">
                            <div
                                class="activity-table-nodata__wrapper"
                                v-if="complete_activity.length < 1"
                            >
                                <p>No Activity to show</p>
                            </div>

                            <ul class="activity-table__container scroll-style">
                                <div class="activity-table__static">
                                    <p class="activity-table-header__text">
                                        Activity Name
                                    </p>
                                    <li
                                        class="activity-table-list__text activity_name"
                                        v-for="activity in complete_activity"
                                        :key="activity.activity_id"
                                        @click.prevent="
                                            show_activity_details(activity)
                                        "
                                    >
                                        <p>
                                            {{ activity.activity_name }}
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
                                    <li
                                        class="activity-table-list__group"
                                        v-for="activity in complete_activity"
                                        :key="activity.activity_id"
                                    >
                                        <div class="priority__wrapper">
                                            <div
                                                :class="
                                                    priority_type(
                                                        activity.priority_type
                                                    )
                                                "
                                            ></div>
                                        </div>
                                        <p>{{ activity.due_date }}</p>
                                        <ul class="assignee-avatar__wrapper">
                                            <li>
                                                <img :src="avatar" alt="" />
                                            </li>
                                            <li>
                                                <img :src="avatar" alt="" />
                                            </li>
                                        </ul>
                                    </li>
                                </div>
                            </ul>
                        </div>
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
                        <div v-if="show_actInProgress_list">
                            <div
                                class="activity-table-nodata__wrapper"
                                v-if="in_progress_activity.length < 1"
                            >
                                <p>No Activity to show</p>
                            </div>

                            <ul class="activity-table__container scroll-style">
                                <div class="activity-table__static">
                                    <p class="activity-table-header__text">
                                        Activity name
                                    </p>
                                    <li
                                        class="activity-table-list__text activity_name"
                                        v-for="activity in in_progress_activity"
                                        :key="activity.activity_id"
                                        @click.prevent="
                                            show_activity_details(activity)
                                        "
                                    >
                                        <p>{{ activity.activity_name }}</p>
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
                                    <li
                                        class="activity-table-list__group"
                                        v-for="activity in in_progress_activity"
                                        :key="activity.activity_id"
                                    >
                                        <div class="priority__wrapper">
                                            <div
                                                :class="
                                                    priority_type(
                                                        activity.priority_type
                                                    )
                                                "
                                            ></div>
                                        </div>
                                        <p>{{ activity.due_date }}</p>
                                        <ul class="assignee-avatar__wrapper">
                                            <li>
                                                <img :src="avatar" alt="" />
                                            </li>
                                            <li>
                                                <img :src="avatar" alt="" />
                                            </li>
                                        </ul>
                                    </li>
                                </div>
                            </ul>
                        </div>
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
                        <div v-if="show_actToDo_list">
                            <div
                                class="activity-table-nodata__wrapper"
                                v-if="to_do_activity.length < 1"
                            >
                                <p>No Activity to show</p>
                            </div>

                            <ul class="activity-table__container scroll-style">
                                <div class="activity-table__static">
                                    <p class="activity-table-header__text">
                                        Activity name
                                    </p>
                                    <li
                                        class="activity-table-list__text activity_name"
                                        v-for="activity in to_do_activity"
                                        :key="activity.activity_id"
                                        @click.prevent="
                                            show_activity_details(activity)
                                        "
                                    >
                                        <p>{{ activity.activity_name }}</p>
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
                                    <li
                                        class="activity-table-list__group"
                                        v-for="activity in to_do_activity"
                                        :key="activity.activity_id"
                                    >
                                        <div class="priority__wrapper">
                                            <div
                                                :class="
                                                    priority_type(
                                                        activity.priority_type
                                                    )
                                                "
                                            ></div>
                                        </div>
                                        <p>{{ activity.due_date }}</p>
                                        <ul class="assignee-avatar__wrapper">
                                            <li>
                                                <img :src="avatar" alt="" />
                                            </li>
                                            <li>
                                                <img :src="avatar" alt="" />
                                            </li>
                                        </ul>
                                    </li>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>

                <DropdownMenu class="section-menu" v-if="show_taskDD_menu">
                    <template #normal>
                        <div
                            class="normal"
                            @click.prevent="toggle_activity_modal"
                        >
                            <plusIcon class="icon" />
                            <p>Add Activities</p>
                        </div>
                        <div class="normal" @click.prevent="show_task_input">
                            <editIcon class="icon" />
                            <p>Rename</p>
                        </div>
                        <div
                            class="delete"
                            @click.prevent="toggle_delete_task_modal"
                        >
                            <deleteIcon class="icon" />
                            <p>Delete</p>
                        </div>
                    </template>
                </DropdownMenu>
            </div>
        </section>
    </Workspace>
</template>

<script setup>
import Workspace from "@resource/js/Pages/Workspace/Show.vue";
import PriorityMenu from "@resource/js/Components/Dropdowns/Priority_Menu.vue";
import DropdownMenu from "@resource/js/Components/Dropdowns/Dropdown_Menu_Container.vue";

import { Link, useForm } from "@inertiajs/vue3";
import { ref, watch, computed, nextTick } from "vue";
import { useStore } from "vuex";
import axios from "axios";

/***************************
 ********** ICONS *********/
import caretDownIcon from "@public/svg/icons/caret-down.vue";
import plusIcon from "@public/svg/icons/plus.vue";
import ellipsisIcon from "@public/svg/icons/ellipsis.vue";
import starIcon from "@public/svg/icons/star.vue";
import checkIcon from "@public/svg/icons/check.vue";
import hourGlassIcon from "@public/svg/icons/hourGlass.vue";
import circleDotIcon from "@public/svg/icons/circleDot.vue";
import editIcon from "@public/svg/icons/edit.vue";
import deleteIcon from "@public/svg/icons/delete.vue";

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

// console.log(props.tasks_list);

/*****************************************
 ***** LOGIC FOR THE TASK PERCENTAGE *****
 ****************************************/

const percentage = (total, completed) => {
    if (total < 1) {
        return 0;
    } else {
        return Math.ceil((completed / total) * 100);
    }
};

const percentage_color = (total, completed) => {
    if (total < 1) {
        return "";
    } else {
        let percent_value = Math.ceil((completed / total) * 100);
        if (percent_value <= 25) {
            return "red";
        } else if (percent_value <= 50) {
            return "orange";
        } else if (percent_value <= 75) {
            return "yellow";
        } else if (percent_value > 75) {
            return "green";
        } else {
            return "";
        }
    }
};

/*****************************************
 * STORING SECTION OBJECT IN VUE STORE ***
 ****************************************/
let all_current_sections = props.all_current_sections;
store.state.sections = props.all_current_sections;

/*****************************************
 *** STORING TASKS OBJECT IN VUE STORE ***
 ****************************************/

store.state.tasks = props.tasks_list;
let current_tasks_list = store.state.tasks;

// watch(store.state.tasks, (newValue, oldValue) => {
//     console.log(current_tasks_list);
//     // current_tasks_list = newValue[0];
//     console.log("toggled");
// });

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
 ******** UPDATING STARRED STATUS ********
 ****************************************/

const update_starred = (index, section_id, task_id, val) => {
    store.state.current_task_index = index;
    store.state.task_id = task_id;
    store.state.priority_workspace_id = props.workspace_id;
    store.state.priority_collection_id = props.collection_id;
    store.state.priority_section_id = section_id;

    if (val == 0) {
        store.commit("update_starred", 1);
    } else {
        store.commit("update_starred", 0);
    }
};

/*****************************************
 *********** UPDATING TASK NAME **********
 ****************************************/

const task_form = useForm({
    task_name: "",
});

let toggle_task_input = ref(false);
let current_section_id = ref("");
let current_task_id = ref("");
let current_task_name = ref("");
let new_task_name = ref("");
let update_task_button = ref(false);

const show_task_input = async () => {
    show_taskDD_menu.value = false;

    current_section_id.value = store.state.current_task.section_id;
    current_task_id.value = store.state.current_task.task_id;
    new_task_name.value = store.state.current_task.task_name;
    current_task_name.value = store.state.current_task.task_name;

    toggle_task_input.value = true;

    await nextTick();

    document.getElementById("update_task_name").focus();
};

// DYNAMIC WATCHING INPUT CHANGES
watch(new_task_name, (newValue, oldValue) => {
    if (newValue == current_task_name.value) {
        update_task_button.value = false;
    } else {
        update_task_button.value = true;
        task_form.task_name = new_task_name;
    }
});

const update_taskName = async () => {
    try {
        const response = await axios.put(
            route("workspace.collection.section.task.update_taskName", {
                workspace: props.workspace_id,
                collection_id: props.collection_id,
                section_id: current_section_id.value,
                task_id: current_task_id.value,
            }),
            task_form
        );

        if (response.status == 200) {
            toggle_task_input.value = false;
            update_task_button.value = false;
            store.commit(
                "update_current_task_list",
                response.data.updated_task
            );
        }
    } catch (error) {
        console.log(error);
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
let active_priority_menu = ref(null);

const toggle_priority_menu = (index, section_id, task_id) => {
    store.state.priority_mode = "update_task_priority";
    store.state.current_task_index = index;
    store.state.task_id = task_id;
    store.state.priority_workspace_id = props.workspace_id;
    store.state.priority_collection_id = props.collection_id;
    store.state.priority_section_id = section_id;
    active_priority_menu.value = index;
    store.commit("showTaskPriorityMenu", true);
};

/*****************************************
 ********* TOGGLING TASK MODAL ***********
 ****************************************/
const toggle_task_modal = () => {
    active_priority_menu.value = null;
    store.state.current_section_id = props.section_data.section_id;
    store.state.selected_priority_type = null;
    store.commit("setAddTaskModalIsClose", true);
};

/*****************************************
 ***** TOGGLING TASK DROPDOWN MENU *******
 ****************************************/
let show_taskDD_menu = ref(false);
const toggle_taskDD_menu = () => {
    show_taskDD_menu.value = !show_taskDD_menu.value;
};

/*****************************************
 ************ ACTIVITIES *****************
 ****************************************/
let is_activities = ref(false);

const x = computed(() => store.state.show_activity_side);

// DYNAMIC WATCHING INPUT CHANGES
watch(x, (newValue, oldValue) => {
    if (newValue) {
        is_activities.value = true;
    } else {
        is_activities.value = false;
    }
});

const show_activities = async (index, task) => {
    show_actComplete_list.value = true;
    show_actInProgress_list.value = true;
    show_actToDo_list.value = true;

    is_activities.value = true;
    store.state.show_activity_side = true;

    store.state.priority_workspace_id = props.workspace_id;
    store.state.priority_collection_id = props.collection_id;
    store.state.current_task = task;
    store.state.current_task_index = index;

    store.commit("show_activities", task);
};

/*****************************************
 **** FETCHING ACTIVITIES FROM STORE *****
 ****************************************/
let complete_activity = computed(() => store.state.complete_activity);
let in_progress_activity = computed(() => store.state.in_progress_activity);
let to_do_activity = computed(() => store.state.to_do_activity);

/*****************************************
 ******** TOGGLING ACTIVTY MODAL *********
 ****************************************/
const toggle_activity_modal = () => {
    show_taskDD_menu.value = false;
    store.state.current_section_id = props.section_data.section_id;
    store.state.selected_priority_type = null;
    store.state.activity_status_type = null;
    store.commit("setAddActivityModalIsClose", true);
};

/*****************************************
 **** TOGGLING ACTIVTY DETAILS MODAL *****
 ****************************************/
const show_activity_details = (activity) => {
    store.commit("setActivityDetailsModalIsClose", {
        isClose: true,
        activity_details: activity,
    });
};

/*****************************************
 ****** TOGGLING DELETE TASK MODAL *******
 ****************************************/
const toggle_delete_task_modal = () => {
    show_taskDD_menu.value = false;
    store.commit("setDeleteTaskModalIsClose", true);
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

.add-tast__icon {
    @apply cursor-pointer;
}

.task__wrapper {
    @apply flex flex-col w-full max-h-full;
    /* w-[80%]  max-w-[45rem]*/
}

.task-group__wrapper {
    @apply w-full overflow-x-auto pb-[1rem] h-full;
}

/* Task Header Part */

.task-header {
    @apply flex justify-between;
}

.task-header > .icon {
    @apply cursor-pointer;
}

.section-menu {
    @apply top-[3rem] right-[1rem];
}

.task-group-header__wrapper > p {
    @apply text-xs text-neutral-500 h-full border-b-[.3px] border-neutral-300 px-[.8rem] py-[.5rem];
}

.empty_task {
    @apply flex justify-center items-center text-xs text-neutral-600 w-full h-[2.8rem] border-dashed border-[.3px] border-neutral-300 rounded-lg mt-[.5rem];
}

/* Task Data Part */

.task-group-data__wrapper {
    @apply relative;
}
.task-list__wrapper {
    @apply relative grid items-center cursor-pointer hover:bg-neutral-50;
    transition: all 0.3s ease-in-out;
}

.task-list__wrapper > * {
    @apply h-full items-center border-b-[.3px] border-neutral-300 px-[.8rem] py-[.7rem];
}

.task-name {
    @apply text-sm text-neutral-700;
}

/* Task Progress Bar */
.task-list-progress {
    @apply relative flex gap-4 items-center;
}

.task-list-progress > .base {
    @apply relative w-full h-[.4rem] bg-neutral-300 rounded-full overflow-hidden;
}

.task-list-progress > .base > .bar {
    @apply bg-blue-500 h-full rounded-full;
    /* w-[80%] */
}

.task-list-progress > .base > .bar.green {
    @apply bg-green-500;
}

.task-list-progress > .base > .bar.yellow {
    @apply bg-yellow-500;
}

.task-list-progress > .base > .bar.orange {
    @apply bg-orange-500;
}

.task-list-progress > .base > .bar.red {
    @apply bg-red-500;
}

.task-list-progress > p {
    @apply text-xs text-neutral-700 font-medium text-nowrap;
}
.priority-menu-parent__wrapper {
    @apply absolute top-0 w-full left-[7rem] max-w-[11rem] z-[1] !important;
}

/***************************************************
************* ACTIVITY RIGHT SIDE ******************
***************************************************/

.activity__wrapper {
    @apply w-[50%] max-h-full overflow-y-hidden opacity-100;
    transform: translateX(0);
    transition: all 0.3s ease-in-out;
}

.minimize {
    @apply absolute opacity-0 z-[-1];
    transform: translateX(10rem);
}

.task-header {
    @apply relative;
}

/* UPDATE FIELDS */
.input-taskName__wrapper {
    @apply absolute w-full left-0 h-[90%] flex items-center gap-2 bg-shades-white z-[2];
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
    @apply relative mb-[3rem];
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

.activity-table-nodata__wrapper {
    @apply absolute bottom-[-.8rem] text-xs text-center text-neutral-400 bg-shades-white py-[.2rem] w-full;
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
    @apply py-[.38rem] border-b-[.3px] h-full flex items-center;
}

.activity-table-list__text,
.activity-table-list__group > p {
    @apply text-sm text-neutral-700;
}

.activity_name {
    @apply cursor-pointer;
}
/* ============= */
</style>
