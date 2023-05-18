import { createRouter,createWebHistory } from 'vue-router';
import LoginView from "./components/LoginView.vue";
import MattersComponent from "./components/matters/MattersComponent.vue";
import MatterDetail from "./components/matters/MatterDetail.vue";
import EditMatter from "./components/matters/EditMatter.vue";
import SearchResults from "./components/matters/SearchResults.vue";
import AppointmentsComponent from "./components/appointments/AppointmentsComponent.vue";
import AppointmentDetail from "./components/appointments/AppointmentDetail.vue";
import EditAppointment from "./components/appointments/EditAppointment.vue";
import CalendarComponent from "./components/appointments/CalendarComponent.vue";
 
const routes = [
    { path: '/login', name: 'login', component: LoginView, meta: { guest: true } },

    // 案件
    { path: '/', name: 'matters', component: MattersComponent, meta: { requiresAuth: true }, props: true },
    { path: '/detail/:id', name: 'MatterDetail', component: MatterDetail, meta: { requiresAuth: true }, props: true },
    { path: '/edit/:id', name: 'EditMatter', component: EditMatter, meta: { requiresAuth: true }, props: true },
    { path: '/search/:keyword', name: 'SearchResults', component: SearchResults, meta: { requiresAuth: true }, props: true },

    // アポ
    { path: '/appointments', name: 'appointments', component: AppointmentsComponent, meta: { requiresAuth: true }, props: true },
    { path: '/appointments/detail/:id', name: 'AppointmentDetail', component: AppointmentDetail, meta: { requiresAuth: true }, props: true },
    { path: '/appointments/edit/:id', name: 'EditAppointment', component: EditAppointment, meta: { requiresAuth: true }, props: true },
    { path: '/appointments/calendar', name: 'calendar', component: CalendarComponent, meta: { requiresAuth: true }, props: true },
]
 
const router = createRouter({
    history: createWebHistory(), // HTML5 History モード
    routes,
})

router.beforeEach(async (to) => {
    if (to.meta.requiresAuth || to.meta.guest) {
        const response = await axios.get('/api/check');
        // console.log(response);
        if (to.meta.requiresAuth && !response.data) {
            return { name: "login" };
        }
        if (to.meta.guest && response.data) {
            return { name: "home" };
        }
      }
    return true;
  });
 
export default router;