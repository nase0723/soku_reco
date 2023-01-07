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
        const response = await http.get(`/api/appointments/calendar/${currentDate.value.year()}/${currentDate.value.month()}`);
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
        <h2>カレンダー {{ currentDate.format("M") }}月</h2>
        <button @click="prevMonth">前の月</button>
        <button @click="nextMonth">次の月</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th v-for="i in 7" :class="{'text-danger': i === 1, 'text-primary': i === 7}">
                        {{ dayOfWeekStrJP[i - 1] }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(week, index) in calendar" :key="index">
                    <td v-for="(day, index) in week" :key="index">
                        {{ day.date }}
                        <!-- {{ day.appointments }} -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</template>