<template>
    <ul class="collection-lists__wrapper">
        <li
            class="collection-list"
            v-for="collection in collections"
            :key="collection.collection_id"
        >
            <Link
                :href="
                    route('workspace.collections.show', {
                        id: collection.collection_id,
                    })
                "
            >
                <div
                    class="collection"
                    :class="{ active: collection.collection_id }"
                >
                    <caretDownIcon class="caretDown-icon" />
                    <p>{{ collection.collection_name }}</p>
                </div>
                <Sections :sections="collection.sections" />
            </Link>
        </li>
    </ul>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

import caretDownIcon from "@public/svg/icons/caret-down.vue";
import Sections from "@resource/js/Components/Sections.vue";

const props = defineProps({
    collections: Object,
});

const selectedCollection = null;

const toggle_active_collection = (index) => {
    this.selectedCollection = index;
};

// console.log(props.collections);
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
