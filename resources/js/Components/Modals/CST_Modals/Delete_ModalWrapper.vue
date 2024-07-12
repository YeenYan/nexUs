<template>
    <div class="delete-modal__container">
        <div class="blanket__wrapper" data-aos="show_in">
            <div></div>
        </div>

        <div class="delete-modal__wrapper" data-aos="scale_up">
            <div class="top__wrapper">
                <div class="trash-icon__wrapper">
                    <TrashIcon class="icon trash-icon" />
                </div>
                <p class="top-title">
                    Delete:
                    <span>
                        <!-- TITLE HERE -->
                        <slot name="title"></slot
                    ></span>
                </p>
                <div class="desc__wrapper">
                    <!-- DESCRIPTION HERE -->
                    <slot name="desc"></slot>
                </div>
            </div>
            <div class="bottom__wrapper">
                <!-- INPUT FIELDS HERE -->
                <slot name="inputs"></slot>

                <div class="btn__wrapper">
                    <!-- BUTTONS HERE -->
                    <slot name="buttons"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import TrashIcon from "@public/svg/icons/delete.vue";
</script>

<style lang="postcss" scoped>
.delete-modal__container {
    @apply absolute top-0 flex items-center justify-center w-full h-full z-[10];
}

.delete-modal__wrapper {
    @apply bg-shades-white w-full max-w-[28rem] rounded-xl overflow-hidden z-[1] drop-shadow-xl px-[2rem] py-[2rem];
}

/***************************************************
********************** TOP PART ********************
***************************************************/
.top__wrapper {
    @apply flex flex-col items-center justify-center gap-2;
}

.trash-icon__wrapper {
    @apply bg-red-100 px-[.95rem] py-[.9rem] w-fit border-[.3px] border-red-600 rounded-full;
}

.trash-icon {
    @apply fill-red-600 w-[1rem];
}

.top-title {
    @apply text-sm text-neutral-600 font-semibold;
}

.desc__wrapper {
    @apply w-[75%];
}

.desc__wrapper > :deep(p) {
    @apply text-sm text-neutral-600 text-center;
}

/***************************************************
******************* BOTTOM PART ********************
***************************************************/

.bottom__wrapper {
    /* @apply flex flex-col justify-center gap-2; */
}

.bottom__wrapper > :deep(.input__wrapper) {
    @apply my-[2rem];
}

.btn__wrapper {
    @apply flex gap-2 w-full;
}

.btn__wrapper > :deep(.btn) {
    @apply w-full max-w-full !important;
}
</style>
