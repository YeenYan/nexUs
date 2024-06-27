<template>
    <!-- <CollectionsLayout
        :avatar="avatar"
        :workspace="workspace"
        :all_workspaces="all_workspaces"
    >
        Collections Show {{ props.id }}
    </CollectionsLayout> -->
    <CollectionsLayout
        :avatar="props.avatar"
        :workspace="workspace"
        :all_workspaces="all_workspaces"
        :all_collections="props.all_collections"
    >
        Collections Show {{ props.id }}

        {{ props.all_collections }}
    </CollectionsLayout>
    <!-- <CollectionsLayout> Collections Show </CollectionsLayout> -->
</template>

<script setup>
import CollectionsLayout from "@resource/js/Pages/Workspace/Collections/Index.vue";

const props = defineProps({
    id: String,
    all_workspaces: Array,
    workspace: Object,
    avatar: String,
    all_collections: Array,
});
</script>
