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
</script>

<template>
        
</template>