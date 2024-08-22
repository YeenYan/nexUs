<template>
    <p>Success</p>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const props = defineProps({
    workspace: String,
    owner_id: String,
    member_id: String,
});

onMounted(() => {
    triggered();
    save_member();
});

const triggered = () => {
    console.log({
        workspace: props.workspace,
        owner: props.owner_id,
        member: props.member_id,
    });
};

const save_member = async () => {
    try {
        const response = await axios.post(
            route("add_member", {
                workspace: props.workspace,
                owner_id: props.owner_id,
                member_id: props.member_id,
            }),
            {
                workspace_id: props.workspace,
                owner_id: props.owner_id,
                member_id: props.member_id,
            }
        );
        if (response.status == 200) {
            alert("success");
        }
    } catch (error) {
        console.log(error);
    }
};
</script>
