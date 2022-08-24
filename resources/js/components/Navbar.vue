<template>
    <div
        class="navbar"
        style="display: flex; height: 12vh; background-color: #f2f2f2"
    >
        <div class="logo">
            <router-link to="/">Aplikasi Poll</router-link>
        </div>

        <div class="box" v-if="tombolProfil">
            <router-link to="/profil">Profil</router-link>
            <br />
            <router-link to="/reset-password" class="reset"
                >Reset Password</router-link
            >
            <br />
            <a href="" @click.prevent="logout">Logout</a>
        </div>

        <div class="bungkus">
            <div class="text">
                <h2>{{ user.name }}</h2>
                <p>{{ user.email }}</p>
            </div>
            <div class="img" @click="show">
                <div
                    class="logo"
                    style="
                        width: 50px;
                        height: 50px;
                        border-radius: 50%;
                        background-color: grey;
                        cursor: pointer;
                    "
                ></div>
            </div>
        </div>
    </div>
</template>

<style>
* {
    margin: 0;
    padding: 0;
}
.logo {
    width: 83%;
}

.logo a {
    text-decoration: none;
    color: black;
    line-height: 12vh;
    margin-left: 3rem;
    font-size: 20px;
}

.bungkus {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: right;
}

.text {
    padding-right: 10px;
}

.box {
    position: absolute;
    right: 2rem;
    top: 5rem;
    padding: 20px 30px;
    background-color: #f2f2f2;
}

.box a {
    text-decoration: none;
    color: black;
}
</style>

<script>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
export default {
    name: "Navbar",
    setup() {
        let tombolProfil = ref(false);

        const show = () => {
            // console.log('oke')
            if (tombolProfil.value == false) {
                tombolProfil.value = true;
            } else {
                tombolProfil.value = false;
            }
        };

        const router = useRouter();

        const logout = () => {
            axios
                .get("/api/auth/logout", {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    localStorage.removeItem("token");
                    router.push({
                        name: "login",
                    });
                });
        };

        const user = JSON.parse(localStorage.getItem('dataUser'));

        return {
            show,
            tombolProfil,
            logout,
            user
        };
    },
};
</script>
