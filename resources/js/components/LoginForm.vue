<template>
    <v-app id="login-form">
        <v-container fluid class="v-main__wrap">
            <v-card
                class="mx-auto my-4"
                max-width="500"
                elevation="24"
            >
                <v-img
                    height="290"
                    src="img/kt.jpg"
                ></v-img>
                <v-card-title class="justify-center font-weight-black">
                    Авторизация
                </v-card-title>
                <v-card-subtitle class="text-center font-weight-bold"
                    :class="errorText !== null ? 'red--text' : ''">
                    {{errorText === null ? 'Авторизуйтесь для дальнейшей работы с системой' : errorText}}
                </v-card-subtitle>
                <v-card-text>
                    <v-form
                        ref="authForm"
                        v-model="formValid"
                        lazy-validation>
                        <v-text-field
                        label="Введите email"
                        hide-details="auto"
                        :rules="emailRules"
                        v-model="email">
                        </v-text-field>
                        <v-text-field
                            label="Введите пароль"
                            hide-details="auto"
                            :rules="passwordRules"
                            v-model="password"
                            :type="showPassword ? 'text' : 'password'"
                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="showPassword = !showPassword">
                        </v-text-field>
                        <v-btn
                            class="mt-5"
                            :disabled="!formValid"
                            color="success"
                            @click="login">
                            Авторизоваться
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-container>
    </v-app>
</template>

<script>
export default {
    name: "LoginForm",
    data() {
        return {
            email: "",
            password: "",
            formValid: true,
            errorText: null,
            showPassword: false,
            emailRules: [
                v => !!v || 'Поле является обязательным для заполнения',
                v => /.+@.+/.test(v) || 'Введенный email некорректен',
            ],
            passwordRules: [
                v => !!v || 'Поле является обязательным для заполнения'
            ]
        }
    },
    methods: {
        login() {
            this.formValid = this.$refs.authForm.validate();
            if (!this.formValid)
                return;
            let authData = {
                email : this.email,
                password : this.password
            }
            this.$store.dispatch('login', authData)
                .catch(() => {
                    this.errorText = "Произошла ошибка авторизации. Попробуйте снова.";
                    this.email = "";
                    this.password = "";
                });
        }
    }
}
</script>

<style scoped>
    .v-main__wrap {
        background-image: url("https://www.donnu.ru/public/новое3.jpg");
        background-size: cover;
        background-repeat:no-repeat;
    }
</style>
