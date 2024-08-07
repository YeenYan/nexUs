<template>
    <ul class="collection-lists__wrapper">
        <li
            class="collection-list"
            v-for="collection in props.collections"
            :key="collection.collection_id"
        >
            <Link
                class="collection"
                :href="generateCollectionLink(collection.collection_id)"
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

            <!-- NESTED SECTIONS -->
            <ul
                class="section-list__container"
                v-if="props.collection_id === collection.collection_id"
            >
                <li
                    class="section-list__wrapper"
                    v-for="section in current_sections"
                    :key="section.section_id"
                >
                    <Link :href="generateSectionLink(section.section_id)">
                        <div class="section-line__wrapper">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                        <p
                            :class="
                                section.section_id === current_sec_id
                                    ? 'active'
                                    : ''
                            "
                        >
                            {{ section.section_name }}
                        </p>
                    </Link>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script setup>
import { computed, reactive, watch, ref } from "vue";
import { Link } from "@inertiajs/vue3";

import { useStore } from "vuex";

import caretDownIcon from "@public/svg/icons/caret-down.vue";
import Sections from "@resource/js/Components/Sections.vue";

const props = defineProps({
    collections: Array,
    all_workspaces: Object,
    workspace_id: String,
    collection_id: String,
    all_current_sections: Object,
});

const store = useStore();

/*****************************************
 **** COLLECTION NAVIGATION METHOD *******
 ****************************************/

const generateCollectionLink = (collectionId) => {
    const url = route("workspace.collections.index", {
        workspace: props.workspace_id,
        collection_id: collectionId,
    });
    return url;
};

/*****************************************
 ******* SECTION NAVIGATION METHOD *******
 ****************************************/

const generateSectionLink = (sectionId) => {
    const url = route("workspace.collection.sections.show", {
        workspace: props.workspace_id,
        collection_id: props.collection_id,
        section_id: sectionId,
    });
    return url;
};

/*****************************************
 * ACTIVE SECTION BASED FROM CURRENT URL *
 ****************************************/
let current_URL = window.location.pathname;
let current_sec_id = ref("");

const segments = current_URL.split("/");
current_sec_id.value = segments.pop();

/*****************************************
 * FETCHING SECTION OBJECT IN VUE STORE **
 ****************************************/
let current_sections = ref(store.state.sections);

watch(store.state.sections, (newValue, oldValue) => {
    current_sections.value = newValue;
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
</script>

<style lang="postcss" scoped>
.active {
    @apply bg-blue-100;
}

.active > .caretDown-icon {
    @apply rotate-0 !important;
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
    transition: all 0.2s ease-in-out;
}

.collection > p {
    @apply text-sm text-neutral-700;
}

.collection .caretDown-icon {
    @apply -rotate-90;
}

/***************************************************
***************** NESTED SECTIONS ******************
***************************************************/
.section-list__container {
    @apply grid;
}

.section-list__wrapper > a {
    @apply relative flex items-center;
}

.section-list__wrapper > a > p {
    @apply text-xs text-neutral-500 font-medium ml-[3.3rem] px-[.5rem] py-[.6rem] w-full rounded cursor-pointer hover:bg-neutral-100;
    transition: all 0.3s ease-in-out;
}

.section-list__wrapper > a > p.active {
    @apply bg-neutral-100 text-neutral-800;
}

.section-line__wrapper {
    @apply absolute left-0 h-full pl-[1.3rem];
}

.vertical-line {
    @apply w-[.3px] h-full bg-neutral-400;
}

.horizontal-line {
    @apply absolute top-[50%] w-[2rem] h-[.3px] bg-neutral-400;
}

.section-list__wrapper:last-child
    > a
    > .section-line__wrapper
    > .vertical-line {
    @apply h-[50%];
}
</style>
