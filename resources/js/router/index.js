

import { createRouter, createWebHistory } from 'vue-router';

import CompanyList from '../pages/companyList.vue';
import Register from '../pages/register.vue';
import Login from '../pages/login.vue';
import Home from '../pages/home.vue';
import DefaultLayout from '../Layout/layout.vue';
import Auth from '../Auth';

import CompanyRegister from '../pages/companyRegister.vue';
import CompanyLogin from '../pages/CompanyLogin.vue';

//
import settings from '../pages/setting/index.vue';


import UserManager from '../pages/setting/user/index.vue';
import Users from '../pages/setting/user/list.vue';
import Permission from '../pages/setting/user/list.vue';


const routes = [
    {
        path: '/',
        component: CompanyList,
        name: 'company',
        meta: { requiresAuth: false },
    },
    {
        path: '/company',
        component: CompanyRegister,
        name: 'company-register',
        meta: { requiresAuth: false },
    },

    {
        path: '/login',
        component: CompanyLogin,
        name: 'login',
        meta: { requiresAuth: false },
        props: (route) => ({ q: route.query.q })
    },

    {
        path: '/register',
        component: Register,
        name: 'register',
        meta: { requiresAuth: false },
    },

    {
        path: '/home',
        component: DefaultLayout,
        name: 'layout',
        meta: { requiresAuth: true },
        children: [
            {
                path: '',
                component: Home,
                name: 'home',
                meta: { requiresAuth: true },
            },
            {
                path: 'settings',
                name: 'Setting',
                component: settings,
                meta: {
                    requiresAuth: true
                },
                children: [
                    {
                        path: 'user-management',
                        name: 'UserManagement',
                        component: UserManager,
                        meta: {
                            requiresAuth: true
                        },
                        children: [
                            {
                                path: 'users',
                                name: 'user',
                                component: Users,
                                meta: {
                                    requiresAuth: true
                                },
                            },
                            {
                                path: 'permission',
                                name: 'permission',
                                component: Permission,
                                meta: {
                                    requiresAuth: true
                                },
                            },
                        ]
                    },
                ]
            },

        ]
    }

];


const router = createRouter({
    history: createWebHistory(),
    routes,
});


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      const isAuthenticated = Auth.check();

      if (isAuthenticated!=null||isAuthenticated!=undefined) {
        Auth.verify()
          .then(result => {
            if (result) {
              next();
            } else {
              router.push('/');
            }
          })
          .catch(error => {
            router.push('/');
          });
      } else {
        router.push('/');
      }
    } else {
      next();
    }
  });

export default router;
