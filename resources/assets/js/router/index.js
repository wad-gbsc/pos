import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '@/containers/Full'

// Views
import Dashboard from '@/views/Dashboard'

// Views - Pages
import Page404 from '@/views/pages/Page404'
import Page500 from '@/views/pages/Page500'
import Login from '@/views/pages/Login'
import Logout from '@/views/pages/Logout'
import Register from '@/views/pages/Register'
import pos from '@/views/pages/pos'

//Views - References
import departments from '@/views/references/Departments'
import categories from '@/views/references/Categories'
import units from '@/views/references/Units'
import cardtypes from '@/views/references/Cardtypes'
import checktypes from '@/views/references/Checktypes'
import gctypes from '@/views/references/GCtypes'
import discounttypes from '@/views/references/Discounttypes'
import suppliers from '@/views/references/Suppliers'
import products from '@/views/references/Products'
import purchaseorderlists from '@/views/inventory/purchaseorderlists'
import receivinglists from '@/views/inventory/receivinglists'
import issuance from '@/views/inventory/issuance'
import adjustmentlists from '@/views/inventory/adjustmentlists'


import store from '../store'
Vue.use(Router)

const router = new Router({
  mode: 'hash', // Demo is living in GitHub.io, so required!
  linkActiveClass: 'open active',
  scrollBehavior: () => ({ y: 0 }),
  routes: [
    {
      path: '/',
      redirect: 'dashboard',
      name: 'Home',
      component: Full,
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard,
          meta: { requiresAuth: true },
        },
        {
          path: 'references',
          name: 'References',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'departments',
              name: 'Departments',
              component: departments,
              meta: {requiresAuth: true}
            },
            {
              path: 'categories',
              name: 'Categories',
              component: categories,
              meta: {requiresAuth: true}
            },
            {
              path: 'units',
              name: 'Units',
              component: units,
              meta: {requiresAuth: true}
            },
            {
              path: 'cardtypes',
              name: 'Card Types',
              component: cardtypes,
              meta: {requiresAuth: true}
            },
            {
              path: 'checktypes',
              name: 'Check Types',
              component: checktypes,
              meta: {requiresAuth: true}
            },
            {
              path: 'gctypes',
              name: 'GC Types',
              component: gctypes,
              meta: {requiresAuth: true}
            },
            {
              path: 'discounttypes',
              name: 'Discount Types',
              component: discounttypes,
              meta: {requiresAuth: true}
            },
            {
              path: 'suppliers',
              name: 'Suppliers',
              component: suppliers,
              meta: {requiresAuth: true}
            },
            {
              path: 'products',
              name: 'Products',
              component: products,
              meta: {requiresAuth: true}
            },
          ]
        },
        {
          path: 'inventory',
          name: 'Inventory',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'purchaseorderlists',
              name: 'Purchase Order Lists',
              component: purchaseorderlists,
              meta: {requiresAuth: true}
            },
            {
              path: 'receivinglists',
              name: 'Receiving Lists',
              component: receivinglists,
              meta: {requiresAuth: true}
            },
            {
              path: 'issuance',
              name: 'Issuance Lists',
              component: issuance,
              meta: {requiresAuth: true}
            },
            {
              path: 'adjustmentlists',
              name: 'Adjustment Lists',
              component: adjustmentlists,
              meta: {requiresAuth: true}
            },
          ]
        },
        // {
        //   path: 'accounts',
        //   name: 'Accounts',
        //   component: {
        //     render (c) { return c('router-view') }
        //   },
        //   children: [
        //     {
        //       path: 'users',
        //       name: 'Users',
        //       component: users,
        //       meta: {requiresAuth: true, rights: '10-37'}
        //     },
        //     {
        //       path: 'user_groups',
        //       name: 'User Groups',
        //       component: usergroups,
        //       meta: {requiresAuth: true, rights: '11-41'}
        //     },
        //     {
        //       path: 'company_settings',
        //       name: 'Company Settings',
        //       component: companysettings,
        //       meta: {requiresAuth: true, rights: '12-45'}
        //     }
        //   ]
        // },
      ]
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/logout',
      name: 'Logout',
      component: Logout
    },
    {
      path: '*',
      name:'404', 
      component: Page404
    },
    {
      path: '/pos',
      name:'POS', 
      component: pos
    },
  ]
})
export default router
router.beforeEach((to, from, next) => {

  // check if the route requires authentication and user is not logged in
  if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
    // redirect to login page
    next({ name: 'Login' })
    return
  }

// if logged in redirect to dashboard
  if(to.path === '/login' && store.state.isLoggedIn) {
      next({name: from.name})
      return
  }

next()
})
