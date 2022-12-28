<script setup>
import axios from "axios";
// import { useRouter } from 'vue-router';
import { ref, onBeforeMount } from "vue";
const baseUrl = 'http://localhost:8000';

const http = axios.create({
    baseURL: baseUrl,
    withCredentials: true,
});

const matters = ref();
const places = ref();

onBeforeMount(async () => {
    getMatters();
    getPlaces();
    //   let checked = await http.get('/api/check');
    //   if (checked.data) {
    //     router.push('/');
    //   } 
});

const getMatters = async () => {
    try {
        const response = await http.get('/api/matters');
        matters.value = response.data.matters;
    } catch (e) {
        console.log(e);
    }
}

const getPlaces = async () => {
    try {
        const response = await http.get('/api/places');
        places.value = response.data.places;
    } catch (e) {
        console.log(e);
    }
}
</script>

<template>
    <div class="container mt-3 mb-3">
        <div class="row">
            <div class="col-4 text-center">
                <select class="form-select form-select-sm">
                    <option selected class="text-muted">並び順</option>
                    <option value="street_value">スト値</option>
                    <option value="created_at">登録日</option>
                    <option value="age">年齢</option>
                </select>
            </div>
            <div class="col-4 text-center">
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">新規登録</button>
            </div>
        </div>
    </div>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th class="text-center">名前</th>
                <th class="text-center">年齢</th>
                <th class="text-center">場所</th>
                <th class="text-center">職業</th>
                <th class="text-center">詳細</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="matter in matters">
                <td class="text-center">{{ matter.name }}</td>
                <td class="text-center">{{ matter.age }}</td>
                <td class="text-center">{{ matter.place.name }}</td>
                <td class="text-center">{{ matter.name }}</td>
                <td class="text-center">
                    <button class="btn btn-outline-light">詳細</button>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- 基本情報登録 -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">基本情報登録</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputName" class="col-form-label">名前</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="name" class="form-control" id="inputName">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputWork" class="col-form-label">年齢</label>
                        </div>
                        <div class="col-10">
                            <select name="age" class="form-select">
                                <option value="">不明</option>
                                <option :value="i + 17" v-for="i in 18">{{ i + 17 }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputPlace" class="col-form-label">場所</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="place" class="form-control" list="places" id="inputPlace">
                            <datalist id="places">
                                <option :value="place.name" v-for="place in places"></option>
                            </datalist>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputWork" class="col-form-label">職業</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="work" class="form-control" id="inputWork">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mx-auto">登録</button>
                </div>
            </div>
        </div>
    </div>
</template>