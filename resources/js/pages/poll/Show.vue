<template>
    <Navbar />

    <div class="container4">
        <div class="card card-2">
            <a href="" @click.prevent="hapus" v-if="user.role == 'admin'">Hapus</a>
            <h1>{{ data.nama }}</h1>
            <p>{{ data.deskripsi }}</p>
            <span>deadline: {{ data.deadline }}</span>
            
            <p v-if="is_voted" v-for="pilihan in pilihans">{{ pilihan.nama }} - {{ pilihan.presentasi }}%</p>
            <a href="" v-for="pilihan in pilihans" @click.prevent="pilih(pilihan.id)" v-if="!is_voted && user.role != 'admin'">{{ pilihan.nama }}</a>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { useRoute, useRouter } from "vue-router";
import Navbar from "../../components/Navbar";
import { onMounted, ref } from "vue";

const data = ref([]);
const pilihans = ref([]);
const is_voted = ref();

const router = useRouter();
const route = useRoute();

const user = JSON.parse(localStorage.getItem('dataUser'));

const dataId = route.params.id;

const pilih = (pilihan_id) => {
    axios.get(`/api/poll/${dataId}/vote/${pilihan_id}`, {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    }).then((response) => {
        router.push({
            name: 'home'
        })
    })
}

const hapus = () => {
    axios.delete(`/api/poll/${dataId}`, {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    }).then((response) => {
        router.push({
            name: 'home',
            params: {
                message: response.data.message
            }
        })
    })
}

onMounted(() => {
    axios.get("/api/poll/" + dataId, {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    }).then((response) => {
        is_voted.value = response.data.is_voted;
        data.value = response.data.poll;
        pilihans.value = response.data.pilihans
    });
});
</script>

<style>
    .card-2{
        text-align: left;
        width: 30rem;
        min-height: 20rem;
    }
</style>
