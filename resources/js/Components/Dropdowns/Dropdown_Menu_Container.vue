<template>
    <ul class="dropdown-menu__container">
        <li class="lists__wrapper">
            <slot name="normal"></slot>
        </li>
    </ul>
</template>

<style lang="postcss" scoped>
.dropdown-menu__container {
    @apply absolute w-full max-w-[14rem] bg-shades-white px-[.3rem] py-[1rem] rounded z-[1] drop-shadow-md;
}

.lists__wrapper > :deep(div) {
    @apply flex gap-4 px-[1rem] py-[.6rem] rounded hover:bg-blue-50 cursor-pointer;
    transition: all 0.3s ease-in-out;
}

.lists__wrapper > :deep(div > p) {
    @apply text-sm;
}

/* NORMAL */
:deep(.normal > p) {
    @apply text-neutral-600;
}

/* DELETE */
:deep(.delete > .icon) {
    @apply fill-red-500;
}

:deep(.delete > p) {
    @apply text-red-500;
}
</style>
