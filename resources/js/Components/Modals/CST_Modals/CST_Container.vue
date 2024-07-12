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
    </div>
    <!-- :collections="props.all_collections" -->
</template>

<script setup>
import { computed, ref, onMounted, watch } from "vue";
import { useStore } from "vuex";

import CreateCollection from "@resource/js/Components/Modals/CST_Modals/CreateCollection.vue";
import CreateSection from "@resource/js/Components/Modals/CST_Modals/CreateSection.vue";
import DeleteCollection from "@resource/js/Components/Modals/CST_Modals/DeleteCollection.vue";
import DeleteSection from "@resource/js/Components/Modals/CST_Modals/DeleteSection.vue";

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

const show_delete_collection_modal = computed(
    () => store.state.active_delete_collection_modal
);

const show_delete_section_modal = computed(
    () => store.state.active_delete_section_modal
);
</script>

<style lang="postcss" scoped></style>
