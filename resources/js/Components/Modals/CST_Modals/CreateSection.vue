<template>
    <ModalWrapper>
        <template #title>Create New Section</template>
        <template #inputs>
            <div class="input__wrapper">
                <label class="input-label">Section Name</label>
                <div class="input__box">
                    <input
                        type="text"
                        class="input"
                        :class="form.errors.section_name ? 'input-error' : ''"
                        placeholder="Enter Section Name"
                        v-model="form.section_name"
                    />
                    <p
                        v-if="form.errors.collection_name"
                        class="input-error_icon"
                    >
                        !
                    </p>
                </div>
                <p class="input-error_label" v-if="form.errors.section_name">
                    {{ form.errors.section_name[0] }}
                </p>
            </div>
        </template>
        <template #button>
            <button class="btn btn-blue" @click.prevent="create_section">
                Create Section
            </button>
        </template>
    </ModalWrapper>
</template>

<script setup>
import ModalWrapper from "./CST_ModalWrapper.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import { useStore } from "vuex";
import axios from "axios";

const props = defineProps({
    workspace_id: String,
    collection_id: String,
});

const form = useForm({
    section_name: null,
});

/*****************************************
 *********** SAVING SECTION **************
 ****************************************/
const store = useStore();

const close_modal = () => {
    store.commit("setCSTContainerisClose", false);
};

const create_section = async () => {
    try {
        const response = await axios.post(
            route("workspace.collection.sections.store", {
                workspace: props.workspace_id,
                collection_id: props.collection_id,
            }),
            // `form` contains the data to submit
            form
        );

        if (response.status == 200) {
            console.log(response.data);
            form.errors = "";
            store.commit("addSection", response.data.current_all_sections);
            close_modal();
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            // form.errors = error.response.data.errors;
            if (error.response.data.errors.hasOwnProperty("section_name")) {
                form.errors = error.response.data.errors;
            }
            // Handle errors in your form or display them to the user
        } else if (error.response) {
            // Other server errors (handle as needed)
            console.error("Server error:", error.response.data.message);
        } else {
            // Network or client-side errors
            console.error("Error creating collection:", error.message);
        }
    }
};
</script>
