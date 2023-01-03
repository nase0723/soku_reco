<script setup>
import { useRouter } from 'vue-router';
import { ref, onBeforeMount } from "vue";

const props = defineProps({
    http: Function,
})
const http = props.http
const router = useRouter();
const user = ref();
const userName = ref();
const keyword = ref();

onBeforeMount(() => {
    getUser();
});

const getUser = async () => {
    try {
        let response = await http.get('/api/user');
        userName.value = response.data.name;
        user.value = response.data;
    } catch (e) {
        console.log(e);
    }
}

const logout = async () => {
    try {
        await http.post('/api/logout');
        CloseNavbar();
        router.push('/login');
    } catch (e) {
        console.log(e);
    }
}

const search = async () => {
    CloseNavbar();
    router.push({name: 'SearchResults', params: {keyword: String(keyword.value)}});
}

const CloseNavbar = () => document.getElementById('btnCloseNavbar').click();

</script>
<template>
    <header class="p-3 bg-dark text-white">
        <nav class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid mt-2 mb-2">
                <router-link :to="{name: 'matters'}" class="navbar-brand" style="font-size: 33px">SOKU-RECO</router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" v-if="userName">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                    aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">ユーザー名：{{ userName }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                            aria-label="閉じる" id="btnCloseNavbar"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form class="d-flex mt-3 mb-3" role="search" @submit.prevent="search">
                            <input class="form-control me-2" type="search" placeholder="案件検索" aria-label="検索" v-model="keyword">
                            <button class="btn btn-outline-light flex-shrink-0" type="submit">検索</button>
                        </form>
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/">ホーム</a>
                            </li>
                            <li class="nav-item">
                                <!-- <a class="nav-link active" aria-current="page" href="/">ホーム</a> -->
                                <router-link :to="{name: 'appointments'}" class="nav-link" @click="CloseNavbar">アポ一覧</router-link>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page">使い方</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" @click="logout()" v-if="userName">ログアウト</a>
                            </li>
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    ドロップダウン
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="#">メニュー1</a></li>
                                    <li><a class="dropdown-item" href="#">メニュー2</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">その他</a></li>
                                </ul>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <br>
    <br>
    <br>
</template>