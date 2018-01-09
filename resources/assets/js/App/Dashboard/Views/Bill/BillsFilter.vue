<template>
    <v-layout row wrap>
        <v-flex md12>
            <h6>Filtros básicos</h6>
            <v-form>
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
                            v-model="filter.billTypes"

                            item-text="name"
                            item-value="id"              
                            multiple
                            chips
                            :items="billTypes"
                        ></v-select>
                    </v-flex>
                </v-layout>

                <v-layout row wrap>
                    <v-flex lg4 md3 sm4 xs5 class="mr-3">
                        <v-select
                            label="Situação de pagamento"
                            v-bind:items="['Todas', 'Apenas pagas', 'Apenas não pagas']"
                            v-model="filter.paiment_situation"
                            item-text="name"
                            single-line
                            required
                            bottom
                        ></v-select>
                    </v-flex>
                </v-layout>

                <v-layout row wrap>
                    <v-flex lg4>
                        <v-switch 
                            label="Procurar contas deletadas" 
                            v-model="filter.BillsDeleted"
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
            </v-form>
        </v-flex>
    </v-layout>
</template>

<script>
import { http } from '../../../../services/http'

export default {
    data() {
        return {
            filter: {
                clients: [],
                types: [],
                BillsDeleted: false
            },

            clients: [],
            billTypes: [],

            modal_expire_date_from_active: false,
            modal_expire_date_to_active: false,
            modal_pay_date_from_active: false,
            modal_pay_date_to_active: false

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
                //this.handleErrors(error.response);
                this.$Progress.fail()
            });
        },
    }
}
</script>
