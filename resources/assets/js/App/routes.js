//Main do dashboard
import DashboardMain from './Dashboard/Domains/Main.vue'
//Main de Auth
import AuthMain from './Auth/components/Main.vue'

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
                component: require('./Dashboard/Domains/User/User.vue'),
                name: 'users'
            },
            {
                path: 'usuarios/criar',
                component: require('./Dashboard/Domains/User/Create.vue'),
                name: 'users.create'
            },
            {
                path: 'usuarios/editar/:user_id',
                name: 'users.edit',
                component: require('./Dashboard/Domains/User/Edit.vue'),
                props: true
            },

            //profile avatar
            {
                path: 'avatar',
                name: 'change.avatar',
                component: require('./Dashboard/Domains/User/profile/Avatar.vue')
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