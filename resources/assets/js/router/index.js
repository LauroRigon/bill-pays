import Vue from 'vue'

import VueRouter from 'vue-router'

//rotes
import routes from '../App/routes.js'

//beforeEach function that verify wether user can access some route
import beforeEach from './beforeEach.js'

Vue.use(VueRouter)

const router = new VueRouter({
  routes,
  //mode: 'history',
  linkActiveClass: 'list__tile--active',
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
})

//router.beforeEach(beforeEach)

export default router