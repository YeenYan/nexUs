<template>
    <Workspace
        :notifications_active="true"
        :all_workspaces="props.all_workspaces"
        :avatar="props.avatar"
        :all_collections="all_collections"
    >
        <div class="breadcrumbs-header">
            <p>Notifications</p>
        </div>
    </Workspace>
</template>

<script setup>
import Workspace from "@resource/js/Pages/Workspace/Show.vue";

const props = defineProps({
    all_workspaces: Array,
    avatar: String,
    all_collections: Object,
});
</script>
