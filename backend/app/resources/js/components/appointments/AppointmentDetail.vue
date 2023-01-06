<script setup>
import { ref, onBeforeMount } from "vue";
import { useRouter } from 'vue-router';
const props = defineProps({
    http: Function,
    id: String,
})
const http = props.http
const id = props.id
const router = useRouter();
const appointment = ref({});

onBeforeMount(() => {
    getAppointment();
});

const getAppointment = async () => {
    try {
        const response = await http.get('/api/appointments/' + id);
        if (response.status == 200) {
            appointment.value = response.data.appointment;
            console.log(appointment.value);
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
        
</template>