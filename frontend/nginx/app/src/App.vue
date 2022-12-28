<script setup>
import HeaderComponent from './components/layouts/HeaderComponent.vue'
import FooterComponent from './components/layouts/FooterComponent.vue'
</script>

<template>
    <HeaderComponent/>
    <router-view></router-view>
    <FooterComponent/>
</template>

<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
