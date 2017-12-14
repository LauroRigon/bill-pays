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
        path: '/login',
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
        name: 'dashboard',
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
                path: 'usuarios',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./Dashboard/Views/User/User.vue'),
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
                        component: require('./Dashboard/Views/Client/Client.vue'),
                        name: 'clients'
                    },
                    {
                        path: 'criar',
                        component: require('./Dashboard/Views/Client/Create.vue'),
                        name: 'clients.create'
                    },
                    {
                        path: 'editar/:clients_id',
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
                        path: '/',
                        component: require('./Dashboard/Views/Bill/Bill.vue'),
                        name: 'bills'
                    },
                    {
                        path: '/criar',
                        component: require('./Dashboard/Views/User/Create.vue'),
                        name: 'bills.create'
                    },
                    {
                        path: '/editar/:bill_id',
                        name: 'bills.edit',
                        component: require('./Dashboard/Views/User/Edit.vue'),
                        props: true
                    }
                ]
            }
        ]
    }

    
]

function requireAuth(to, from, next) {
    if(store.getters.isLogged) {
        next(false)
    }else{
        next()
    }
}