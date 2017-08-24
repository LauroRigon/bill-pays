import store from '../vuex'
import AuthPersistence from '../plugins/AuthPersistence/index.js'

export default (to, from, next) => {
    sessionFromStorage()

    if(!isProtectedRoute(to) || isUserAuth()){
        next()
    }else{
        next('/login')
    }
}

const isProtectedRoute = (route) => {
    let parentRoute = route.matched;

    if (route.meta.requireAuth || parentRoute.find(isParentProtected)) {
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

const isParentProtected = (route) => {
    return route.meta.requireAuth
}