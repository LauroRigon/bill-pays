<template>
<div>
  <h5 class="text-xs-center">Contas atrasadas</h5>
    <v-data-table
    dark
    :loading="expired_table.tableIsLoading"
    v-model="expired_table.selected"
    item-key="id"
    v-bind:headers="expired_table.headers"
    v-bind:items="expired_table.items"
    v-bind:pagination.sync="expired_table.pagination"
    hide-actions
    class="elevation-1"
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
            <td class="text-xs-right">R${{ props.item.price }}</td>
        </router-link>
    </template>

    </v-data-table>
    <div class="text-xs-center pt-2">
        <v-pagination v-model="expired_table.pagination.page" :length="expired_table.pagination.pages"></v-pagination>
    </div>
</div>
</template>

<script>
import { http } from '../../../services/http'

export default {
    data() {
        return {
            expired_table: {
                headers: [
                    {
                        text: 'Cliente',
                        value: 'id'
                    },
                    {
                        text: 'Tipo',
                        value: 'id'
                    },
                    {
                        text: 'Vencimento',
                        value: 'id'
                    },
                    {
                        text: '(R$)Preço',
                        value: 'id'
                    }
                ],
                pagination: { 
                    sortBy: 'column', 
                    page: 1, 
                    rowsPerPage: 8, 
                    descending: false, 
                    totalItems: 0,
                    pages: 0
                },
                items: [],
                tableIsLoading: true,
            },
        }
    },

    created() {
        this.getExpiredBills()
    },

    methods: {
        getExpiredBills() {
            this.expired_table.tableIsLoading = true
                this.expired_table.selected = []
                http.get("/dashboard/contas/expireds")
                .then((response) => {
                    this.expired_table.items = response.data
                    this.setPagination(response.data)
                    this.expired_table.tableIsLoading = false
                })
        },

        setPagination(data) {
            this.expired_table.pagination.totalItems = data.length
            this.expired_table.pagination.pages = Math.round(this.expired_table.pagination.totalItems / this.expired_table.pagination.rowsPerPage)
        }
    }
}
</script>

