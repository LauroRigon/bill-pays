import { isEmpty } from 'lodash'

const loaderFactory = (context, store) => {
    return {
        storeToken() {
            let token = store.getters.getToken
            localStorage.setItem('access_token', token)
        },

        storeUser() {
            let userLogged = store.getters.getUserLogged
            localStorage.setItem('user_logged', JSON.stringify(userLogged))
        },

        setVuexToken() {
            let token = localStorage.getItem('access_token')
            if(!isEmpty(token)){
                store.commit('setToken', token)
            }
        },

        setVuexUser() {
            let userLogged = localStorage.getItem('user_logged')
            if(!isEmpty(userLogged)){
                store.commit('setUser', JSON.parse(userLogged))
            }
        }
    }
}

export default loaderFactory