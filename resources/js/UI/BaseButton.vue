<template>
    <button class="btn__wrapper">
        <slot></slot>
    </button>
</template>

<style lang="postcss" scoped>
.btn__wrapper {
    @apply text-xs font-medium py-[.5rem] w-full max-w-[6rem] rounded-sm;
    transition: 0.2s ease-in-out;
}

.blue {
    @apply text-shades-white bg-blue-500 hover:bg-blue-600;
}

.ghost {
    @apply text-neutral-600 bg-transparent outline-none border-[.3px] border-neutral-400 hover:bg-neutral-100;
}
</style>
