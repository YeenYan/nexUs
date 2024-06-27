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
                    {{ form.errors.section_name }}
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

const create_section = () => {
    form.post(
        route("workspace.collections.store", {
            workspace: props.workspace_id,
        })
    );
    close_modal();
};
</script>
