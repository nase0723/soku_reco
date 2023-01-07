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


const getCalendar = async () => {
    try {
        console.log(`/api/appointments/calendar/${currentDate.value.year()}/${currentDate.value.month() + 1}`);
        const response = await http.get(`/api/appointments/calendar/${currentDate.value.year()}/${currentDate.value.month() + 1}`);
        calendar.value = response.data.calendar;
        console.log(calendar.value);
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

getCalendar();
</script>
<template>
    <div class="container mt-5">
        <h2 class="mb-3"> {{ currentDate.format("M") }}月 アポ予定</h2>
        <button @click="prevMonth">前の月</button>
        <button @click="nextMonth">次の月</button>
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
                        <span class="fw-bolder">
                            {{ day.date }}
                        </span>
                        <!-- <div v-if="day.appointments.length"> -->
                            <span v-for="appointment in day.appointments" style="font-size: 12px;" >
                                <br>
                                <router-link :to="{name : 'AppointmentDetail', params: { id: String(appointment.id) } }" class="text-decoration-none">
                                    {{ appointment.matter.name }}
                                </router-link>
                            </span>
                        <!-- </div> -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</template>