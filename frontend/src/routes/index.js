import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/Login.vue'
import Dashboard from '../pages/Dashboard.vue'
import Employees from '../pages/Employees.vue'
import Divisions from '../pages/Divisions.vue'
import Positions from '../pages/Positions.vue'
import EmployeeJobs from '../pages/EmployeeJobs.vue'

const routes = [
    { path: '/', component: Dashboard },
    { path: '/login', component: Login, meta: { requiresAuth: true } },
    { path: '/employees', component: Employees, meta: { requiresAuth: true } },
    { path: '/divisions', component: Divisions, meta: { requiresAuth: true } },
    { path: '/positions', component: Positions, meta: { requiresAuth: true } },
    { path: '/employee-jobs', component: EmployeeJobs, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const isLoggedIn = !!localStorage.getItem('token');
  
    if (to.meta.requiresAuth && !isLoggedIn) {
      next('/login');
    } else if (to.path === '/login' && isLoggedIn) {
      next('/'); // Redirect logged-in users away from login
    } else {
      next();
    }
});

export default router;
