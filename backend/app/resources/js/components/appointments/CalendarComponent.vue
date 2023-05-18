<script setup>
import { ref, reactive, onBeforeMount, computed } from "vue";
import moment from "moment";
const props = defineProps({
    http: Function,
})
const http = props.http
const currentDate = ref(moment());
const dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ];
const calendar = ref([]);
const matters = ref([]);
const appointmentToCreate = ref({});
const createdAppointment = ref({});
const errors = ref();

const getCalendar = async () => {
    try {
        const response = await http.get(`/api/appointments/calendar/${currentDate.value.year()}/${currentDate.value.month() + 1}`);
        calendar.value = response.data.calendar;
    } catch (e) {
        console.log(e);
    }
}

const nextMonth = () => {
    currentDate.value = moment(currentDate.value).add(1, "month");
    getCalendar();
} 
const prevMonth = () => {
    currentDate.value = moment(currentDate.value).subtract(1, "month");
    getCalendar();
} 

const redirectToLoginPage = () => router.push({name : 'login'});

const closeModal = () => document.getElementById('btnCloseModal').click();

const createAppointment = async () => {
    try {
        const response = await http.post('/api/appointments', appointmentToCreate.value);
        if (response.status == 200) {
            createdAppointment.value = response.data.appointment;
            getCalendar();
            closeModal();
        }
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        errors.value = e.response.data.errors;
    }
}

const getMatters = async (orderBy) => {
    try {
        const response = await http.get(`/api/matters?column=${orderBy.column}&type=${orderBy.type}`);
        matters.value = response.data.matters;
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        console.log(e);
    }
}

const setDateValue = (day) => {
    let date = day.date;
    if (date.length == 1) {
        date = '0' + date;
    }
    appointmentToCreate.value.appointment_date = day.year + '-' + day.month + '-' + date + 'T19:30';
    
}

getCalendar();
getMatters({ column: 'created_at', type: 'desc' });
</script>
<template>
    <div class="container mt-3">
        <h2 class="mb-3"> {{ currentDate.format("M") }}月 アポ予定</h2>
        <div class="mb-3">
            <button @click="prevMonth">＜前の月＞</button>
            <button @click="nextMonth">＜次の月＞</button>
        </div>
        <p>※日付タップで新しい予定を追加</p>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th v-for="i in 7" :class="{'text-danger': i === 1, 'text-primary': i === 7}" style="width: 50px;">
                        {{ dayOfWeekStrJP[i - 1] }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(week, index) in calendar" :key="index">
                    <td v-for="(day, index) in week" :key="index">
                        <span class="fw-bolder" style="font-size: 23px;">
                            <a href="#" class="text-decoration-none" :class="day.appointments.length ? 'text-dark' : 'text-secondary'" data-bs-target="#staticBackdrop" data-bs-toggle="modal" @click="setDateValue(day)">
                            <!-- <a href="#" class="text-decoration-none" :class="day.appointments.length ? 'text-dark' : 'text-secondary'" @click="showModal()"> -->
                                {{ day.date }}
                            </a>
                        </span>
                        <span v-for="appointment in day.appointments" style="font-size: 23px;" >
                            <br>
                            <router-link :to="{name : 'AppointmentDetail', params: { id: String(appointment.id) } }" class="text-decoration-none">
                                {{ appointment.matter.name }}
                            </router-link>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- アポ設定 -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">アポセッティング</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btnCloseModal"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="createAppointment">
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="matter_id" class="col-form-label">案件名
                                    <!-- <br><span class="badge bg-danger">必須</span> -->
                                </label>
                            </div>
                            <div class="col-9">
                                <select class="form-select" id="matter_id" v-model="appointmentToCreate.matter_id">
                                    <option :value="matter.id" v-for="matter in matters">
                                        {{ matter.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="place" class="col-form-label">場所</label>
                            </div>
                            <div class="col-9">
                                <input type="text" v-model="appointmentToCreate.place" class="form-control" id="place">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="appointment_date" class="col-form-label">日付</label>
                            </div>
                            <div class="col-9">
                                <input type="datetime-local" v-model="appointmentToCreate.appointment_date" class="form-control" id="appointment_date">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="inputRemarks" class="col-form-label">備考</label>
                            </div>
                            <div class="col-9">
                                <textarea class="form-control" v-model="appointmentToCreate.remarks" id="inputRemarks" rows="2"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="alert alert-danger" role="alert" v-for="error in errors">{{ error[0] }}</div>
                        <div class="row mt-3">
                            <button type="submit" class="btn btn-dark mx-auto w-50">登録</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                </div> -->
            </div>
        </div>
    </div>
</template>