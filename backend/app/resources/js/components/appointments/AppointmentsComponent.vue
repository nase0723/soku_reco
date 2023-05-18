<script setup>
import { ref, onBeforeMount } from "vue";
import { useRouter } from 'vue-router';
const props = defineProps({
    http: Function,
})
const http = props.http
const router = useRouter();
const matters = ref();
const newMatter = ref({});
const errors = ref();
const appointments = ref();
const appointmentToCreate = ref({});
const createdAppointment = ref({});
const dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ];

onBeforeMount(() => {
    getMatters({ column: 'created_at', type: 'desc' });
    getAppointments();
    initModal();
});

const redirectToLoginPage = () => router.push({name : 'login'});

const initModal = () => {
    newMatter.value = {}
    errors.value = {};
};

const closeModal = () => document.getElementById('btnCloseModal').click();

const getAppointments = async () => {
    try {
        const response = await http.get(`/api/appointments`);
        appointments.value = response.data.appointments;
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        console.log(e);
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

const createAppointment = async () => {
    try {
        const response = await http.post('/api/appointments', appointmentToCreate.value);
        if (response.status == 200) {
            createdAppointment.value = response.data.appointment;
            getAppointments();
            closeModal();
        }
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        errors.value = e.response.data.errors;
    }
}

</script>

<template>

    <div class="container mb-3 mt-3">
        <div class="row justify-content-between">
            <div class="col-9">
                <!-- <h3 class="text-secondary">アポ一覧</h3> -->
                <!-- <router-link :to="{name: 'calendar'}"  class="link-danger text-decoration-none">カレンダー表示</router-link> -->
                <div class="mt-4">
                    <router-link :to="{name: 'calendar'}" class="btn btn-danger"><i class="bi bi-calendar-check"></i> カレンダー</router-link>
                </div>
            </div>
            <div class="col-3 mb-4">
                <button type="button" class="btn btn-danger rounded-circle p-0 position-fixed"
                    style="width:4rem; height:4rem; font-size:35px;" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop" @click="initModal">＋</button>
            </div>
        </div>
    </div>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th class="text-center">名前</th>
                <th class="text-center">日時</th>
                <th class="text-center">場所</th>
                <th class="text-center">詳細</th>
            </tr>
        </thead>
        <tbody>
            <template v-for="appointment in appointments">
                <tr :class="{'table-secondary': (new Date()) < (new Date(appointment.appointment_date.replace(/-/g, '/'))) }">
                    <td class="text-center">{{ appointment.matter.name }}</td>
                    <td class="text-center">
                        {{ appointment.appointment_date.substr(0, 10).replace(/-/g, '/').replace(/\/0/g, '/').replace((new Date().getFullYear()) + '/', '') }}
                        {{ '(' + dayOfWeekStrJP[(new Date(appointment.appointment_date.replace(/-/g, '/'))).getDay()] + ')' }}
                        <br>
                        {{ appointment.appointment_date.slice(-8).replace(/:00/, '') }}
                    </td>
                    <td class="text-center">{{ appointment.place }}</td>
                    <td class="text-center">
                        <router-link :to="{ name: 'AppointmentDetail', params: { id: String(appointment.id) } }" class="btn btn-danger">
                            <i class="bi bi-search"></i>
                        </router-link>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
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