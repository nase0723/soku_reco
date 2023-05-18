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
</script>

<template>
    <div class="container mt-3">
        <div class="row d-flex mb-3">
            <div class="col-9">
                <h1>
                    <span class="badge bg-dark">
                        {{ appointment.matter && appointment.matter.name }}
                    </span>
                    <span class="badge bg-dark ml-1">
                        <router-link :to="{ name: 'MatterDetail', params: { id: String(appointment.matter.id) } }" class="text-decoration-none text-white">
                             <i class="bi bi-search"></i>
                        </router-link>
                    </span>
                </h1>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <button class="btn btn-dark btn-lg" @click="router.push({name: 'EditAppointment', params: {id : id}})">
                    <i class="bi bi-pencil"></i>
                </button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <h3><label for="place" class="text-secondary">場所</label></h3>
            </div>
            <div class="col-9">
                <input type="text" class="form-control" id="place" :value="appointment && appointment.place" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <h3><label for="date" class="text-secondary">日付</label></h3>
            </div>
            <div class="col-9">
                <input type="text" class="form-control" id="date" :value="appointment && appointment.date" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <h3><label for="time" class="text-secondary">時間</label></h3>
            </div>
            <div class="col-9">
                <input type="text" class="form-control" id="time" :value="appointment && appointment.time" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <h3><label for="remarks" class="text-secondary">備考</label></h3>
            </div>
            <div class="col-9">
                <textarea class="form-control" :value="appointment && appointment.remarks" id="remarks" rows="3" disabled></textarea>
            </div>
        </div>
    </div>
</template>