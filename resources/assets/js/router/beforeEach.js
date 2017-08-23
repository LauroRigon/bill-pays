import store from '../vuex'
import AuthPersistence from '../plugins/AuthPersistence/index.js'
import { isNull } from 'lodash'

export default (to, from, next) => {
    sessionFromStorage()

    if(!isProtectedRoute(to) || isUserAuth()){
        next()
    }else{
        next('/login')
    }
}

const isProtectedRoute = (route) => {
    console.log(route)
    let parentRoute = route.matched[0];
    
    if (route.meta.requireAuth || isNull(parentRoute)) {
        return true;
    }

    return false;
}

const isUserAuth = () => store.getters.isLogged

const sessionFromStorage = () => {
    let factory = AuthPersistence.factory(store)

    factory.setVuexToken()
    factory.setVuexUser()
}