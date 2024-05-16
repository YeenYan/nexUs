<template>
    <ul class="section-lists__wrapper">
        <li
            class="section-list"
            v-for="section in sections"
            :key="section.section_id"
        >
            <div class="section-listname">
                <circleIcon class="icon" />
                <p>{{ section.section_name }}</p>
            </div>
            <div class="section-line">
                <div></div>
                <div></div>
            </div>
        </li>
    </ul>
</template>

<script setup>
import circleIcon from "@public/svg/icons/circle.vue";

const props = defineProps({
    sections: Object,
});
</script>

<style lang="postcss" scoped>
/* SECTIONS */
.section-list {
    @apply relative ml-[1rem] cursor-pointer;
}

.section-list:hover > .section-listname {
    @apply bg-blue-100;
    transition: 0.2s ease-in-out;
}

.section-listname {
    @apply flex gap-3 ml-[1.5rem] px-[1rem] py-[.7rem] rounded;
}

.section-listname > p {
    @apply text-sm text-neutral-700;
}

.section-line {
    @apply absolute top-0 left-[.4rem] w-full h-full;
}

.section-line > div:first-child {
    @apply absolute top-[50%] w-[1rem] h-[.3px] bg-neutral-500;
}

.section-line > div:last-child {
    @apply absolute w-[.3px] h-[50%] bg-neutral-500;
}

/* LINE FOR THE BETWEEN SECTION */
.section-list:not(:first-child):not(:last-child)
    > .section-line
    > div:last-child {
    @apply top-[-50%] h-[150%];
}

.section-list:nth-child(2) .section-line > div:last-child {
    @apply h-[100%] top-[-50%];
}
</style>
