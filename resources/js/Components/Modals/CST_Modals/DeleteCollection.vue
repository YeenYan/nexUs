<template>
    <DeleteModalWrapper>
        <template #title>{{ col_name }}</template>
        <template #desc>
            <p>
                <span>7</span>
                sections
                <span>5</span>
                tasks and
                <span>10</span>
                activities within this Collection will be deleted.
            </p>
        </template>
        <template #inputs>
            <div class="input__wrapper">
                <label class="input-label"
                    >Type the Collection name to proceed</label
                >
                <div class="input__box">
                    <input
                        v-model="new_col_name"
                        type="text"
                        class="input"
                        placeholder="Enter Collection Name"
                    />
                </div>
            </div>
        </template>
        <template #buttons>
            <button
                class="btn btn-ghost"
                @click.prevent="close_delete_collection_modal"
            >
                Cancel
            </button>
            <button
                class="btn"
                @click.prevent="delete_collection"
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
const close_delete_collection_modal = () => {
    store.commit("setDeleteCollectionModalIsClose", false);
};

/*****************************************
 *********** DELETING COLLECTION ************
 ****************************************/

let col_name = ref("");
let new_col_name = ref("");
let active_delete_btn = ref(false);

let current_colName = ref(store.state.current_col_name);

col_name.value = current_colName.value;

watch(new_col_name, (newVal) => {
    if (newVal == col_name.value) {
        active_delete_btn.value = true;
    } else {
        active_delete_btn.value = false;
    }
});

const delete_collection = async () => {
    try {
        const response = await axios.delete(
            route("workspace.collections.destroy", {
                workspace: props.workspace_id,
                collection: props.collection_id,
            })
        );
        if (response.status == 200) {
            store.commit("addCollection", response.data.current_collections);
            store.commit("setDeleteCollectionModalIsClose", false);

            redirect_to_other_collection(response.data.current_collections);
        }
    } catch (error) {
        console.log(error);
    }
};

const redirect_to_other_collection = (data) => {
    const collections = data;
    // const currentUrl = window.location.origin + window.location.pathname;

    // Extract the workspace_id from the current URL
    const pathSegments = window.location.pathname.split("/");
    const workspaceId = pathSegments[1]; // Assuming workspace_id is the first segment after the root

    if (collections && collections.length > 0) {
        const collectionId = collections[0].collection_id;
        // Construct the new URL for the next collection
        const newUrl = `${window.location.origin}/${workspaceId}/${collectionId}`;
        // Redirect to the new URL
        window.location.href = newUrl;
    } else {
        // If no collections are available, redirect to the dashboard
        const dashboardUrl = `${window.location.origin}/${workspaceId}/dashboard`;
        window.location.href = dashboardUrl;
    }
};
</script>
