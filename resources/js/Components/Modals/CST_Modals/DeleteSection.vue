<template>
    <DeleteModalWrapper>
        <template #title>{{ section_name }}</template>
        <template #desc>
            <p>
                <span>5</span>
                tasks and
                <span>10</span>
                activities within this Section will be deleted.
            </p>
        </template>
        <template #inputs>
            <div class="input__wrapper">
                <label class="input-label"
                    >Type the Section name to proceed</label
                >
                <div class="input__box">
                    <input
                        v-model="new_section_name"
                        type="text"
                        class="input"
                        placeholder="Enter Section Name"
                    />
                </div>
            </div>
        </template>
        <template #buttons>
            <button
                class="btn btn-ghost"
                @click.prevent="close_delete_section_modal"
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
const close_delete_section_modal = () => {
    store.commit("setDeleteSectionModalIsClose", false);
};

/*****************************************
 *********** DELETING SECTION ************
 ****************************************/

let section_name = ref();
let new_section_name = ref();
let active_delete_btn = ref(false);

let current_sectionID = ref(store.state.current_section_id);
let current_sectionName = ref(store.state.current_section_name);

section_name.value = current_sectionName.value;

watch(new_section_name, (newVal) => {
    if (newVal == section_name.value) {
        active_delete_btn.value = true;
    } else {
        active_delete_btn.value = false;
    }
});

const delete_section = async () => {
    try {
        const response = await axios.delete(
            route("workspace.collection.sections.destroy", {
                workspace: props.workspace_id,
                collection_id: props.collection_id,
                section: current_sectionID.value,
            })
        );
        if (response.status == 200) {
            console.log("deleted");
            store.commit("addSection", response.data.current_all_sections);
            store.commit("setDeleteSectionModalIsClose", false);
        }
    } catch (error) {
        console.log(error);
    }
};
</script>
