<template>
    <ModalWrapper>
        <template #title>Create New Collection</template>
        <template #inputs>
            <div class="input__wrapper">
                <label class="input-label">Collection Name</label>
                <div class="input__box">
                    <input
                        type="text"
                        class="input"
                        :class="
                            form.errors.collection_name ? 'input-error' : ''
                        "
                        placeholder="Enter Collection Name"
                        v-model="form.collection_name"
                    />
                    <p
                        v-if="form.errors.collection_name"
                        class="input-error_icon"
                    >
                        !
                    </p>
                </div>
                <p class="input-error_label" v-if="form.errors.collection_name">
                    {{ form.errors.collection_name[0] }}
                </p>
            </div>
        </template>
        <template #button>
            <button class="btn btn-blue" @click.prevent="create_collection">
                Save Collection
            </button>
        </template>
    </ModalWrapper>
</template>

<script setup>
import ModalWrapper from "./CST_ModalWrapper.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { computed, watch } from "vue";
import { useStore } from "vuex";
import axios from "axios";

const props = defineProps({
    workspace_id: String,
});

const form = useForm({
    collection_name: null,
});

/*****************************************
 *********** SAVING COLLECTION ***********
 ****************************************/
const store = useStore();

const close_modal = () => {
    store.commit("setCSTContainerisClose", false);
};

const create_collection = async () => {
    try {
        const response = await axios.post(
            route("workspace.collections.store", {
                workspace: props.workspace_id,
            }),
            // `form` contains the data to submit
            form
        );

        if (response.status == 200) {
            form.errors = "";
            store.commit("addCollection", response.data.current_collections);
            close_modal();
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            // form.errors = error.response.data.errors;
            if (error.response.data.errors.hasOwnProperty("collection_name")) {
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
