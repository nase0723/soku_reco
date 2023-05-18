<script setup>
import { useRouter } from 'vue-router';
import { ref, onBeforeMount } from "vue";
const props = defineProps({
    http: Function,
    id: String,
})
const http = props.http
const id = props.id
const router = useRouter();
const appointment = ref({
    date: null,
    time: null,
});
const dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ];

onBeforeMount(() => {
    getAppointment();
});

const redirectToLoginPage = () => router.push({name : 'login'});

const getAppointment = async () => {
    try {
        const response = await http.get('/api/appointments/' + id);
        if (response.status == 200) {
            appointment.value = response.data.appointment;
            appointment.value.date = appointment.value.appointment_date.substr(0, 10).replace(/-/g, '/').replace(/\/0/g, '/').replace((new Date().getFullYear()) + '/', '') +'(' + dayOfWeekStrJP[(new Date(appointment.value.appointment_date.replace(/-/g, '/'))).getDay()] + ')';
            appointment.value.time = appointment.value.appointment_date.slice(-8).replace(/:00/, '');
        }
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        console.log(e);
    }
}

const updateAppointment = async () => {
    try {
        const response = await http.put('/api/appointments/' + id, appointment.value);
        if (response.status == 200) {
            router.push({name: 'AppointmentDetail', params: { id: String(id) }});
        }
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        console.log(e);
    }
}

const DeleteAppointment = async () => {
    try {
        const response = await http.delete('/api/appointments/' + id);
        if (response.status == 200) {
            router.push({name: 'appointments'});
        }
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        console.log(e);
    }
}
</script>
<template>
    <div class="container mt-3">
        <div class="row d-flex mb-3">
            <div class="col-9">
                <h1>
                    <span class="badge bg-dark">
                        {{ appointment.matter && appointment.matter.name }}
                    </span>
                </h1>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <button class="btn btn-dark btn-lg" @click="DeleteAppointment">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        <form @submit.prevent="updateAppointment">
            <div class="row mb-3">
                <div class="col-3">
                    <h3><label for="place" class="text-secondary">場所</label></h3>
                </div>
                <div class="col-9">
                    <input type="text" class="form-control" id="place" v-model="appointment.place">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <h3><label for="appointment_date" class="text-secondary">時刻</label></h3>
                </div>
                <div class="col-9">
                    <input type="datetime-local" class="form-control" id="appointment_date" v-model="appointment.appointment_date">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <h3><label for="remarks" class="text-secondary">備考</label></h3>
                </div>
                <div class="col-9">
                    <textarea class="form-control" v-model="appointment.remarks" id="remarks" rows="3"></textarea>
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-dark mx-auto w-50">変更</button>
            </div>
        </form>
    </div>
</template>