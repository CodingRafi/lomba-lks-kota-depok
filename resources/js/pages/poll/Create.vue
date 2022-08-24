<template>
    <Navbar></Navbar>

    <div class="container">
        <div class="container-form">
            <h2>Create Poll</h2>
            <form action="" @submit.prevent="createPoll">
                <div class="form-group">
                    <label for="name">Nama Poll</label>
                    <input type="text" id="name" name="nama" />
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi"></textarea>
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="date" id="deadline" name="deadline"/>
                </div>
                <div class="container-label">
                    <label for="">Pilihan</label>
                    <a href="javascript:void(0)" @click.prevent="addOption">+</a>
                </div>
                <div class="container-input" v-for="count in countPilihan">
                    <input v-bind:id="'input-' + count" type="text" name="pilihan" />
                    <a href="javascript:void(0)" v-bind:id="'btn-delete-' + count" @click.prevent="hapus">Hapus</a>
                </div>
                <button type="submit" class="btn">Simpan</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import Navbar from "../../components/Navbar";
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

let token = localStorage.getItem("token");
if (!token) {
    router.push({
        name: "login",
    });
}

let countPilihan = ref(1)

const addOption = () => {
    countPilihan.value++
}

const hapus = (e) => {
    const id = e.target.id.split('-')[2]
    document.querySelector('#input-' + id).parentElement.remove()
}

const createPoll = (e) => {

    const formData = new FormData(e.target);

    axios.post('/api/poll', {
        nama: formData.get('nama'),
        deskripsi: formData.get('deskripsi'),
        deadline: formData.get('deadline'),
        pilihan: formData.getAll('pilihan')
    }, {
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

</script>

<style>
* {
    font-family: Arial, Helvetica, sans-serif;
}

.container {
    min-height: 87vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container-form {
    width: 50%;
    padding: 25px;
    box-sizing: border-box;
    background-color: #f2f2f2;
}

.container-form h2 {
    margin-bottom: 1rem;
}

.form-group {
    margin-top: 10px;
    display: flex;
}

.form-group label {
    width: 20%;
}

.form-group input {
    width: 80%;
    height: 1.5rem;
    padding: 5px;
}

.container-input{
    display: flex;
}

.container-input a{
    width: 20%;
    text-decoration: none;
    text-align: center;
    line-height: 3rem;
    color: black;
}

.container-input input {
    width: 80%;
    height: 1.5rem;
    margin: 10px 0;
    padding: 5px;
}

.form-group textarea {
    width: 80%;
    height: 5rem;
    padding: 5px;
}

.container-label {
    width: 100%;
    display: flex;
    margin-top: 10px;
}

.container-label label {
    width: 95%;
}

.container-label a {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    border: none;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgb(62, 62, 62);
    cursor: pointer;
}

.btn {
    border: none;
    background: #a7a5a5;
    padding: 13px 20px;
    border-radius: 3px;
    color: #f2f2f2;
    cursor: pointer;
}

</style>
