<script setup>
import axios from "axios";
import { ref } from "vue";

const user = ref();
const status = ref();
const baseUrl = 'http://localhost:8888/LaravelGoutte/public';

const http = axios.create({
  baseURL: baseUrl,
  withCredentials: true,
});

const test = async () => {
  try {
    let test = await axios.get('http://localhost:8000/api/test');
    console.log(test);
  } catch (e) {
    console.log(e)
  }
}

const login = async () => {
  try {
    await http.get('/sanctum/csrf-cookie');
    await http.post('/api/login', { name : 'test' });
    status.value = 'loggedIn';
  } catch (e) {
    console.log(e);
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
  status.value = 'loggedOut';
}
</script>

<template>
  <h1>
    認証テスト<br>
    BaseURL -> {{ baseUrl }}
  </h1>
  <button @click="login()">login</button>
  <button @click="getUser()">getUser</button>
  <button @click="logout()">logout</button>
  <button @click="test()">test</button>
  <br>
  <br>
  <p>{{ 'status : ' + status }}</p>
  <br>
  <p v-for="(value, key) in user" :key=key>{{ key + ' : ' + value }}</p>
</template>