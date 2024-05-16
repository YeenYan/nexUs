<template>
    <CollectionsLayout> Collections Show {{ props.id }} </CollectionsLayout>
</template>

<script setup>
import CollectionsLayout from "@resource/js/Pages/Workspace/Collections/Index.vue";

const props = defineProps({
    id: Number,
});
</script>
