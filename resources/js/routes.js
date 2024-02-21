import { createRouter, createWebHistory } from "vue-router";
import store from './store';



const routes = [
    { path: '/', component: ()=>import('./App.vue')},
    { path: '/register', component: ()=>import('./pages/register.vue')},
    { 
         path: '/login',
         component: ()=>import('./pages/login.vue'),
         name: 'login' 
    },
    { 
        path: '/dashboard',
        component: ()=>import('./pages/dashboard.vue'),
        name: 'dashboard',
        meta: { requiresAuth: true },
        },
    { 
        path: '/blogs',
        component: ()=>import('./pages/Allblogs.vue'),
        name: 'blogs',
        meta: { requiresAuth: true },
        },
    { 
        path: '/my/blogs',
        component: ()=>import('./pages/Myblogs.vue'),
        name: 'myBlogs',
        meta: { requiresAuth: true },
        },
  ]
  

  const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass:'active-blog'
  });
  // Add a navigation guard to protect the dashboard route
router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);
  const isAuthenticated = !!store.state.token; // Check if the user is authenticated (token exists)

  if (requiresAuth && !isAuthenticated) {
    // If the route requires authentication and the user is not authenticated, redirect to the login page
    next({ name: 'login' });
  } else {
    // If the route does not require authentication or the user is authenticated, allow the navigation
    next();
  }
});

  export default router;
  