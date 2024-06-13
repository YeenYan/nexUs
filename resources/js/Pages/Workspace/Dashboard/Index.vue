<template>
    <Workspace
        :dashboard_active="true"
        :all_workspaces="props.all_workspaces"
        :workspace="props.workspace"
        :avatar="props.avatar"
    >
        <div class="breadcrumbs-header">
            <p>Dashboard</p>
        </div>
    </Workspace>
</template>

<script setup>
import Workspace from "@resource/js/Pages/Workspace/Show.vue";

const props = defineProps({
    all_workspaces: Array,
    workspace: Object,
    avatar: String,
});
</script>
