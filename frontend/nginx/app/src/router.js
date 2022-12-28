import { createRouter,createWebHistory } from 'vue-router';
import LoginView from "./components/LoginView.vue";
import MattersComponent from "./components/matters/MattersComponent.vue";
 
const routes = [
    { path: '/', name: 'matters', component: MattersComponent },
    { path: '/login', name: 'login', component: LoginView },
]
 
const router = createRouter({
    history: createWebHistory(), // HTML5 History モード
    routes,
})
 
export default router;