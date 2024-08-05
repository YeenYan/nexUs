<template>
    <ul class="priority-menu__container">
        <li class="priority-menu-list" @click.prevent="set_priority(3)">
            <div class="priority-menu__wrapper urgent">
                <div></div>
            </div>
            <p>Urgent</p>
        </li>
        <li class="priority-menu-list" @click.prevent="set_priority(2)">
            <div class="priority-menu__wrapper high">
                <div></div>
            </div>
            <p>High</p>
        </li>
        <li class="priority-menu-list" @click.prevent="set_priority(1)">
            <div class="priority-menu__wrapper normal">
                <div></div>
            </div>
            <p>Normal</p>
        </li>
        <li class="priority-menu-list" @click.prevent="set_priority(0)">
            <div class="priority-menu__wrapper low">
                <div></div>
            </div>
            <p>Low</p>
        </li>
    </ul>
</template>

<script setup>
import { useStore } from "vuex";
const store = useStore();

const set_priority = (val) => {
    store.state.selected_priority_type = val;

    if (store.state.priority_mode == "update_task_priority") {
        store.commit("update_task_priority_type", val);
        store.commit("showTaskPriorityMenu", false);
    } else if (store.state.priority_mode == "update_activity_priority") {
        store.commit("update_activity_priority_type", val);
        store.commit("showActivityPriorityMenu", false);
    }
    store.commit("showSelectPriorityMenu", false);
    store.commit("showTaskPriorityMenu", false);
    store.commit("showActivityPriorityMenu", false);
};
</script>

<style lang="postcss" scoped>
.priority-menu__container {
    @apply bg-shades-white w-full py-[.7rem] rounded-lg drop-shadow-sm;
}

.priority-menu__wrapper {
    @apply flex items-center justify-center;
}

.priority-menu-list {
    @apply flex gap-3 px-[1rem] py-[.5rem] cursor-pointer hover:bg-neutral-50;
    transition: all 0.2s ease-in-out;
}

.priority-menu-list > p {
    @apply text-xs text-neutral-700;
}

.priority-menu__wrapper > div {
    @apply w-[.9rem] h-[.9rem] rounded-full cursor-pointer;
}

.priority-menu__wrapper.urgent > div {
    @apply bg-red-500;
}

.priority-menu__wrapper.high > div {
    @apply bg-orange-500;
}

.priority-menu__wrapper.normal > div {
    @apply bg-blue-500;
}

.priority-menu__wrapper.low > div {
    @apply bg-tertiary-500;
}
</style>
