<template>
    <ModalWrapper>
        <template #title>Create New Task</template>
        <template #inputs>
            <div class="input__wrapper">
                <label class="input-label">Task Name</label>
                <div class="input__box">
                    <input
                        type="text"
                        class="input"
                        :class="form.errors.task_name ? 'input-error' : ''"
                        placeholder="Enter Task Name"
                        v-model="form.task_name"
                    />
                    <p class="input-error_icon" v-if="form.errors.task_name">
                        !
                    </p>
                </div>
                <p class="input-error_label" v-if="form.errors.task_name">
                    {{ form.errors.task_name[0] }}
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
                <p
                    class="input-error_label priority-error"
                    v-if="form.errors.priority_type"
                >
                    <!--  -->
                    {{ form.errors.priority_type[0] }}
                </p>
                <div class="starred__wrapper" @click.prevent="toggle_starred">
                    <div class="starred-icon">
                        <starIcon
                            class="icon"
                            :class="starred(starred_value)"
                        />
                    </div>
                    <p>Starred</p>
                </div>
                <div
                    class="priority-menu-parent__wrapper"
                    v-if="
                        active_priority_menu &&
                        store.state.active_select_priority_menu
                    "
                >
                    <PriorityMenu />
                </div>
            </div>
        </template>
        <template #button>
            <button class="btn btn-blue" @click.prevent="create_task">
                Create Task
            </button>
        </template>
    </ModalWrapper>
</template>

<script setup>
import ModalWrapper from "./CST_ModalWrapper.vue";
import PriorityMenu from "@resource/js/Components/Dropdowns/Priority_Menu.vue";

import { Link, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { useStore } from "vuex";
import axios from "axios";

import starIcon from "@public/svg/icons/star.vue";

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
 ************ STARRED OPTION *************
 ****************************************/
let is_starred = ref(false);
let starred_value = ref(0);

const toggle_starred = () => {
    is_starred.value = !is_starred.value;

    if (is_starred.value) {
        starred_value.value = 1;
        form.starred = 1;
    } else {
        starred_value.value = 0;
        form.starred = 0;
    }
};

let starred = (val) => {
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
 ************** SAVING TASK **************
 ****************************************/
const store = useStore();

const form = useForm({
    task_name: null,
    priority_type: null,
    starred: null,
});

const close_modal = () => {
    store.commit("setCSTContainerisClose", false);
};

const create_task = async () => {
    form.priority_type = store.state.selected_priority_type;
    form.starred = starred_value.value;

    try {
        const response = await axios.post(
            route("workspace.collection.section.task.store", {
                workspace: props.workspace_id,
                collection_id: props.collection_id,
                section_id: store.state.current_section_id,
            }),
            // `form` contains the data to submit
            form
        );
        if (response.status == 200) {
            form.errors = "";
            store.commit("addTask", response.data.new_task);
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
</script>

<style lang="postcss" scoped></style>
