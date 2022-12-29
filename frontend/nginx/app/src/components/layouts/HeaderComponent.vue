<script setup>
import axios from "axios";
import { useRouter } from 'vue-router';

const baseUrl = 'http://localhost:8000';
const router = useRouter();
const http = axios.create({
    baseURL: baseUrl,
    withCredentials: true,
});

const logout = async () => {
    try {
        await http.post('/api/logout');
        router.push('/login');
    } catch (e) {
        console.log(e);
    }
}
</script>
<template>
    <header class="p-3 bg-dark text-white">
        <!-- <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li class="ext-white display-1">SOKU-RECO</li>
                </ul>
                <div class="text-end">
                    <router-link :to="{ name: 'login' }" class="btn btn-outline-light me-2">ログイン</router-link>
                    <button type="button" class="btn btn-outline-light me-2" @click="logout()">ログアウト</button>
                </div>
            </div>
        </div> -->
        <nav class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid mt-2 mb-2">
                <a class="navbar-brand" style="font-size: 33px" href="#">SOKU-RECO</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                    aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Darkオフキャンバス</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                            aria-label="閉じる"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">ホーム</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">リンク</a>
                            </li>
                            <li class="nav-item dropdown">
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
                            </li>
                        </ul>
                        <form class="d-flex mt-3" role="search">
                            <input class="form-control me-2" type="search" placeholder="検索" aria-label="検索">
                            <button class="btn btn-success flex-shrink-0" type="submit">検索</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>