<script setup>
// import { useRouter } from 'vue-router';
import { ref, onBeforeMount } from "vue";
const props = defineProps({
    http: Function,
    id: String,
})
const http = props.http
const id = props.id
console.log(id);

const matters = ref();
</script>

<template>
        
</template>