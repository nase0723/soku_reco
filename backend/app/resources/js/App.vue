<script setup>
import HeaderComponent from './components/layouts/HeaderComponent.vue'
import FooterComponent from './components/layouts/FooterComponent.vue'
// import axios from "axios";

const baseURL = 'http://localhost:8000';
const http = axios.create({
    baseURL: baseURL,
    withCredentials: true,
});
</script>

<template>
    <HeaderComponent :http="http"/>
    <router-view :http="http"/>
    <FooterComponent/>
</template>

