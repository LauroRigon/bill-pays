<template>
    <div>
        <vue-table title="Tabela de usuários"
				:has-actions="true"
				:fields="fields"
				source-data="/dashboard/users"
				delete-api="/dashboard/users/delete/"
				:actions="tableActions">
                <div slot="buttons">
                    <router-link class="left btn-floating btn-med blue" :to="{name: 'users.create'}"><i class="material-icons">add</i></router-link>
                </div>
                </vue-table>
    </div>
</template>

<script>
import { http } from '../../../../services'
    export default {        
        data() {
            return {
                fields: [
                    {
                        name: 'Id',
                        dbName: 'id'
                    },
                    {
                        name: 'Nome',
                        dbName: 'name'
                    },
                    {
                        name: 'Email',
                        dbName: 'email'
                    },
                    {
                        name: 'Admin',
                        dbName: 'isAdmin'
                    },
                    {
                        name: '__actions'
                    }
                ],
                tableActions: [
                    { name: 'edit-item', icon: 'create', class: 'btn waves-effect waves-light orange', action: this.editUser},
                    { name: 'delete-item', icon: 'delete_forever', class: 'btn waves-effect waves-light red', action: this.deleteUser}
                ]
            }
        },

        methods: {
            editUser(item) {
                this.$router.push({name: 'users.edit', params: { user_id: item.id }})
                console.log(item)
            },

            deleteUser(item) {
                this.$Progress.start()
                http.delete('dashboard/users/delete/' + item.id)
                .then(() => {
                    this.$Progress.finish()
                    Materialize.toast('Usuário deletado com sucesso!', 3000)
                    this.$children[0].loadData()
                })                
            }
        }
    }
</script>
