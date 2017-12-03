<template>
    <div class="accountForm">
        <div :class="formTitleCss">{{title}}</div>
        <form action="#" v-if="userLogin" class='useraccount wed-form' name="useraccount" @submit.prevent="postLogout">
            <input type="submit" :disabled="isProcessing" value="Выход" />
        </form>
        <form action="#" class='useraccount wed-form' name="useraccount" @submit.prevent="postLogin" v-else>
            <div class="form-group">
                <input type="text" placeholder="Логин" name="login" id="login" class="accountForm__login" v-model="login">
                <div class="error" v-if="errors.login">
                    {{errors.login}}
                </div>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Пароль" name="password" id="password" v-model="password">
                <div class="error" v-if="errors.password">
                    {{errors.password}}
                </div>
            </div>
            <div class="col submit-col">
                <button type="submit" :disabled="isProcessing">
                    <template v-if="isProcessing">
                        Авторизация
                    </template>
                    <template v-else>
                        Войти
                    </template>
                </button>
            </div>
            <div class="col">
                <a href="#" class="forgotpass"> Напомнить пароль </a>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            userLogin: String,
            required: false,
        },

        data() {
            return {
                login: '',
                password: '',
                errors: {},
                isProcessing: false,
            };
        },

        methods: {
            postLogin() {
                if (this.isProcessing) return;
                this.isProcessing = true;
                this.errors = {};
                axios.post('/api/auth/login', {
                    login: this.login,
                    password: this.password,
                }).then((response) => {
                    this.isProcessing = false;
                    if (response.data.ok) {
                        window.location.replace(response.data.route);
                        return;
                    }
                    this.errors = response.data.errors;
                }, (response) => {
                    this.isProcessing = false;
                });
            },

            postLogout() {
                if (this.isProcessing) return;
                this.isProcessing = true;
                axios.post('/api/auth/logout').then((response) => {
                    this.isProcessing = false;
                    if (response.data.ok) {
                        window.location.replace(response.data.route);
                        return;
                    }
                }, (response) => {
                    this.isProcessing = false;
                });
            }
        },

        computed: {
            title() {
                if (this.userLogin) {
                    return "Личный кабинет";
                }
                return "Вход в личный кабинет";
            },

            formTitleCss() {
                const css = {
                    'form-title': true
                };
                if (this.userLogin) {
                    css['form-title--auth'] = true;
                }
                return css;
            }
        }
    }
</script>
