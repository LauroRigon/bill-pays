import { defaults } from 'lodash'
import { authPersistence } from '../services'
import axios from 'axios'

/*export const createClient =  axios.create()

export const init = () => {
    createClient.defaults.baseURL = '/api'

    //add Authorization header to request
    createClient.interceptors.request.use(function(config) {
        config.headers.Authorization = "Bearer " + AuthPersistence.getStoredToken()
        console.log(config)
        return config
    })

    createClient.interceptors.response.use(response => {
        return response
      }, error => {
        // Also, if we receive a Bad Request / Unauthorized error
        if (error.response.status === 400 || error.response.status === 401) {
          // and we're not trying to login
          if (!(error.config.method === 'post' && /\/api\/me\/?$/.test(error.config.url))) {
            // the token must have expired. Log out.
            AuthPersistence.removeSession()
            Materialize.toast('Parece que sua sesão expirou!')
          }
        }
  
        return Promise.reject(error)
      })
    
}*/

//export default createClient

export const http = {
  axiosInstance: axios.create(),


  get(url, successCb = null, errorCb = null) {
    return this.axiosInstance.get(url, successCb, errorCb)
  },

  post(url, data, successCb = null, errorCb = null) {
    return this.axiosInstance.post(url, data, successCb, errorCb)
  },

  put(url, data, successCb = null, errorCb = null) {
    return this.axiosInstance.put(url, data, successCb, errorCb)
  },

  delete(url, data = {}, successCb = null, errorCb = null) {
    return this.axiosInstance.delete(url, data, successCb, errorCb)
  },

  //start configs to axios
  init() {
    this.axiosInstance.defaults.baseURL = '/api'
    let token = document.head.querySelector('meta[name="csrf-token"]');
    
    if (token) {
      this.axiosInstance.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    }

    //add Authorization header to every request
    this.axiosInstance.interceptors.request.use(function(config) {
        config.headers.Authorization = "Bearer " + authPersistence.getStoredToken()
        return config
    })

    this.axiosInstance.interceptors.response.use(response => {
        return response
      }, error => {
        console.log(error)
        // Also, if we receive a Bad Request / Unauthorized error
        if (error.response.status === 400 || error.response.status === 401) {
          // and we're not trying to login
          if (error.config.url != '/api/login') {
            // the token must have expired. Log out.
            authPersistence.removeSession()
            Materialize.toast('Parece que sua sessão expirou!', 3000, null, () => window.location.reload())
          }
        }

        if(error.response.status === 403){
          Materialize.toast('Você não pode fazer isso!', 3000)
        }
  
        return Promise.reject(error)
      })
  }
}