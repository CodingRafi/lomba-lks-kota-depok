<template>
    <div class="container">
        <div class="container2">
            <h1>Login</h1>
            <form action="" @submit.prevent="login">
                <h1 v-if="respon" v-text="respon"></h1>
                <div class="form-control">
                    <label for="email">Email</label>
                    <input type="text" id="email" v-model="user.email" />
                </div>
                <div class="form-control">
                    <label for="password">Password</label>
                    <input type="text" id="password" v-model="user.password" />
                </div>
                <label for="remember">Remember Me</label>
                <input type="checkbox" id="remember" v-model="user.remember" />
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";
import { reactive, ref } from "vue";

export default {
    setup() {
        const respon = ref();

        const user = reactive({
            email: "",
            password: "",
            remember: "",
        });

        const router = useRouter();

        const login = () => {
            let email = user.email;
            let password = user.password;
            let remember = user.remember;

            axios
                .post("/api/auth/login", {
                    email: email,
                    password: password,
                    remember: remember,
                })
                .then((res) => {
                    if (res.status == 200) {
                        respon.value = res.data.message;
                        localStorage.setItem("token", res.data.token);
                        axios
                            .get("/api/auth/me", {
                                headers: {
                                    Authorization:
                                        "Bearer " +
                                        res.data.token,
                                },
                            })
                            .then((response) => {
                                localStorage.setItem("dataUser", JSON.stringify(response.data));
                            });
                        router.push({
                            name: "home",
                        });
                    } else {
                        respon.value = "Gagal Login";
                    }
                });
        };

        return {
            user,
            login,
            respon,
        };
    },
};
</script>

<style>
.container {
}
</style>
