<template>
    <DeleteModalWrapper>
        <template #title>{{ current_task.task_name }}</template>
        <template #desc>
            <p>
                <span>{{ current_task.total_activities }}</span>
                activities within this Task will be deleted.
            </p>
        </template>
        <template #inputs>
            <div class="input__wrapper">
                <label class="input-label">Type the Task name to proceed</label>
                <div class="input__box">
                    <input
                        v-model="new_task_name"
                        type="text"
                        class="input"
                        placeholder="Enter Task Name"
                    />
                </div>
            </div>
        </template>
        <template #buttons>
            <button
                class="btn btn-ghost"
                @click.prevent="close_delete_task_modal"
            >
                Cancel
            </button>
            <button
                class="btn"
                @click.prevent="delete_section"
                :disabled="!active_delete_btn"
                :class="active_delete_btn ? 'btn-red' : 'btn-ghost'"
            >
                Delete
            </button>
        </template>
    </DeleteModalWrapper>
</template>

<script setup>
import DeleteModalWrapper from "./Delete_ModalWrapper.vue";

import { computed, ref, onMounted, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useStore } from "vuex";
import axios from "axios";

const store = useStore();

const props = defineProps({
    workspace_id: String,
    collection_id: String,
});

/*****************************************
 ***** TOGGLING DELETE SECTION MODAL *****
 ****************************************/
const close_delete_task_modal = () => {
    store.commit("setDeleteTaskModalIsClose", false);
};

/*****************************************
 *********** DELETING SECTION ************
 ****************************************/

let blank_name = ref();
let new_task_name = ref();
let active_delete_btn = ref(false);

let current_task = store.state.current_task;
blank_name.value = store.state.current_task.task_name;

watch(new_task_name, (newVal) => {
    if (newVal == blank_name.value) {
        active_delete_btn.value = true;
    } else {
        active_delete_btn.value = false;
    }
});

const delete_section = async () => {
    try {
        const response = await axios.delete(
            route("workspace.collection.section.task.destroy", {
                workspace: props.workspace_id,
                collection_id: props.collection_id,
                section_id: current_task.section_id,
                task: current_task.task_id,
            })
        );
        if (response.status == 200) {
            store.state.show_activity_side = false;
            store.commit("delete_task_in_list");
            store.commit("setDeleteTaskModalIsClose", false);
        }
    } catch (error) {
        console.log(error);
    }
};
</script>
