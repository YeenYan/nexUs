<template>
    <HomeMainLayout>
        <template #nav>
            <div class="nav__wrapper">
                <!-- <Link class="btn btn-ghost" :href="route('workspace.index')"
                    >Cancel</Link
                > -->
                <button class="btn btn-ghost" @click="goBack">Cancel</button>
                <!-- :href="route('login')" -->
            </div>
        </template>
        <div class="right-bar"></div>

        <form @submit.prevent="create">
            <section class="workspace__container">
                <div class="workspace-input__wrapper">
                    <label>Name your Workspace:</label>
                    <div class="input__box">
                        <input
                            class="input workspace-input"
                            :class="
                                form.errors.workspace_name ? 'input-error' : ''
                            "
                            type="text"
                            placeholder="Enter Workspace Name"
                            v-model="form.workspace_name"
                        />
                        <p
                            v-if="form.errors.workspace_name"
                            class="input-error_icon"
                        >
                            !
                        </p>
                    </div>
                    <p
                        v-if="form.errors.workspace_name"
                        class="input-error_label"
                    >
                        {{ form.errors.workspace_name }}
                    </p>
                </div>

                <div class="line-divider"></div>

                <div class="workspace-avatar__container">
                    <p>Workspace Avatar:</p>
                    <div>
                        <div>
                            <div
                                class="avatar-selection__container"
                                :class="
                                    form.errors.avatar ? 'avatar-error' : ''
                                "
                            >
                                <div class="avatar-selection__wrapper">
                                    <img :src="imageUrl" v-if="imageUrl" />
                                    <uploadIcon
                                        class="upload-icon"
                                        v-if="!imageUrl"
                                    />
                                    <input
                                        @change="handleImageChange"
                                        @input="handleImageChange"
                                        type="file"
                                        class="avatar-input"
                                        accept="image/*"
                                    />
                                </div>
                            </div>
                            <p class="input-error_label">
                                {{ form.errors.avatar }}
                            </p>
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
// Image Avatars
import Avatar1 from "@public/avatar_images/tiger_avatar.svg";
import Avatar2 from "@public/avatar_images/elephant_avatar.svg";
import Avatar3 from "@public/avatar_images/duck_avatar.svg";
import Avatar4 from "@public/avatar_images/fox_avatar.svg";
import Avatar5 from "@public/avatar_images/lion_avatar.svg";
import Avatar6 from "@public/avatar_images/chicken_avatar.svg";
import Avatar7 from "@public/avatar_images/dog_avatar.svg";
import Avatar8 from "@public/avatar_images/rhino_avatar.svg";
import Avatar9 from "@public/avatar_images/penguin_avatar.svg";
import Avatar10 from "@public/avatar_images/giraffe_avatar.svg";

const props = defineProps({
    user: Object,
});

let imageUrl = ref("");
let fileName = ref("No image chosen");

/*****************************************
 *********** FORM SUBMISSION *************
 ****************************************/

const form = useForm({
    workspace_name: null,
    avatar: null,
});

const create = () => {
    form.post(route("workspace.store"));
};

/*****************************************
 ** SELECTING IMAGE FROM LOCAL MACHINE ***
 ****************************************/
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageUrl.value = e.target.result;
        };
        reader.readAsDataURL(file);

        // Update fileName and form.avatar
        fileName = file.name;
        form.avatar = file;
    }
};

/*****************************************
 ********* SELECTING AVATAR IMAGE ********
 ****************************************/
let selectImage = async (url) => {
    try {
        // Fetch the image content from the URL
        const response = await fetch(url);
        const blob = await response.blob();

        // Getting the filename for the selected avatar
        const filename = url.substring(url.lastIndexOf("/") + 1);
        const avatarName = filename.split(".")[0];
        const fileExtension = "svg";

        fileName = filename;

        // Create a File object with the fetched blob
        const file = new File([blob], `${avatarName}.${fileExtension}`, {
            type: blob.type, // MIME type from the fetched blob
            lastModified: Date.now(), // Current timestamp
        });

        // Assign the File object to the form
        form.avatar = file;

        // If you have an image preview element, you can set its source to display the selected image
        if (imageUrl) {
            imageUrl.value = URL.createObjectURL(file);
        }
    } catch (error) {
        console.error("Error fetching the image:", error);
    }
};

const goBack = () => {
    window.history.back();
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

.workspace-input {
    @apply text-lg text-neutral-700 outline-0 border-b-[.3px] border-neutral-300 py-[1rem] focus:border-neutral-500;
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
