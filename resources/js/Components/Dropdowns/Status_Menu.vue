<template>
    <ul class="status-menu__container">
        <li class="status-menu-list" @click.prevent="set_status(2)">
            <div class="complete"></div>
            <p>Complete</p>
        </li>
        <li class="status-menu-list" @click.prevent="set_status(1)">
            <div class="inProgress"></div>
            <p>In Progress</p>
        </li>
        <li class="status-menu-list" @click.prevent="set_status(0)">
            <div class="toDo"></div>
            <p>To Do</p>
        </li>
    </ul>
</template>

<script setup>
import { useStore } from "vuex";
const store = useStore();

const set_status = (val) => {
    if (store.state.status_mode == "update_activity_status") {
        store.commit("update_activity_status_type", val);
    } else {
        store.state.status_mode = "select";
    }

    store.state.activity_status_type = val;
    store.state.activity_status_menu = false;
};
</script>

<style lang="postcss" scoped>
.status-menu__container {
    @apply bg-shades-white w-full py-[.7rem] rounded-lg drop-shadow-sm;
}

.status-menu-list {
    @apply flex gap-3 items-center px-[1rem] py-[.5rem] cursor-pointer hover:bg-neutral-50;
    transition: all 0.2s ease-in-out;
}

.status-menu-list > div {
    @apply w-[.9rem] h-[.9rem] rounded-full;
}

.status-menu-list > div.complete {
    @apply bg-green-500;
}

.status-menu-list > div.inProgress {
    @apply bg-blue-500;
}

.status-menu-list > div.toDo {
    @apply bg-tertiary-500;
}

.status-menu-list > p {
    @apply text-xs text-neutral-700;
}
</style>
