<script setup>
import axios from "axios";
import { useRouter } from 'vue-router';
import { ref, onBeforeMount } from "vue";

const router = useRouter();
const user = ref();
const name = ref();
const validate_message = ref();
const baseUrl = 'http://localhost:8000';

const http = axios.create({
  baseURL: baseUrl,
  withCredentials: true,
});

onBeforeMount(async () => {
  console.log("on mount");
  let checked = await http.get('/api/check');
  if (checked.data) {
    router.push('/');
  } 
});

const login = async () => {
  try {
    await http.get('/sanctum/csrf-cookie');
    await http.post('/api/login', { name: name.value });
    router.push('/');
  } catch (e) {
    console.log(e);
    validate_message.value = 'ログインできませんでした';
  }
}


let query = location.search.replace('?', '');
let queryArr = query.split('=');
if (queryArr[0] == 'name') {
  name.value = queryArr[1];
  login();
}

</script>
<style>
html,
body {
  height: 100%;
}


.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

</style>
<template>
    <main class="form-signin" v-cloak>
      <form class="text-center">
        <!-- <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
        <!-- <h1 class="mb-3 fw-normal text-white">ログイン</h1> -->
        
    
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="floatingInput" placeholder="" v-model="name">
          <label for="floatingInput">ユーザー名（アルファベットまたは数字）</label>
        </div>
        <!-- <div class="form-check m-3">
          <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
          <label class="form-check-label" for="flexCheckChecked">
            ログイン状態を保持する
          </label>
        </div> -->
        <button class="w-75 btn btn-lg btn-dark" type="button" @click="login()">ログイン</button>
        <h2 class="text-white bt-5">{{ validate_message }}</h2>
        <!-- <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p> -->
      </form>
    </main>
        
</template>