<template>
    <Workspace :avatar="props.avatar" :workspace="workspace">
        <div class="breadcrumbs-header">
            <p>Collections</p>
        </div>

        <slot></slot>
    </Workspace>
</template>

<script setup>
import Workspace from "@resource/js/Pages/Workspace/Index.vue";

const props = defineProps({
    avatar: String,
    workspace: Array,
});
</script>
