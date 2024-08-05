<template>
    <div>
        <CreateCollection
            v-if="show_add_collection_modal"
            :workspace_id="props.workspace_id"
        />
        <CreateSection
            v-if="show_add_section_modal"
            :workspace_id="props.workspace_id"
            :collection_id="props.collection_id"
        />
        <CreateTask
            v-if="show_add_task_modal"
            :workspace_id="props.workspace_id"
            :collection_id="props.collection_id"
        />
        <CreateActivity
            v-if="show_add_activity_modal"
            :workspace_id="props.workspace_id"
            :collection_id="props.collection_id"
        />
        <DeleteCollection
            v-if="show_delete_collection_modal"
            :workspace_id="props.workspace_id"
            :collection_id="props.collection_id"
        />
        <DeleteSection
            v-if="show_delete_section_modal"
            :workspace_id="props.workspace_id"
            :collection_id="props.collection_id"
        />
        <DeleteTask
            v-if="show_delete_task_modal"
            :workspace_id="props.workspace_id"
            :collection_id="props.collection_id"
        />

        <ActivityDetails v-if="show_activity_details_modal" />

        <DeleteActivity
            v-if="show_delete_activity_modal"
            :workspace_id="props.workspace_id"
            :collection_id="props.collection_id"
        />
    </div>
</template>

<script setup>
import { computed, ref, onMounted, watch } from "vue";
import { useStore } from "vuex";

import CreateCollection from "@resource/js/Components/Modals/CST_Modals/CreateCollection.vue";
import CreateSection from "@resource/js/Components/Modals/CST_Modals/CreateSection.vue";
import CreateTask from "@resource/js/Components/Modals/CST_Modals/CreateTask.vue";
import CreateActivity from "@resource/js/Components/Modals/CST_Modals/CreateActivity.vue";
import DeleteCollection from "@resource/js/Components/Modals/CST_Modals/DeleteCollection.vue";
import DeleteSection from "@resource/js/Components/Modals/CST_Modals/DeleteSection.vue";
import DeleteTask from "@resource/js/Components/Modals/CST_Modals/DeleteTask.vue";
import DeleteActivity from "@resource/js/Components/Modals/CST_Modals/DeleteActivity.vue";
import ActivityDetails from "@resource/js/Components/Modals/CST_Modals/Activity_Details.vue";

const props = defineProps({
    workspace_id: String,
    collection_id: String,
});

const store = useStore();
/*****************************************
 ******* TOGGLING COLLECTION MODAL *******
 ****************************************/
const show_add_collection_modal = computed(
    () => store.state.active_add_collection_modal
);

const show_add_section_modal = computed(
    () => store.state.active_add_section_modal
);

const show_add_task_modal = computed(() => store.state.active_add_task_modal);

const show_add_activity_modal = computed(
    () => store.state.active_add_activity_modal
);

const show_delete_collection_modal = computed(
    () => store.state.active_delete_collection_modal
);

const show_delete_section_modal = computed(
    () => store.state.active_delete_section_modal
);

const show_delete_task_modal = computed(
    () => store.state.active_delete_task_modal
);

const show_delete_activity_modal = computed(
    () => store.state.active_delete_activity_modal
);

const show_activity_details_modal = computed(
    () => store.state.show_activity_details
);
</script>

<style lang="postcss" scoped></style>
