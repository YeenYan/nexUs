<template>
    <Workspace
        :members_active="true"
        :all_workspaces="props.all_workspaces"
        :avatar="props.avatar"
        :all_collections="props.all_collections"
    >
        <div class="breadcrumbs-header">
            <p>Members</p>
        </div>

        <section class="container">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Inventore, iste!
            </p>
        </section>
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
