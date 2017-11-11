<template>
<v-layout row wrap>
  <v-flex md9>
    <v-btn
        @click="$router.push({name: 'clients'})"
        color="primary"
        >
        Voltar
    </v-btn>
    <v-form v-model="valid">
        <v-text-field
        label="Nome"
        v-model="client.name"
        required
        ></v-text-field>

        <v-text-field
        label="E-mail"
        v-model="client.email"
        :rules="(!isEmptyEmail) ? emailRules : noRules"
        ></v-text-field>

        <v-btn
        @click="sendForm()"
        :disabled="!valid"
        color="primary"
        :loading="isLoading"
        >
        Confirmar
        </v-btn>
        <v-snackbar
        :timeout="toast.timeout"
        :y="toast.y"
        :x="toast.x"
        :mode="toast.mode"
        v-model="toast.toastVisible"
        >
        {{ toast.text }}
        <v-btn flat color="pink" @click.native="toast.toastVisible = false">Close</v-btn>
    </v-snackbar>
    </v-form>
  </v-flex>
  
    
</v-layout>
</template>

<script>
import { http } from '../../../../services'
import { isEmpty } from 'lodash'
    export default {
        data(){
            return {
                isLoading: false,
                client: {
                    name: '',
                    email: ''
                },
                toast: {
                    toastVisible: false,
                    timeout: 3000,
                    y: 'top',
                    x: 'right',
                    text: '',
                    mode: 'vertical'
                },
                valid: true,
                emailRules: [
                    (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail precisa ser válido'
                ],
                noRules: []
            }
        },

        computed: {
            isEmptyEmail() {
                return isEmpty(this.client.email)
            }
        },

        methods: {
            sendForm(){
                this.isLoading = true
                this.$Progress.start()
                http.post('/dashboard/clients/store', this.client)
                .then( (response) => {
                    this.isLoading = false
                    this.$Progress.finish()
                    this.toast.text = "Cliente criado com sucesso!"
                    this.toast.toastVisible = true
                })
                .catch( (error) => {
                    console.log(error)
                    this.isLoading = false
                    this.toast.text = "Ocorreu um erro!"
                    this.toast.toastVisible = true

                    this.$Progress.fail()
                });
            }
        }
    }
</script>