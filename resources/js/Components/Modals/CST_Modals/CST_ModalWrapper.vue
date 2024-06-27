<template>
    <div class="CST-modal__container">
        <div class="blanket__wrapper" data-aos="show_in">
            <div></div>
        </div>

        <div class="CST-modal__wrapper" data-aos="scale_up">
            <div class="top">
                <div>
                    <CloseIcon
                        class="icon close-icon"
                        @click.prevent="close_modal"
                    />
                </div>
                <div>
                    <CollectionIcon class="icon collection-icon" />
                    <p class="top-title">
                        <slot name="title"></slot>
                    </p>
                </div>
            </div>
            <div class="bottom">
                <slot name="inputs"></slot>
                <div class="btn__wrapper">
                    <slot name="button"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import CloseIcon from "@public/svg/icons/xmark.vue";
import CollectionIcon from "@public/svg/icons/collection.vue";

import { computed, ref } from "vue";
import { useStore } from "vuex";

const store = useStore();

const isClose = computed(() => store.state.active_CST_container);

const close_modal = () => {
    store.commit("setCSTContainerisClose", false);
};
</script>

<style lang="postcss" scoped>
.CST-modal__container {
    @apply absolute top-0 flex items-center justify-center w-full h-full z-[6];
}

.blanket__wrapper {
    @apply fixed inset-0 bg-neutral-900 z-[-1];
    /* opacity-70 */
}

.CST-modal__wrapper {
    @apply bg-shades-white w-full max-w-[30rem] rounded-xl overflow-hidden z-[1] drop-shadow-xl;
}

.CST-modal__wrapper > .top,
.CST-modal__wrapper > .bottom {
    @apply p-[1.9rem] w-full;
}

/***************************************************
********************** TOP PART ********************
***************************************************/
.CST-modal__wrapper > .top {
    @apply bg-blue-50 border-b-[.3px] border-neutral-300;
}

.close-icon {
    @apply fill-neutral-400 cursor-pointer !important;
}

.CST-modal__wrapper > .top > div:first-child {
    @apply flex justify-end w-full;
}

.CST-modal__wrapper > .top > div:last-child {
    @apply flex flex-col items-center justify-center pt-[1rem] w-full;
}

.collection-icon {
    @apply max-w-[2rem] mb-[.5rem] !important;
}

.top-title {
    @apply text-xl text-neutral-600 font-medium;
}

/***************************************************
******************* BOTTOM PART ********************
***************************************************/

.CST-modal__wrapper > .bottom {
    @apply grid gap-8 bg-shades-white;
}

.bottom > .btn__wrapper :deep(button) {
    @apply max-w-full;
}
</style>
