import { defaults } from 'lodash'
import { authPersistence } from '../services'
import axios from 'axios'

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
            window.location.reload()
          }
        }
  
        return Promise.reject(error)
      })
  }
}