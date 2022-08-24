<template>
    <Navbar />

    <div class="alert" v-if="message">
        {{ message }}
    </div>
    <div class="container3">
        <div class="card" v-for="poll in polls">
            <h1>{{ poll.nama }}</h1>
            <p>{{ poll.deskripsi }}</p>
            <span>Deadline: {{ poll.deadline }}</span>
            <br>
            <router-link :to="`/poll/${poll.id}`">Detail</router-link>
        </div>
    </div>
    <router-link class="tombol-tambah" to="/create-poll" v-if="user.role == 'admin'">+</router-link>
</template>

<script setup>
import Navbar from "../components/Navbar";
import { useRoute, useRouter } from "vue-router";
import { onMounted, ref } from "vue";

const router = useRouter();
const route = useRoute();
let polls= ref([]);
const message = ref(route.params.message);
let booleanAlert = ref(false)

let token = localStorage.getItem("token");
if (!token) {
    router.push({
        name: "login",
    });
}

onMounted(() => {
    axios.get("/api/poll", {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    }).then((response) => {
        polls.value = response.data.polls;
    });
});

setTimeout(() => {
    const alert = document.querySelector('.alert');
    if(alert){
        alert.style.display = "none";
    }
}, 1000);

const user = JSON.parse(localStorage.getItem('dataUser'));

</script>

<style>
.tombol-tambah {
    width: 50px;
    height: 50px;
    background-color: grey;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 40px;
    color: #fff;
    position: absolute;
    bottom: 3rem;
    right: 3rem;
    text-decoration: none;
}

.container3{
    display: flex;
    padding: 20px;
}

.card {
    width: 20rem;
    padding: 15px;
    box-sizing: border-box;
    background-color: #f2f2f2;
    text-align: center;
    margin: 10px 20px;
}

.card h1{
    font-size: 25px;
}

.card p {
    font-size: 15px;
    margin-top: 10px;
}

.card span{
    display: inline-block;
    margin-top: 10px;
}

.card a{
    text-decoration: none;
    background-color: rgb(42, 42, 42);
    color: #fff;
    padding: 10px 20px;
    border-radius: 3px;
    margin-top: 15px;
    display: inherit;
}

.alert{
    position: absolute;
    right: 3rem;
    top: 3rem;
    padding: 2rem 2rem;
    background-color: blanchedalmond;
}
</style>
