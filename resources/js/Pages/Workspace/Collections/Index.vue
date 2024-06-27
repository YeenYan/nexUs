<template>
    <Workspace
        :all_workspaces="props.all_workspaces"
        :avatar="props.avatar"
        :all_collections="props.all_collections"
        :collection_id="props.collection_id"
    >
        <div class="breadcrumbs-header">
            <p>Collections</p>
        </div>

        <!-- <p>Collection ID: {{ collection.collection_id }}</p>
        <p>Collection Name: {{ collection.collection_name }}</p>
        <slot></slot> -->

        <!------------------------------>
        <!------- RIGHT SIDE PART ------>
        <!------------------------------>
        <!------------------------------>
        <!------ SECTIONS SECTION ------>
        <!------------------------------>
        <section class="collection__container container">
            <div class="section__wrapper col-wrapper">
                <div class="section-header col-header__wrapper">
                    <p class="col-header-text">Sections</p>
                    <plusIcon
                        class="icon"
                        @click.prevent="toggle_section_modal"
                    />
                </div>
                <ul>
                    <li class="section-lists__wrapper">
                        <div class="section-list-name">
                            <folderIcon class="icon" />
                            <p>Section Name Here</p>
                        </div>
                        <!-- Progress bar -->
                        <div class="section-list-progress">
                            <div class="base">
                                <div class="bar"></div>
                            </div>
                            <p>65%</p>
                        </div>

                        <ellipsisIcon class="section-list-ellipsis icon" />
                    </li>
                </ul>
            </div>

            <!------------------------------>
            <!------- RIGHT SIDE PART ------>
            <!------------------------------>
            <div class="collection-info__wrapper">
                <!------------------------------>
                <!---- COLLECTION SECTION ------>
                <!------------------------------>
                <div class="collection-info-progress__wrapper col-wrapper">
                    <div>
                        <p>{{ collection.collection_name }}</p>
                        <ellipsisIcon class="icon" />
                    </div>
                    <div>
                        <div>for the progress diagram</div>
                        <p>
                            Date Created:
                            <span>{{ collection_created_at }}</span>
                        </p>
                    </div>
                </div>

                <!------------------------------>
                <!------ MEMBERS SECTION ------->
                <!------------------------------>
                <div class="collection-info-members__wrapper col-wrapper">
                    <p class="col-header-text">Members</p>
                    <ul>
                        <li>
                            <div class="member-avatar__wrapper">
                                <img :src="avatar" alt="" />
                            </div>
                            <div class="member-details__wrapper">
                                <p>Member Username Here</p>
                                <p>Member email here</p>
                            </div>
                            <p>Owner</p>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </Workspace>
</template>

<script setup>
import Workspace from "@resource/js/Pages/Workspace/Show.vue";
import { useStore } from "vuex";
/***************************
 ********** ICONS *********/
import plusIcon from "@public/svg/icons/plus.vue";
import ellipsisIcon from "@public/svg/icons/ellipsis.vue";
import folderIcon from "@public/svg/icons/folder.vue";

const props = defineProps({
    all_workspaces: Array,
    avatar: String,
    all_collections: Object,
    collection_id: String,
});

const collection = props.all_collections.find(
    (x) => x.collection_id === props.collection_id
);

// GET THE DATE ONLY
const collection_created_at = collection.created_at.split("T")[0];

/*****************************************
 ******* TOGGLING COLLECTION MODAL *******
 ****************************************/
const store = useStore();
const toggle_section_modal = () => {
    store.commit("setAddSectionModalIsClose", true);
};
</script>

<style lang="postcss" scoped>
/***************************************************
******************* SHARED STYLE *******************
***************************************************/
.col-wrapper {
    @apply bg-shades-white rounded-lg p-[1.25rem] drop-shadow-sm;
}

.col-header__wrapper {
    @apply mb-[1.5rem];
}

.col-header-text {
    @apply text-sm text-neutral-700 font-medium;
}

/***************************************************
*************** PARENT COLLECTION ******************
***************************************************/
.collection__container {
    @apply grid gap-5 bg-neutral-50 h-full pb-[7.5rem];
    grid-template-columns: 1.2fr 0.7fr;
}

/***************************************************
********************* SECTIONS *********************
***************************************************/
.section-header {
    @apply flex justify-between;
}

.section-header > .icon {
    @apply cursor-pointer;
}

.section-lists__wrapper {
    @apply grid items-center gap-5 border-[.3px] border-neutral-300 p-[.9rem] rounded-lg;
    grid-template-columns: 1fr 0.7fr 0.1fr;
}

.section-list-name {
    @apply flex gap-4;
}

.section-list-name > p {
    @apply text-sm text-neutral-700 font-medium;
}

.section-list-progress {
    @apply flex gap-4 items-center;
}

.section-list-progress > .base {
    @apply relative w-full h-[.4rem] bg-neutral-300 rounded-full overflow-hidden;
}

.section-list-progress > .base > .bar {
    @apply bg-blue-500 w-[80%] h-full rounded-full;
}

.section-list-progress > p {
    @apply text-xs text-neutral-700 font-medium;
}

.section-list-ellipsis {
    @apply justify-self-end;
}

/***************************************************
***************** COLLECTION INFO ******************
***************************************************/

/***************************************************
********************* MEMBERS **********************
***************************************************/
.collection-info-members__wrapper > .col-header-text {
    @apply mb-[1.2rem];
}

.member-avatar__wrapper {
    @apply h-[2rem] max-w-[2rem] cursor-pointer;
}

.member-avatar__wrapper {
    @apply rounded-full overflow-hidden;
}

.member-avatar__wrapper > img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
