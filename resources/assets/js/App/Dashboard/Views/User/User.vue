<template>
<div>
<v-layout row wrap>
  <v-flex md9>
    <v-data-table
        :loading="tableIsLoading"
        v-model="selected"
        select-all
        item-key="name"
        v-bind:headers="headers"
        v-bind:items="items"
        v-bind:pagination.sync="pagination"
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
        <tr :active="props.selected" @click="props.selected = !props.selected">
            <td>
            <v-checkbox
                primary
                hide-details
                :input-value="props.selected"
            ></v-checkbox>
            </td>
            <td class="text-xs-right">{{ props.item.id }}</td>
            <td class="text-xs-right">{{ props.item.name }}</td>
            <td class="text-xs-right">{{ props.item.email }}</td>
            <td class="text-xs-right">{{ props.item.isAdmin }}</td>
        </tr>
      </template>
    </v-data-table>
    <div class="text-xs-center pt-2">
      <v-pagination v-model="pagination.page" :length="pagination.pages"></v-pagination>
    </div>
  </v-flex>

  <v-flex md2 offset-md1>
    <v-card>
        <v-card-title>
        <div>
            <h3 class="headline mb-0">Ações</h3>
        </div>
        </v-card-title>
        <v-card-text>
            <v-btn color="primary" dark :to="{name: 'users.create'}">
                  Cadastrar
            </v-btn>

            <template v-if="(howManyItemSelected >= 1)">
                <v-btn color="warning" dark 
                    v-if="(howManyItemSelected == 1)"
                    :to="{name: 'users.edit', params: {user_id: this.selected[0].id}}"
                >
                  Editar
                </v-btn>
                <v-btn color="error" dark @click.native="deleteDialog = true">
                  Excluir
                </v-btn>
            </template>
        </v-card-text>

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
                <v-card-title class="headline">Deletar usuário?</v-card-title>
                <v-card-text>Essa ação será irreversível.</v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" flat @click.native="deleteDialog = false">Cancelar</v-btn>
                <v-btn color="error" flat @click.native="deleteItems(); deleteDialog = false">Deletar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-card>
  </v-flex>
</v-layout>
</div>
</template>

<script>
import { http } from '../../../../services'
import { isEmpty } from 'lodash'

    export default {        
        data() {
            return {
                headers: [
                    {
                        text: 'Id',
                        value: 'id'
                    },
                    {
                        text: 'Nome',
                        value: 'id'
                    },
                    {
                        text: 'Email',
                        value: 'id'
                    },
                    {
                        text: 'Admin',
                        value: 'id'
                    }
                ],
                items: [],
                tableIsLoading:true,
                pagination: { 
                    sortBy: 'column', 
                    page: 1, 
                    rowsPerPage: 8, 
                    descending: false, 
                    totalItems: 0,
                    pages: 0
                },
                selected: [],
                toast: {
                    toastVisible: false,
                    timeout: 3000,
                    y: 'top',
                    x: 'right',
                    text: '',
                    mode: 'vertical'
                },
                deleteDialog: false
            }
        },
        
        created() {
            this.loadData();
        },

        computed: {
            howManyItemSelected() {
                return this.selected.length
            }
        },

        methods: {
            loadData() {
                this.tableIsLoading = true
                this.selected = []
                http.get("/dashboard/users")
                .then((response) => {
                    this.items = response.data
                    this.pagination.totalItems = response.data.length
                    this.pagination.pages = Math.round(this.pagination.totalItems / this.pagination.rowsPerPage)
                    this.tableIsLoading = false
                })
            },

            deleteItems() {
                this.$Progress.start()
                http.delete('dashboard/users/delete', {data: this.selected})
                .then(() => {
                    this.$Progress.finish()
                    this.toast.text = "Usuário(s) deletado(s) com sucesso!"
                    this.toast.toastVisible = true
                    this.loadData()
                })
                .catch((error) => {
                    this.$Progress.fail()
                    switch(error.response.status){
                        case 403:
                            this.toast.text = "Sem permissão para isso!"
                            this.toast.toastVisible = true
                        break;
                    }
                })
            }
        }
    }
</script>
