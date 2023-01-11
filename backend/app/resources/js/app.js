import './bootstrap';
import { createApp } from 'vue'
import '../css/style.css'
import App from './App.vue'
import router from './router.js'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
import 'bootstrap-icons/font/bootstrap-icons.css'


const app = createApp(App)
app.use(router)
app.mount('#app')
