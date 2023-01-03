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
    { path: '/login', name: 'login', component: LoginView },

    // 案件
    { path: '/', name: 'matters', component: MattersComponent, props: true },
    { path: '/detail/:id', name: 'MatterDetail', component: MatterDetail, props: true },
    { path: '/edit/:id', name: 'EditMatter', component: EditMatter, props: true },
    { path: '/search/:keyword', name: 'SearchResults', component: SearchResults, props: true },

    // アポ
    { path: '/appointments', name: 'appointments', component: AppointmentsComponent, props: true },
    { path: '/appointments/detail/:id', name: 'AppointmentDetail', component: AppointmentDetail, props: true },
    { path: '/appointments/edit/:id', name: 'EditAppointment', component: EditAppointment, props: true },
    { path: '/calendar', name: 'calendar', component: CalendarComponent, props: true },
]
 
const router = createRouter({
    history: createWebHistory(), // HTML5 History モード
    routes,
})
 
export default router;