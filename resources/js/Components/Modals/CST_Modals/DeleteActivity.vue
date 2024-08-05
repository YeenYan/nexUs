<template>
    <DeleteModalWrapper>
        <template #title>{{ current_activity.activity_name }}</template>
        <template #desc>
            <p>
                All the information within this activity will be deleted
                permanently.
            </p>
        </template>

        <template #buttons>
            <button
                class="btn btn-ghost"
                @click.prevent="close_delete_activity_modal"
            >
                Cancel
            </button>
            <button class="btn btn-red" @click.prevent="delete_activity">
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
const close_delete_activity_modal = () => {
    store.commit("setDeleteActivityModalIsClose", false);
};

/*****************************************
 *********** DELETING SECTION ************
 ****************************************/

let current_activity = store.state.current_activity_details;

const delete_activity = async () => {
    store.commit("delete_activity");
};
</script>

<style lang="postcss" scoped>
:deep(.delete-modal__wrapper) {
    @apply max-w-[25rem];
}

:deep(.btn__wrapper) {
    @apply mt-[1.5rem];
}
</style>
