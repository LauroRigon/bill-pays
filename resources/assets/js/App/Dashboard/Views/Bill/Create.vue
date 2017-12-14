<template>
<v-layout row wrap>
  <v-flex md9>
    <v-form v-model="valid">
        <v-flex xs12>
            <v-select
                label="Clientes"
                v-model="bill.clients"
                item-text="name"
                item-value="id"              
                multiple
                chips
                :items="clients"
                required
                :rules="requiredRule"
            ></v-select>
        </v-flex>       

        <v-flex xs4>
            <v-select
                label="Tipo de conta"
                v-bind:items="billTypes"
                v-model="bill.type"
                item-text="name"
                single-line
                bottom
                required
                :rules="requiredRule"
            ></v-select>
        </v-flex>

        <v-flex xs6>
            <v-flex xs4>
                <v-text-field
                    label="Valor"
                    v-model="bill.price"
                    type="number"
                    required
                    :rules="requiredRule"
                    :value="setDefaultValue"
                ></v-text-field>
            </v-flex>
            <v-switch label="Pegar valor padrão" v-model="default_value"></v-switch>
        </v-flex>

        <v-flex xs11 sm5>
            <v-dialog
                v-model="modal_date_active"
                lazy
                full-width
                max-width="340px"
            >
                <v-text-field
                slot="activator"
                label="Escolha uma data de vencimento"
                v-model="bill.expire_date"
                prepend-icon="event"
                readonly
                ></v-text-field>
                <v-date-picker v-model="bill.expire_date" scrollable actions locale="pt-br">
                <template slot-scope="{ save, cancel }">
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="cancel">Cancelar</v-btn>
                    <v-btn flat color="primary" @click="save">Ok</v-btn>
                    </v-card-actions>
                </template>
                </v-date-picker>
            </v-dialog>
        </v-flex>

        <v-flex xs6>
            <v-text-field
                v-model="bill.description"
                label="Descrição"
                type="text"
            ></v-text-field>
        </v-flex>
        
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
                bill: {
                    clients: [],
                    type: null,
                    price: null,
                    description: "",
                    expire_date: null
                },
                clients: [],
                billTypes: [],
                default_value: true,
                modal_date_active: false,

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

        created(){
            this.setExpireDateToday()

            this.$Progress.start()
            this.getClients();

            this.getBillTypes();
            this.$Progress.finish()
        },

        watch: {
            /*default_value(){
                if(this.bill.type != null && this.default_value){
                    this.bill.price = this.bill.type.default_price
                }
            }*/
            billPriceSelected(value){
                if(this.bill.type != null){
                    if(value != this.bill.type.default_price){
                        this.default_value = false;
                    }
                }

            }
        },

        computed: {
            setDefaultValue(){
                if(this.bill.type != null && this.default_value){
                    this.bill.price = this.bill.type.default_price
                }
            },

            billPriceSelected(){
                return this.bill.price
            }
        },

        methods: {
            setExpireDateToday(){
                var date = new Date();
                this.bill.expire_date = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate()
            },

            getDataAsRequest(){
                let request = { ...this.bill}   //cria um novo objeto com as coisas do this.bill. Só atribuir ele retorna um observer que altera o valor original DATA
                request.type = request.type.id;
                return request
            },

            sendForm(){
                this.isLoading = true
                this.$Progress.start()

                http.post('/dashboard/contas/store', this.getDataAsRequest())
                .then( (response) => {
                    this.isLoading = false
                    this.$Progress.finish()
                    this.toast.text = "Contas criadas com sucesso!"
                    this.toast.toastVisible = true
                })
                .catch( (error) => {
                    this.isLoading = false
                    this.$Progress.fail()
                    this.handleErrors(error.response);
                    
                });
            },

            getClients() {
                http.get('/dashboard/clients')
                .then( ({data}) => this.clients = data )
                .catch( (error) => {
                    this.handleErrors(error.response);
                    this.$Progress.fail()
                });
            },
            
            getBillTypes() {
                http.get('/dashboard/contas/tipos')
                .then( ({data}) => this.billTypes = data)

                .catch( (error) => {
                    this.handleErrors(error.response);
                    this.$Progress.fail()
                });
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