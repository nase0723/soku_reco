<script setup>
import axios from "axios";
// import { useRouter } from 'vue-router';
import { ref, onBeforeMount } from "vue";
const baseUrl = 'http://localhost:8000';

const http = axios.create({
  baseURL: baseUrl,
  withCredentials: true,
});

const matters = ref();

onBeforeMount(async () => {
    getmMtters();
//   let checked = await http.get('/api/check');
//   if (checked.data) {
//     router.push('/');
//   } 
});

const getmMtters = async () => {
    try {
        const response = await http.get('/api/matters');
        matters.value = response.data.matters;
    } catch (e) {
        console.log(e);
    }
}
</script>
<template>
    <table class="table table-dark table-hover mt-5">
        <thead>
            <tr>
                <th class="text-center">名前</th>
                <th class="text-center">年齢</th>
                <th class="text-center">場所</th>
                <th class="text-center">職業</th>
                <th class="text-center">詳細</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="matter in matters">
                <td class="text-center">{{ matter.name }}</td>
                <td class="text-center">{{ matter.age }}</td>
                <td class="text-center">{{ matter.place.name }}</td>
                <td class="text-center">{{ matter.name }}</td>
                <td class="text-center">
                    <button class="btn btn-outline-light">詳細</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>