<script setup>
import HeaderComponent from './components/layouts/HeaderComponent.vue'
import FooterComponent from './components/layouts/FooterComponent.vue'

// const baseURL = 'https://eb8b-126-51-90-37.ngrok.io';
const http = axios.create({
    // baseURL: baseURL,
    withCredentials: true,
});
</script>

<template>
    <HeaderComponent :http="http"/>
    <router-view :http="http"/>
    <FooterComponent/>
</template>

