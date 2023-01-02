<script setup>
import HeaderComponent from './components/layouts/HeaderComponent.vue'
import FooterComponent from './components/layouts/FooterComponent.vue'
import axios from "axios";

const baseUrl = 'http://localhost:8000';
const http = axios.create({
    baseURL: baseUrl,
    withCredentials: true,
});
</script>

<template>
    <HeaderComponent :http="http"/>
    <router-view :http="http"/>
    <FooterComponent/>
</template>

