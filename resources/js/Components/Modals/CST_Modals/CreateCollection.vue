<template>
    <ModalWrapper :is_close="false">
        <template #title>Create New Collection</template>
        <template #inputs>
            <div class="input__wrapper">
                <label class="input-label">Collection Name</label>
                <div class="input__box">
                    <input
                        type="text"
                        class="input"
                        placeholder="Enter Collection Name"
                        v-model="form.collection_name"
                    />
                    <p class="input-error_icon">!</p>
                </div>
                <p class="input-error_label">Validation text here</p>
            </div>
            <p>{{ form.errors }}</p>
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

const form = useForm({
    collection_name: null,
});

const create_collection = () => {
    form.post(route("workspace.collections.store"));
};
</script>

<style lang="postcss" scoped></style>
