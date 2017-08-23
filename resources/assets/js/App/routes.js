//Main do dashboard
import DashboardMain from './Dashboard/Domains/Main.vue'
//Main de Auth
import AuthMain from './Auth/components/Main.vue'

//import AuthPersistence from '../plugins/AuthPersistence/index.js'
import store from '../vuex/'

export default [
    {
        path: '/login',
        component: AuthMain,
        children: [
            {
                path: '/',
                component: require('./Auth/components/Forms/Login.vue'),
                beforeEnter: (to, from, next) => {
                    if(store.getters.isLogged) {
                        next(false)
                    }else{
                        next()
                    }
                }
            }
        ]
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardMain,
        meta: {
            requireAuth: true
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
            }
        ]
    }
]