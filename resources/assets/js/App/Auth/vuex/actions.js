import axios from 'axios'

export const attemptLogin = (context, payload) => {
    return axios.post('/api/login', payload)
        .then(({ data }) => {
            //set vuex states
            context.commit('setToken', data.token)
            context.commit('setUser', data.user)            
        })
}