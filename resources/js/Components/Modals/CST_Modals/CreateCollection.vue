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
                    {{ form.errors.collection_name }}
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
import { computed } from "vue";
import { useStore } from "vuex";

const props = defineProps({
    workspace_id: String,
    // collections: Array,
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

const create_collection = () => {
    form.post(
        route("workspace.collections.store", {
            workspace: props.workspace_id,
        })
    );
    close_modal();
};
</script>
