<template>
<v-layout row wrap>
  <v-flex md9>
    <v-btn
        @click="$router.push({name: 'users'})"
        color="primary"
        >
        Voltar
    </v-btn>
    <v-form v-model="valid">
        <v-text-field
        label="Nome"
        v-model="user.name"
        required
        ></v-text-field>

        <v-text-field
        label="E-mail"
        v-model="user.email"
        :rules="emailRules"
        required
        ></v-text-field>

        <v-text-field
        type="password"
        label="Senha"
        v-model="user.password"
        :rules="passwordRules"
        required
        ></v-text-field>

        <v-checkbox
        label="Admin?"
        v-model="user.isAdmin"
        ></v-checkbox>

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

    export default {
        data(){
            return {
                isLoading: false,
                user: {
                    name: '',
                    email: '',
                    isAdmin: true,
                    password: ''
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
                    (v) => !!v || 'E-mail é obrigatório',
                    (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail precisa ser válido'
                ],
                passwordRules: [
                    (v) => v.length >= 6 || 'A senha precisar ter no mínimo 6 letras!'
                ]
            }
        },

        props: [
            'user_id'
        ],

        created(){
            this.$Progress.start()
            http.get('/dashboard/users/edit/' + this.user_id)            
            .then((response) => {
                this.user.name = response.data.name;
                this.user.email = response.data.email;
                this.user.isAdmin = response.data.isAdmin;

                this.$Progress.finish()
            })
            
        },

        methods: {
            sendForm(){
                this.$Progress.start()
                this.isLoading = true;
                http.put('/dashboard/users/update/' + this.user_id, this.user)
                .then((response) => {
                    this.$Progress.finish()
                    this.toast.text = "Usuário criado com sucesso!"
                    this.toast.toastVisible = true

                    this.$router.push({name: 'users'});
                })
                .catch((error) => {
                    this.$Progress.fail()
                    this.toast.text = "Ocorreu um erro ao atualizar esse usuário!"
                    this.toast.toastVisible = true
                    this.isLoading = false;
                })
            }
        }
    }
</script>