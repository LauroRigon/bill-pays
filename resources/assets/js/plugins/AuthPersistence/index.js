import loaderFactory from './loaderFactory.js'

const install = (Vue, store) => {
    Object.defineProperty(Vue.prototype, '$authPersistence', {
        get() {
            return loaderFactory(this, store)
        }
    })
}

//to call function without vue
const factory = (store) => {
    return loaderFactory(this, store)
}

export default { install, factory }