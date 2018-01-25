<template>
    <v-layout row wrap>
        <v-flex xs12 sm12 md12 lg12>
            <v-form>
                <h6>Filtros básicos</h6>
                <v-layout row wrap>
                    <v-flex lg4 md6 sm12 xs12 class="mr-3">
                        <v-select
                            label="Clientes"
                            v-model="filter.clients"

                            item-text="name"
                            item-value="id"              
                            multiple
                            chips
                            :items="clients"
                        ></v-select>
                    </v-flex>

                    <v-flex lg4 md6 sm12 xs12 class="mr-3">
                        <v-select
                            label="Tipos de conta"
                            v-bind:items="billTypes"
                            v-model="filter.bill_type"
                            item-text="name"
                            item-value="id"
                            single-line
                            bottom
                        ></v-select>
                    </v-flex>
                </v-layout>

                <v-layout row wrap>
                    <v-flex lg4 md3 sm4 xs5 class="mr-3">
                        <v-select
                            label="Situação de pagamento"
                            v-bind:items="paiment_situations"
                            v-model="filter.paiment_situation"
                            item-text="text"
                            item-value="value"
                            single-line
                            bottom
                        ></v-select>
                    </v-flex>
                </v-layout>

                <v-layout row wrap>
                    <v-flex lg4>
                        <v-switch 
                            label="Procurar contas deletadas" 
                            v-model="filter.bills_deleted"
                            color="red"></v-switch>
                    </v-flex>
                </v-layout>

                <h6>Filtrar por datas</h6>
                <v-layout row wrap>
                    <v-flex lg3 class="mr-3">
                        <v-dialog
                            v-model="modal_expire_date_from_active"
                            full-width
                            max-width="340px"
                        >
                            <v-text-field
                            slot="activator"
                            label="Vencimento de..."
                            v-model="filter.expire_date_from"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="filter.expire_date_from" scrollable actions locale="pt-br">
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

                    <v-flex lg3>
                        <v-dialog
                            v-model="modal_expire_date_to_active"
                            full-width
                            max-width="340px"
                        >
                            <v-text-field
                            slot="activator"
                            label="Vencimento até..."
                            v-model="filter.expire_date_to"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="filter.expire_date_to" scrollable actions locale="pt-br">
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
                </v-layout>

                <v-divider></v-divider>

                <v-layout row wrap class="mt-3">
                    <v-flex lg3 class="mr-3">
                        <v-dialog
                            v-model="modal_pay_date_from_active"
                            full-width
                            max-width="340px"
                        >
                            <v-text-field
                            slot="activator"
                            label="Pagamento de..."
                            v-model="filter.pay_date_from"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="filter.pay_date_from" scrollable actions locale="pt-br">
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

                    <v-flex lg3>
                        <v-dialog
                            v-model="modal_pay_date_to_active"
                            full-width
                            max-width="340px"
                        >
                            <v-text-field
                            slot="activator"
                            label="Pagamento até..."
                            v-model="filter.pay_date_to"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="filter.pay_date_to" scrollable actions locale="pt-br">
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
                </v-layout>

                <v-layout row wrap class="mt-3"></v-layout>
                    <v-layout row>
                        <v-flex l5>
                            <v-btn color="primary" 
                            @click.native="submit()"
                            :loading="isLoading">
                                Procurar
                            </v-btn>

                            <v-btn 
                            @click.native="resetForm()">
                                Limpar
                            </v-btn>
                        </v-flex>
                </v-layout>
            </v-form>

            <v-data-table
            v-bind:headers="dataTable.headers"
            v-bind:items="dataTable.items"
            v-bind:pagination.sync="dataTable.pagination"
            hide-actions
            class="elevation-3"
            >
            <template slot="headerCell" slot-scope="props">
                <v-tooltip bottom>
                <span slot="activator">
                    {{ props.header.text }}
                </span>
                <span>
                    {{ props.header.text }}
                </span>
                </v-tooltip>
            </template>
            <template slot="items" slot-scope="props">
                <router-link :to="{name: 'bills.bill', params: {bill_id: props.item.id}}" tag="tr" class="clickable">
                    <td class="text-xs-right">{{ props.item.client.name }}</td>
                    <td class="text-xs-right">{{ props.item.bill_type.name }}</td>
                    <td class="text-xs-right">{{ props.item.expire_date }}</td>
                    <td class="text-xs-right">R$ {{ props.item.price }}</td>

                    <td class="text-xs-right" v-if="props.item.paid_at !== null">{{ props.item.paid_at }}</td>
                    <td class="text-xs-right" v-else>Não pago</td>
                </router-link>
                
            </template>
            </v-data-table>
            <div class="text-xs-center pt-2">
            <v-pagination 
            v-model="dataTable.pagination.page" 
            :length="dataTable.pagination.pages"
            :rows-per-page-items="dataTable.pagination.rowsPerPage"></v-pagination>
            </div>
        </div>
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
    </v-layout>
</template>

<script>
import { http } from '../../../../services/http'

export default {
    data() {
        return {
            filter: {
                clients: [],
                bill_type: null,
                paiment_situation: '',
                bills_deleted: false,

                expire_date_from: null,
                expire_date_to: null,

                pay_date_from: null,
                pay_date_to: null
            },

            clients: [],
            billTypes: [],
            paiment_situations: [
                {
                    text: "Todas",
                    value: "all"
                },
                {
                    text: "Apenas pagas",
                    value: "only_paid"
                },
                {
                    text: "Apenas não pagas",
                    value: "only_not_paid"
                }
            ],

            dataTable: {
                headers: [
                    {text: 'Cliente', value: 'client.name'},
                    {text: 'Tipo', value: 'bill_type.name'},
                    {text: 'Vencimento', value: 'expire_date'},
                    {text: 'Preço', value: 'price'},
                    {text: 'Pago em', value: 'paid_at'}
                ],

                pagination: {

                    rowsPerPage: 10
                }
            },

            modal_expire_date_from_active: false,
            modal_expire_date_to_active: false,
            modal_pay_date_from_active: false,
            modal_pay_date_to_active: false,

            isLoading: false,

            toast: {
                    toastVisible: false,
                    timeout: 8000,
                    y: 'top',
                    x: 'right',
                    text: '',
                    mode: 'vertical'
            },
        }
    },

    created() {
        this.$Progress.start()
        this.getClients();

        this.getBillTypes();
        this.$Progress.finish()
    },

    methods: {
        getClients() {
            http.get('/dashboard/clients')
            .then( ({data}) => this.clients = data )
            .catch( (error) => {
                //this.handleErrors(error.response);
                this.$Progress.fail()
            });
        },
        
        getBillTypes() {
            http.get('/dashboard/contas/tipos')
            .then( ({data}) => this.billTypes = data)

            .catch( (error) => {
                this.$Progress.fail()
            });
        },

        submit() {
            this.isLoading = true
            this.$Progress.start()
            http.post('/dashboard/contas/filter', this.filter)
            .then((response) => {
                this.dataTable.items = response.data
                this.setPagination(response.data)

                this.isLoading = false
                this.$Progress.finish()
            })
            .catch((error) => {
                //console.log(error.response.data)
                var errors
                errors = error.response.data.errors
                
                this.toast.text = errors[Object.getOwnPropertyNames(errors)[0]][0]
                this.toast.toastVisible = true
                
                this.isLoading = false
                this.$Progress.fail()
            })
        },

        setPagination(data) {
            this.dataTable.pagination.page = 1
            this.dataTable.pagination.totalItems = data.length
            this.dataTable.pagination.pages = Math.round(this.dataTable.pagination.totalItems / this.dataTable.pagination.rowsPerPage)
        }
        ,

        resetForm() {
            this.filter.bill_type = null
            this.filter.bills_deleted = false
            this.filter.clients = []
            this.filter.expire_date_from = null
            this.filter.expire_date_to = null
            this.filter.paiment_situation = ""
            this.filter.pay_date_from = null
            this.filter.pay_date_to = null
        }
    }
}
</script>
