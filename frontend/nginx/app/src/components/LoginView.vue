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

const getUser = () => {
  http.get('/api/user')
    .then((res) => {
      user.value = res.data;
    })
    .catch(function (error) {
      console.log(error);
    })
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
      <form>
        <!-- <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
        <h1 class="h3 mb-3 fw-normal">ログイン</h1>
        <p>{{ validate_message }}</p>
    
        <div class="form-floating m-3">
          <input type="text" class="form-control" id="floatingInput" placeholder="" v-model="name">
          <label for="floatingInput">ユーザー名（アルファベットか数字）</label>
        </div>
        <!-- <div class="form-check m-3">
          <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
          <label class="form-check-label" for="flexCheckChecked">
            ログイン状態を保持する
          </label>
        </div> -->
        <button class="w-100 btn btn-lg btn-dark" type="button" @click="login()">ログイン</button>
        <!-- <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p> -->
      </form>
    </main>
        
</template>