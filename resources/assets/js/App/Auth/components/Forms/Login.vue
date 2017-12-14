<template>
<v-container fill-height fluid>
    <v-layout flex align-center justify-center>
        <v-flex xs12 md5 align-end flexbox>
            <v-card color="" class="black--text" >
                <v-container fluid grid-list-lg>
                <v-layout row>
                    <v-flex xs4>
                    <div>
                        <div class="headline"><p class="text-md-center">Login</p></div>
                    </div>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex md12 offset-md1>
                        <v-form>
                            <v-text-field
                            label="Email"
                            v-model="user.email"
                            type="email"
                            required
                            @keydown.enter="doLogin()"
                            ></v-text-field>

                            <v-text-field
                            label="Senha"
                            v-model="user.password"
                            type="password"
                            required
                            @keydown.enter="doLogin()"
                            ></v-text-field>
                        </v-form>
                        <v-btn @click="doLogin">Entrar</v-btn>
                    </v-flex>
                </v-layout>
                </v-container>

                <v-snackbar
                :timeout="6000"
                multi-line="multi-line"
                vertical="vertical"
                v-model="snackbar"
                >
                {{ snackbarContent }}
                <v-btn dark flat @click.native="snackbar = false">Close</v-btn>
                </v-snackbar>
            </v-card>
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
import { isEmpty } from 'lodash'
import { mapActions } from 'vuex'
import { authPersistence } from '../../../../services'

export default {
    data() {
        return {
            user: {
                email: '',
                password: ''
            },
            snackbar: false,
            snackbarContent: ''
        }
    },

    methods: {
        ...mapActions([
            'attemptLogin'
        ]),

        doLogin() {
            this.$Progress.start()
            
            this.attemptLogin(this.user)
                .then(() => {
                    this.$router.push({name: 'dashboard.index'})
                    this.$Progress.finish()
                    this.snackbar = true
                    this.snackbarContent = "Logado com sucesso!"
                })

                .catch((error) => {
                    this.$Progress.fail()
                    this.snackbar = true
                    console.log(error);
                    this.snackbarContent = "Usuário ou senha incorreto!"
                })
            
        }
    },

    computed: {
        isValid () {
            const user = this.user
            return !isEmpty(user.email) && !isEmpty(user.password)
        }
    }
}
</script>

<style>
#loginCard {
    margin-top: 100px;
}
</style>
