<template>
    <div>
        <vue-table title="Tabela de usuários"
				:has-actions="true"
				:fields="fields"
				source-data="/api/dashboard/users"
				delete-api="/api/dashboard/users/delete/"
				:actions="tableActions">
                <div slot="buttons">
                    <router-link class="left btn-floating btn-med blue" :to="{name: 'users.create'}"><i class="material-icons">add</i></router-link>
                </div>
                </vue-table>
    </div>
</template>

<script>
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
                    { name: 'delete-item', icon: 'delete_forever', class: 'btn waves-effect waves-light red'}
                ]
            }
        },

        methods: {
            editUser(item){
                this.$router.push({name: 'users.edit', params: { user_id: item.id }})
                console.log(item)
            }
        }
    }
</script>
