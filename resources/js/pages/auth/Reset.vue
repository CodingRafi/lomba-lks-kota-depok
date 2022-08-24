<template>
    <div>
        <h1>Reset Password</h1>
        <form action="" @submit.prevent="reset">
            <div class="form-group">
                <label for="old_password">Old Password</label>
                <input
                    type="password"
                    id="old_password"
                    v-model="data.old_password"
                />
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input
                    type="password"
                    id="new_password"
                    v-model="data.new_password"
                />
            </div>
            <div class="form-group">
                <label for="confirm_new_password">Confirm Password</label>
                <input
                    type="password"
                    id="confirm_new_password"
                    v-model="data.confirm_new_password"
                />
            </div>
            <button type="submit">Reset</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";

export default {
    setup() {
        const router = useRouter();

        let data = {
            old_password: "",
            new_password: "",
            confirm_new_password: "",
        };
        let token = localStorage.getItem("token");
        if (!token) {
            router.push({
                name: "login",
            });
        }

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

        const reset = () => {
            let old_password = data.old_password;
            let new_password = data.new_password;
            let confirm_new_password = data.confirm_new_password;

            axios
                .post(
                    "/api/auth/reset-password",
                    {
                        old_password: old_password,
                        new_password: new_password,
                        confirm_new_password: confirm_new_password,
                    },
                    {
                        headers: {
                            Authorization:
                                "Bearer " + localStorage.getItem("token"),
                        },
                    }
                )
                .then((response) => {
                    if (response.data.code == 200) {
                        // console.log(response)
                        logout();
                    }
                });
        };

        return {
            reset,
            data,
        };
    },
};
</script>
