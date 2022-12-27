<script setup>
import axios from "axios";
import { useRouter } from 'vue-router';
import { ref, onMounted } from "vue";

const router = useRouter();
const user = ref();
const validate_message = ref();
const baseUrl = 'http://localhost:8000';

const http = axios.create({
  baseURL: baseUrl,
  withCredentials: true,
});

onMounted(async () => {
  console.log("on mount");
  let checked = await http.get('/api/check');
  if (checked.data) {
    router.push('/');
  } 
});

const login = async (name) => {
  try {
    await http.get('/sanctum/csrf-cookie');
    let tst = await http.post('/api/login', { name: name });
    console.log(tst);
  } catch (e) {
    console.log(e);
    validate_message.value = 'ログインできませんでした';
  }
}

const getUser = () => {
  http.get('/api/user')
    .then((res) => {
      user.value = res.data;
    })
    .catch(function (error) {
      console.log(error);
    })
}

const logout = async () => {
  await http.post('/api/logout');
  user.value = null;
}
</script>

<template>
  <button @click="login('user')">login</button>
  <button @click="getUser()">getUser</button>
  <button @click="logout()">logout</button>
  {{ validate_message }}
  <br>
  <br>
  <br>
  <p v-for="(value, key) in user" :key=key>{{ key + ' : ' + value }}</p>
</template>