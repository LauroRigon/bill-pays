<template>
<v-layout row wrap>
  <v-flex md9>
    <v-btn
        @click="$router.push({name: 'bills.types'})"
        color="primary"
        >
        Voltar
    </v-btn>
    <v-form v-model="valid">
        <v-text-field
        label="Nome"
        v-model="billType.name"
        required
        :rules="requiredRule"
        ></v-text-field>

        <v-text-field
        label="Valor padrão"
        v-model="billType.default_price"
        type="number"
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
                billType: {
                    name: '',
                    default_price: ''
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
                requiredRule: [
                    (v) => !!v || 'Este campo é obrigatório!',
                ]
            }
        },

        props: [
            'bill_type_id'
        ],

        created(){
            this.$Progress.start()
            http.get('/dashboard/contas/tipos/edit/' + this.bill_type_id)            
            .then((response) => {
                console.log(response)
                this.billType.name = response.data.name;
                this.billType.default_price = response.data.default_price;

                this.$Progress.finish()
            })
            
        },

        methods: {
            sendForm(){
                this.$Progress.start()
                this.isLoading = true;
                http.put('/dashboard/contas/tipos/update/' + this.bill_type_id, this.billType)
                .then((response) => {
                    this.$Progress.finish()
                    this.toast.text = "Tipo de conta atualizado com sucesso!"
                    this.toast.toastVisible = true

                    this.$router.push({name: 'bills.types'});
                })
                .catch((error) => {
                    this.$Progress.fail()
                    this.handleErrors(error.response);
                    this.isLoading = false;
                })
            },

            handleErrors(errorResponse) {
                if(!isEmpty(errorResponse.data.errors.name[0])){
                    this.toast.text = errorResponse.data.errors.name[0]
                    this.toast.color = 'error'
                    this.toast.toastVisible = true
                }
            }
        }
    }
</script>