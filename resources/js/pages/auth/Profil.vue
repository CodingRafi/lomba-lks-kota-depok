<template>
    <Navbar />

    <div class="card-3">
        <h1>Nama User</h1>
        <h3>email</h3>
    </div>
</template>

<script setup>
import axios from "axios";
import Navbar from "../../components/Navbar";
import { onMounted } from "vue";

onMounted(() => {
    axios
        .get("/api/auth/me", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        })
        .then((response) => {
            console.log(response);
        });
});
</script>
