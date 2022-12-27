import { createRouter,createWebHistory } from 'vue-router';
import LoginView from "./components/LoginView.vue";
 
const routes = [
    { path: '/login', name: 'login', component: LoginView },
]
 
const router = createRouter({
    history: createWebHistory(), // HTML5 History モード
    routes,
})
 
export default router;