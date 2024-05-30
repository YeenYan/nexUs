<template>
    <HomeMainLayout>
        <template #nav>
            <div class="nav__wrapper">
                <Link class="btn btn-ghost">Cancel</Link>
                <!-- :href="route('login')" -->
            </div>
        </template>
        <div class="right-bar"></div>

        <form @submit.prevent="create">
            <section class="workspace__container">
                <div class="workspace-input__wrapper">
                    <label>Name your Workspace:</label>
                    <input
                        type="text"
                        placeholder="Enter Workspace Name"
                        v-model="form.workspace_name"
                    />
                </div>

                <div class="line-divider"></div>

                <div class="workspace-avatar__container">
                    <p>Workspace Avatar:</p>
                    <div>
                        <div>
                            <div class="avatar-selection__container">
                                <div class="avatar-selection__wrapper">
                                    <img :src="imageUrl" v-if="imageUrl" />
                                    <uploadIcon
                                        class="upload-icon"
                                        v-if="!imageUrl"
                                    />
                                    <input
                                        @change="handleImageChange"
                                        type="file"
                                        class="avatar-input"
                                        accept="image/*"
                                    />
                                </div>
                            </div>
                            <label class="image-filename">{{ fileName }}</label>
                        </div>

                        <!-- AVATAR SELECTION -->
                        <div class="avatar__container">
                            <div class="avatar__group">
                                <div
                                    class="avatar__wrapper"
                                    @click="selectImage(Avatar1)"
                                >
                                    <img
                                        src="@public/avatar_images/tiger_avatar.svg"
                                        alt="avatar_1"
                                    />
                                </div>
                                <div
                                    class="avatar__wrapper"
                                    @click="selectImage(Avatar2)"
                                >
                                    <img
                                        src="@public/avatar_images/elephant_avatar.svg"
                                        alt="avatar_2"
                                    />
                                </div>
                                <div
                                    class="avatar__wrapper"
                                    @click="selectImage(Avatar3)"
                                >
                                    <img
                                        src="@public/avatar_images/duck_avatar.svg"
                                        alt="avatar_3"
                                    />
                                </div>
                                <div
                                    class="avatar__wrapper"
                                    @click="selectImage(Avatar4)"
                                >
                                    <img
                                        src="@public/avatar_images/fox_avatar.svg"
                                        alt="avatar_4"
                                    />
                                </div>
                                <div
                                    class="avatar__wrapper"
                                    @click="selectImage(Avatar5)"
                                >
                                    <img
                                        src="@public/avatar_images/lion_avatar.svg"
                                        alt="avatar_5"
                                    />
                                </div>
                            </div>
                            <div class="avatar__group">
                                <div
                                    class="avatar__wrapper"
                                    @click="selectImage(Avatar6)"
                                >
                                    <img
                                        src="@public/avatar_images/chicken_avatar.svg"
                                        alt="avatar_6"
                                    />
                                </div>
                                <div
                                    class="avatar__wrapper"
                                    @click="selectImage(Avatar7)"
                                >
                                    <img
                                        src="@public/avatar_images/dog_avatar.svg"
                                        alt="avatar_7"
                                    />
                                </div>
                                <div
                                    class="avatar__wrapper"
                                    @click="selectImage(Avatar8)"
                                >
                                    <img
                                        src="@public/avatar_images/rhino_avatar.svg"
                                        alt="avatar_8"
                                    />
                                </div>
                                <div
                                    class="avatar__wrapper"
                                    @click="selectImage(Avatar9)"
                                >
                                    <img
                                        src="@public/avatar_images/penguin_avatar.svg"
                                        alt="avatar_9"
                                    />
                                </div>
                                <div
                                    class="avatar__wrapper"
                                    @click="selectImage(Avatar10)"
                                >
                                    <img
                                        src="@public/avatar_images/giraffe_avatar.svg"
                                        alt="avatar_10"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line-divider"></div>

                <p>{{ form.errors }}</p>

                <div class="btn__wrapper">
                    <button class="btn btn-blue btn-create" type="submit">
                        Create Workspace
                    </button>
                </div>
            </section>
        </form>
    </HomeMainLayout>
</template>

<script setup>
import HomeMainLayout from "@resource/js/Layouts/HomeMainLayout.vue";
import uploadIcon from "@public/svg/upload-icon.vue";
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";

let imageUrl = ref("");
let fileName = ref("No image chosen");

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageUrl.value = e.target.result;
        };
        reader.readAsDataURL(file);
        // Set fileName to the selected file's name
        fileName.value = file.name;
    }
    console.log(file);
};

const form = useForm({
    workspace_name: null,
});

const create = () => {
    form.post(route("workspace.store"));
};
</script>

<style lang="postcss" scoped>
.workspace__container {
    @apply grid gap-10 px-[8rem] py-[4rem];
}

.workspace-input__wrapper {
    @apply grid max-w-[50%];
}

.workspace-input__wrapper > label,
.workspace-avatar__container > p {
    @apply text-base text-neutral-600 mb-[.1rem];
}

.workspace-input__wrapper > input {
    @apply text-lg text-neutral-700 outline-0 border-b-[.3px] border-neutral-300 py-[.4rem] focus:border-neutral-500;
    transition: 0.2s ease-in-out;
}

.line-divider {
    @apply w-[84%];
}

.workspace-avatar__container > div {
    @apply relative flex items-start gap-16 mt-[1rem] mb-[1.2rem];
}

.image-filename {
    @apply absolute pt-[.6rem];
}

.btn-create {
    @apply w-full max-w-[9rem];
}
</style>
