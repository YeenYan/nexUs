<template>
    <ul class="collection-lists__wrapper">
        <li
            class="collection-list"
            v-for="collection in props.collections"
            :key="collection.collection_id"
        >
            <Link
                class="collection"
                :href="
                    route('workspace.collections.index', {
                        workspace: workspace_id,
                        collection_id: collection.collection_id,
                    })
                "
                :class="
                    props.collection_id === collection.collection_id
                        ? 'active'
                        : ''
                "
            >
                <!-- collection_id: collection.collection_id, -->
                <!-- view: collection.view_id -->
                <caretDownIcon class="caretDown-icon" />
                <p>{{ collection.collection_name }}</p>
            </Link>
        </li>
    </ul>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { computed, reactive, watch, ref } from "vue";

import caretDownIcon from "@public/svg/icons/caret-down.vue";
import Sections from "@resource/js/Components/Sections.vue";

const props = defineProps({
    collections: Array,
    all_workspaces: Object,
    collection_id: String,
});

/**************************************
 * Fetching single Active workspace
 *************************************/
const active_workspaces = props.all_workspaces.filter((e) => e.active == 1);

let workspace_id;
let workspace_name;
let workspace_avatar;
for (let i in active_workspaces) {
    workspace_id = active_workspaces[i].workspace_id;
    workspace_name = active_workspaces[i].workspace_name;
    workspace_avatar = active_workspaces[i].avatar;
}

/**************************************
 * SET ACTIVE COLLECTION
 *************************************/
</script>

<style lang="postcss" scoped>
.active {
    @apply bg-blue-100;
}

.active > .icon {
    @apply fill-blue-600;
}

.active > p {
    @apply text-blue-600 font-medium !important;
}

.collection-lists__wrapper {
    @apply px-[.8rem];
}

.collection-header__wrapper {
    @apply flex items-center justify-between px-[1.5rem] py-[.7rem];
}

.collection-header__wrapper > p {
    @apply text-sm font-medium text-neutral-700;
}

.collection-list {
    @apply grid w-full;
}

.collection {
    @apply flex gap-5 w-full pl-[1rem] py-[.7rem] hover:bg-blue-100 rounded cursor-pointer;
    transition: 0.2s ease-in-out;
}

.collection > p {
    @apply text-sm text-neutral-700;
}

.collection .caretDown-icon {
    @apply -rotate-90;
}
</style>
