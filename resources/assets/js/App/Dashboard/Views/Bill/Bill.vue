<template>
<v-layout row wrap>
  <v-flex md9>
    <v-btn
        @click="$router.back()"
        color="primary"
    >
        Voltar
    </v-btn>
    <v-layout row wrap>
        <v-flex md6>
            <v-layout row wrap>
                <v-subheader><span class="grey--text">ID: </span> {{ bill.id }}</v-subheader>
            </v-layout>

            <v-layout row wrap>
                <v-subheader><span class="grey--text">Cliente: </span> {{ bill.client.name }}</v-subheader>
            </v-layout>

            <v-layout row wrap>
                <v-subheader><span class="grey--text">Tipo: </span> {{ bill.bill_type.name }}</v-subheader>
            </v-layout>

            <v-layout row wrap>
                <v-subheader><span class="grey--text">Vencimento: </span> {{ bill.expire_date }}</v-subheader>
            </v-layout>

            <v-layout row wrap>
                <v-subheader><span class="grey--text">Pago em: </span> {{ (bill.paid_at)? bill.paid_at: "Não pago" }}</v-subheader>
            </v-layout>

            <v-layout row wrap>
                <v-subheader><span class="grey--text">Preço: </span> R${{ bill.price }}</v-subheader>
            </v-layout>

            <v-layout row wrap>
                <v-subheader><span class="grey--text">Descrição: </span> {{ bill.description }}</v-subheader>
            </v-layout> 

            <v-layout row wrap>
                <v-btn
                    :disabled="bill.paid_at"
                    color="green"
                    @click.native="datePaymentPickDialog = true"
                >
                    Pagar
                </v-btn>
            </v-layout>
        </v-flex>
        
        <v-flex md5 offset-md1>
            <v-layout row wrap>
                <v-btn
                    color="error"
                    @click.native="deleteDialog = true"
                >
                Excluir
                </v-btn>
            </v-layout>
        </v-flex>

        </v-layout>
  </v-flex>

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

<v-dialog v-model="deleteDialog" persistent>
    <v-card>
        <v-card-title class="headline">Deletar conta?</v-card-title>
        <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="green darken-1" flat @click.native="deleteDialog = false">Cancelar</v-btn>
        <v-btn color="error" flat @click.native="deleteBill(); deleteDialog = false">Deletar</v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>

<v-dialog v-model="datePaymentPickDialog" max-width="400px">
    <v-card>
        <v-card-title class="headline">Selecione o dia de pagamento!</v-card-title>
        <v-card-text>
            <v-date-picker v-model="paymentDate" locale="pt-br">
                
            </v-date-picker>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" flat @click.native="datePaymentPickDialog = false">Cancelar</v-btn>
            <v-btn color="error" flat @click.native="sendPayment(); datePaymentPickDialog = false">Confirmar</v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>

</v-layout>


</template>

<script>
import { http } from '../../../../services'

    export default {        
        data() {
            return {
                bill: {
                    client:{},
                    bill_type: {}
                },
                
                toast: {
                    toastVisible: false,
                    timeout: 3000,
                    y: 'top',
                    x: 'right',
                    text: '',
                    mode: 'vertical'
                },
                deleteDialog: false,
                datePaymentPickDialog: false,

                paymentDate: null
            }
        },

        props: [
            'bill_id'
        ],

        watch: {
            '$route' : 'getBill'
        },

        created() {
            this.getBill()
            this.setPaymentDateToday()
        },

        methods: {
            setPaymentDateToday(){
                var date = new Date();
                this.paymentDate = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate()
            },

            getBill() {
                this.$Progress.start()
                http.get('/dashboard/contas/conta/view/' + this.bill_id)            
                .then((response) => {
                    this.bill = response.data;
                    this.$Progress.finish()
                })
            },

            deleteBill() {
                this.$Progress.start()
                http.delete('/dashboard/contas/conta/delete/' + this.bill_id)
                .then((response) => {
                    this.$router.back()
                    this.$Progress.finish()
                })
            },

            sendPayment() {
                this.$Progress.start()
                http.post('/dashboard/contas/conta/pay/' + this.bill_id, {paymentDate: this.paymentDate})
                .then(({data}) => {
                    this.$Progress.finish()
                    this.toast.text = data.message
                    this.toast.toastVisible = true

                    this.getBill()
                })
                .catch((error) => {
                    this.$Progress.fail()
                    var errors = error.response.data.errors
                    
                    this.toast.text = errors.paymentDate[0]
                    this.toast.toastVisible = true

                })
            }
        }
    }
</script>

<style>
.subheader{
    display:block
}
</style>
