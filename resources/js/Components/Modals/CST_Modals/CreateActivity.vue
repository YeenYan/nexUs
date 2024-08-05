<template>
    <ModalWrapper>
        <template #title>Create New Activity</template>
        <template #inputs>
            <div class="input__wrapper">
                <label class="input-label">Activity Name</label>
                <div class="input__box">
                    <input
                        type="text"
                        class="input"
                        :class="form.errors.activity_name ? 'input-error' : ''"
                        placeholder="Enter Activity Name"
                        v-model="form.activity_name"
                    />
                    <p
                        class="input-error_icon"
                        v-if="form.errors.activity_name"
                    >
                        !
                    </p>
                </div>
                <p class="input-error_label" v-if="form.errors.activity_name">
                    {{ form.errors.activity_name[0] }}
                </p>
            </div>
            <div class="input__wrapper">
                <label class="input-label">Description</label>
                <div class="input__box">
                    <textarea
                        type="text"
                        class="input"
                        :class="form.errors.descrtiption ? 'input-error' : ''"
                        placeholder="Enter Description"
                        v-model="form.description"
                    />
                    <p class="input-error_icon" v-if="form.errors.description">
                        !
                    </p>
                </div>
                <p class="input-error_label" v-if="form.errors.description">
                    {{ form.errors.description[0] }}
                </p>
            </div>
            <div class="task-option__wrapper">
                <div
                    class="priority__wrapper with-text"
                    :class="
                        form.errors.priority_type
                            ? 'priority-error__wrapper'
                            : ''
                    "
                    @click.prevent="toggle_priority_menu"
                >
                    <div
                        :class="
                            priority_type_color(
                                store.state.selected_priority_type
                            )
                        "
                    ></div>
                    <p>
                        {{
                            priority_type_text(
                                store.state.selected_priority_type
                            )
                        }}
                    </p>
                </div>
                <!-- <p
                    class="input-error_label priority-error"
                    v-if="form.errors.priority_type"
                >
                    {{ form.errors.priority_type[0] }}
                </p> -->
                <div
                    class="priority-menu-parent__wrapper"
                    v-if="
                        active_priority_menu &&
                        store.state.active_select_priority_menu
                    "
                >
                    <PriorityMenu />
                </div>
                <div
                    class="due-date__wrapper"
                    :class="form.errors.due_date ? 'input-error' : ''"
                >
                    <dateIcon class="icon" />
                    <p>{{ formatted_date }}</p>
                    <input
                        type="date"
                        class="due-date"
                        v-model="selectedDate"
                        @input="updateDateLabel"
                    />
                </div>
                <div class="assignee__wrapper">
                    <plusIcon class="icon" />
                    <p>Assignee</p>
                </div>
                <div class="status__container">
                    <div
                        class="status__wrapper complete"
                        v-if="store.state.activity_status_type == 2"
                        @click.prevent="store.state.activity_status_menu = true"
                    >
                        <checkIcon class="status-icon complete" />
                        <p>Complete</p>
                    </div>
                    <div
                        class="status__wrapper inProgress"
                        v-if="store.state.activity_status_type == 1"
                        @click.prevent="store.state.activity_status_menu = true"
                    >
                        <hourGlassIcon class="status-icon inProgress" />
                        <p>In Progress</p>
                    </div>
                    <div
                        class="status__wrapper toDo"
                        v-if="store.state.activity_status_type == 0"
                        @click.prevent="store.state.activity_status_menu = true"
                    >
                        <circleDotIcon class="status-icon toDo" />
                        <p>To Do</p>
                    </div>
                    <div
                        class="status-type__wrapper"
                        :class="form.errors.status_type ? 'input-error' : ''"
                        v-if="store.state.activity_status_type == null"
                        @click.prevent="toggle_status_menu"
                    >
                        <circleDotIcon class="status-icon default" />
                        <p>Status Type</p>
                    </div>
                    <div
                        class="status-menu-parent__wrapper"
                        v-if="store.state.activity_status_menu"
                    >
                        <StatusMenu />
                    </div>
                </div>
            </div>
        </template>
        <template #button>
            <button class="btn btn-blue" @click.prevent="create_task">
                Create Activity
            </button>
        </template>
    </ModalWrapper>
</template>

<script setup>
import ModalWrapper from "./CST_ModalWrapper.vue";
import PriorityMenu from "@resource/js/Components/Dropdowns/Priority_Menu.vue";
import StatusMenu from "@resource/js/Components/Dropdowns/Status_Menu.vue";

import { Link, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { useStore } from "vuex";
import axios from "axios";

/***************************
 ********** ICONS *********/
import starIcon from "@public/svg/icons/star.vue";
import dateIcon from "@public/svg/icons/date.vue";
import plusIcon from "@public/svg/icons/plus.vue";
import checkIcon from "@public/svg/icons/check.vue";
import hourGlassIcon from "@public/svg/icons/hourGlass.vue";
import circleDotIcon from "@public/svg/icons/circleDot.vue";

const props = defineProps({
    workspace_id: String,
    collection_id: String,
});

/*****************************************
 ************ PRIORITY MENU **************
 ****************************************/

let active_priority_menu = ref(false);
const toggle_priority_menu = () => {
    store.state.priority_mode = "select";
    active_priority_menu.value = true;
    store.commit("showSelectPriorityMenu", true);
};

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

/*****************************************
 ********** STATUS TYPE MENU *************
 ****************************************/
let active_status_menu = computed(() => {
    return store.state.activity_status_menu;
});

const toggle_status_menu = () => {
    store.state.activity_status_menu = true;
    store.state.status_mode = "select";
};

/*****************************************
 ************** SAVING TASK **************
 ****************************************/
const store = useStore();

const form = useForm({
    activity_name: null,
    status_type: null,
    priority_type: null,
    due_date: null,
    description: null,
});

const close_modal = () => {
    store.commit("setCSTContainerisClose", false);
};

const create_task = async () => {
    form.status_type = store.state.activity_status_type;
    form.priority_type = store.state.selected_priority_type;
    form.due_date = date_value.value;

    try {
        const response = await axios.post(
            route("workspace.collection.section.task.activity.store", {
                workspace: props.workspace_id,
                collection_id: props.collection_id,
                section_id: store.state.current_section_id,
                task_id: store.state.current_task.task_id,
            }),
            form
        );
        if (response.status == 200) {
            form.errors = "";
            store.commit("filter_activity_status", [
                response.data.new_activity,
            ]);
            store.commit("add_count_to_task", response.data.single_task);
            close_modal();
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            form.errors = error.response.data.errors;
            // Handle errors in your form or display them to the user
        } else if (error.response) {
            // Other server errors (handle as needed)
            console.error("Server error:", error.response.data.message);
        } else {
            // Network or client-side errors
            console.error("Error creating task:", error.message);
        }
    }
};

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
</script>

<style lang="postcss" scoped>
:deep(.CST-modal__wrapper) {
    @apply max-w-[35rem];
}

.priority-menu-parent__wrapper {
    @apply z-[3];
}

.due-date[data-v-2c9ef109] {
    @apply absolute w-full outline-none border-none focus:outline-none opacity-0;
}

.assignee__wrapper {
    @apply relative grid items-center gap-2 w-fit overflow-hidden;
    grid-template-columns: 1rem 1fr;
}

.assignee__wrapper > .icon {
    @apply w-[.8rem] fill-neutral-500;
}

.status__wrapper {
    @apply h-full cursor-pointer;
}

.status-menu-parent__wrapper {
    @apply absolute top-[-2rem] right-0 w-full max-w-[11rem] z-[4];
}
</style>
