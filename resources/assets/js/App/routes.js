//Main do dashboard
import DashboardMain from './Dashboard/Views/Main.vue'
//Main de Auth
import AuthMain from './Auth/components/Main.vue'

//Parent component
import Parent from './Parent'

import { authPersistence } from '../services'
import store from '../vuex/'

export default [
    {
        path: '',
        component: AuthMain,
        children: [
            {
                path: '/',
                component: require('./Auth/components/Forms/Login.vue'),
                name: 'login',
                beforeEnter: requireAuth
            }
        ]
    },
    {
        path: '/dashboard',
        component: DashboardMain,
        beforeEnter: (to, from, next) => {
            if(store.getters.isLogged){
                next()
            }else{
                next({name: 'login'})
            }
        },
        children: [
            {
                path: '/',
                name: 'dashboard.index',
                component: require('./Dashboard/Views/Dashboard/Index.vue')
            },
            {
                path: 'usuarios',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./Dashboard/Views/User/Users.vue'),
                        name: 'users'
                    },
                    {
                        path: 'criar',
                        component: require('./Dashboard/Views/User/Create.vue'),
                        name: 'users.create'
                    },
                    {
                        path: 'editar/:user_id',
                        name: 'users.edit',
                        component: require('./Dashboard/Views/User/Edit.vue'),
                        props: true
                    }
                ]
            },
            {
                path: 'clientes',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./Dashboard/Views/Client/Clients.vue'),
                        name: 'clients'
                    },
                    {
                        path: 'criar',
                        component: require('./Dashboard/Views/Client/Create.vue'),
                        name: 'clients.create'
                    },
                    {
                        path: 'editar/:client_id',
                        name: 'clients.edit',
                        component: require('./Dashboard/Views/Client/Edit.vue'),
                        props: true
                    }
                ]
            },
            {
                path: 'contas',
                component: Parent,
                children: [
                    {
                        path: 'tipos',
                        component: require('./Dashboard/Views/BillType/Edit.vue'),
                        component: Parent,
                        children: [
                            {
                                name: 'bills.types',
                                path: '/',
                                component: require('./Dashboard/Views/BillType/BillTypes.vue'),
                            },
                            {
                                name: 'bills.types.create',
                                path: 'criar',
                                component: require('./Dashboard/Views/BillType/Create.vue'),
                            },
                            {
                                name: 'bills.types.edit',
                                path: 'editar/:bill_type_id',
                                component: require('./Dashboard/Views/BillType/Edit.vue'),
                                props: true
                            },
                        ]
                    },

                    {
                        path: 'procurar',
                        component: require('./Dashboard/Views/Bill/BillsFilter.vue'),
                        name: 'bills.filter'
                    },
                    {
                        path: 'criar',
                        component: require('./Dashboard/Views/Bill/Create.vue'),
                        name: 'bills.create'
                    },
                    {
                        path: 'editar/:bill_id',
                        name: 'bills.edit',
                        component: require('./Dashboard/Views/Bill/Edit.vue'),
                        props: true
                    },
                    {
                        path: 'conta/:bill_id',
                        name: 'bills.bill',
                        component: require('./Dashboard/Views/Bill/Bill.vue'),
                        props: true
                    }
                ]
            }
        ]
    }

    
]

function requireAuth(to, from, next) {
    if(store.getters.isLogged) {
        next({name: 'dashboard.index'})
    }else{
        next()
    }
}