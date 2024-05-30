<template>
    <HomeMainLayout>
        <template #nav>
            <div class="nav__wrapper">
                <p class="nav-text">Already have an account?</p>
                <Link :href="route('login')" class="btn btn-ghost btn-login"
                    >Log in</Link
                >
            </div>
        </template>
        <div class="right-bar"></div>

        <form @submit.prevent="register">
            <div class="signup__wrapper">
                <div class="input__container">
                    <div class="signup__header">
                        <p>Sign up</p>
                        <p>and begin using NexUs!</p>
                    </div>

                    <div class="input__wrapper">
                        <label for="username" class="input-label"
                            >Username</label
                        >
                        <div class="input__box">
                            <input
                                id="username"
                                class="input"
                                :class="
                                    form.errors.username ? 'input-error' : ''
                                "
                                type="text"
                                placeholder="Enter your username"
                                v-model="form.username"
                            />
                            <p
                                v-if="form.errors.username"
                                class="input-error_icon"
                            >
                                !
                            </p>
                        </div>
                        <p
                            v-if="form.errors.username"
                            class="input-error_label"
                        >
                            {{ form.errors.username }}
                        </p>
                    </div>

                    <div class="input__wrapper">
                        <label for="email" class="input-label">Email</label>
                        <div class="input__box">
                            <input
                                id="email"
                                class="input"
                                :class="form.errors.email ? 'input-error' : ''"
                                type="email"
                                placeholder="Enter your email"
                                v-model="form.email"
                            />
                            <p
                                v-if="form.errors.email"
                                class="input-error_icon"
                            >
                                !
                            </p>
                        </div>
                        <p v-if="form.errors.email" class="input-error_label">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div class="input__wrapper">
                        <label for="password" class="input-label"
                            >Create Password</label
                        >
                        <div class="input__box">
                            <input
                                id="password"
                                class="input"
                                :class="
                                    form.errors.password ? 'input-error' : ''
                                "
                                type="password"
                                placeholder="Enter your password"
                                v-model="form.password"
                            />
                            <p
                                v-if="form.errors.password"
                                class="input-error_icon"
                            >
                                !
                            </p>
                        </div>
                        <p
                            v-if="form.errors.password"
                            class="input-error_label"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div class="input__wrapper">
                        <label for="password_confirmation" class="input-label"
                            >Confirm Password</label
                        >
                        <div class="input__box">
                            <input
                                id="password_confirmation"
                                class="input"
                                type="password"
                                placeholder="Confirm password"
                                v-model="form.password_confirmation"
                            />
                        </div>
                    </div>

                    <div class="btn__wrapper">
                        <button class="btn btn-blue" type="submit">
                            Create Account
                        </button>
                    </div>
                </div>

                <!-- <input
                    type="file"
                    name="avatar"
                    @change="handleImageChange"
                    @input="handleImageChange"
                />
                <p>{{ form.errors.avatar }}</p> -->
                <!-- IMAGE SELECTION -->
                <div class="image__container">
                    <p class="input-label">Choose Avatar</p>
                    <div class="avatar-selection__container">
                        <div class="avatar-selection__wrapper">
                            <img :src="imageUrl" v-if="imageUrl" />
                            <uploadIcon class="upload-icon" v-if="!imageUrl" />
                            <input
                                type="file"
                                name="avatar"
                                @change="handleImageChange"
                                @input="handleImageChange"
                                class="avatar-input"
                            />
                            <!-- 
                                accept="image/*" -->
                        </div>
                    </div>
                    <p>{{ form.errors.avatar }}</p>
                    <label class="image-filename">{{ fileName }}</label>

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
        </form>
    </HomeMainLayout>
</template>

<script setup>
import HomeMainLayout from "@resource/js/Layouts/HomeMainLayout.vue";
import uploadIcon from "@public/svg/upload-icon.vue";
import { ref, onMounted } from "vue";
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

let imageUrl = ref("");
let fileName = ref("No image chosen");

/*****************************************
 *********** FORM SUBMISSION *************
 ****************************************/

const form = useForm({
    username: "user",
    email: "user@user.com",
    password: "12345678",
    password_confirmation: "12345678",
    avatar: null,
});

const register = () => {
    console.log(form.avatar);
    form.post(route("user-account.store"));
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
        fileName.value = file.name;
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

// onMounted(() => {
//     imageUrl.value = "http://[::1]:5173/public/avatar_images/tiger_avatar.svg";
// });

// const create = () => {
//     console.log(imageUrl.value);
// };
</script>

<style lang="postcss" scoped>
.signup__wrapper {
    @apply grid gap-20 px-[8rem] py-[3rem];
    grid-template-columns: 1fr 1.2fr;
}

.signup__header {
    @apply mb-[1rem];
}

.signup__header p:first-child {
    @apply text-lg font-semibold text-neutral-700;
}

.signup__header p:last-child {
    @apply text-sm text-neutral-700;
}

.input__container {
    @apply grid gap-5;
}

.btn__wrapper {
    @apply mt-[1rem];
}

.btn {
    @apply px-[1rem] max-w-fit;
}

/* IMAGE / AVATAR */
.image__container {
    @apply mt-[5rem];
}

.image__container > p {
    @apply mb-[1rem];
}

.avatar__container {
    @apply mt-[2rem];
}

.btn-login {
    @apply w-full max-w-[6rem];
}
</style>
