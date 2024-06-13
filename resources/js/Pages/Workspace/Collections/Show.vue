<template>
    <CollectionsLayout :avatar="avatar" :workspace="workspace">
        Collections Show {{ props.id }}
    </CollectionsLayout>
</template>

<script setup>
import CollectionsLayout from "@resource/js/Pages/Workspace/Collections/Index.vue";

const props = defineProps({
    id: Number,
    avatar: String,
    workspace: Array,
});
</script>
