import { createRouter,createWebHistory } from 'vue-router';
import LoginView from "./components/LoginView.vue";
import MattersComponent from "./components/matters/MattersComponent.vue";
import MatterDetail from "./components/matters/MatterDetail.vue";
import EditMatter from "./components/matters/EditMatter.vue";
import SearchResults from "./components/matters/SearchResults.vue";
 
const routes = [
    { path: '/login', name: 'login', component: LoginView },
    { path: '/', name: 'matters', component: MattersComponent, props: true },
    { path: '/detail/:id', name: 'MatterDetail', component: MatterDetail, props: true },
    { path: '/edit/:id', name: 'EditMatter', component: EditMatter, props: true },
    { path: '/search', name: 'SearchResults', component: SearchResults, props: true },
]
 
const router = createRouter({
    history: createWebHistory(), // HTML5 History モード
    routes,
})
 
export default router;