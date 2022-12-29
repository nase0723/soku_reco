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
const fiveMatters = ref();
const newMatter = ref({});
const modal = ref({});

onBeforeMount(() => {
    getMatters();
    initModal();
});

const initModal = () => {
    newMatter.value = {}
    modal.value.status = 1;
    console.log(modal.value.status);
};

const closeModal = () => document.getElementById('btnCloseModal').click();

const getMatters = async () => {
    try {
        const response = await http.get('/api/matters');
        matters.value = response.data.matters;
        fiveMatters.value = matters.value.slice(0, 5);
    } catch (e) {
        console.log(e);
    }
}

const createMatter = async () => {
    try {
        const response = await http.post('/api/matters', { matter: newMatter.value });
        if (response.status == 200) {
            getMatters();
            // closeModal();
            modal.value.status = 2;
        }
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
                    <option value="created_at">登録日順</option>
                    <option value="street_value">スト値順</option>
                    <option value="age">年齢順</option>
                </select>
            </div>
            <div class="col-4 text-center">
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    @click="initModal">新規登録</button>
            </div>
        </div>
    </div>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th class="text-center">名前</th>
                <th class="text-center">年齢</th>
                <th class="text-center">場所</th>
                <th class="text-center">登録日</th>
                <th class="text-center">詳細</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="matter in matters">
                <td class="text-center">{{ matter.name }}</td>
                <td class="text-center">{{ matter.age }}</td>
                <td class="text-center">{{ matter.place }}</td>
                <td class="text-center">{{ `${(new Date(matter.created_at)).getMonth() + 1}/${(new
        Date(matter.created_at)).getDate()}`
}}</td>
                <td class="text-center">
                    <button class="btn btn-outline-light">詳細</button>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- 基本情報入力 -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ {1 : '基本情報入力', 2 : '登録完了しました', 3 : '詳細情報入力'}[modal.status] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btnCloseModal"></button>
                </div>
                <div class="modal-body" v-if="modal.status === 1">
                    <form @submit.prevent="createMatter">
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="inputName" class="col-form-label">名前</label>
                            </div>
                            <div class="col-10">
                                <input type="text" v-model="newMatter.name" class="form-control" id="inputName">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="inputWork" class="col-form-label">年齢</label>
                            </div>
                            <div class="col-10">
                                <select v-model="newMatter.age" class="form-select">
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
                                <input type="text" v-model="newMatter.place" class="form-control" list="places"
                                    id="inputPlace">
                                <datalist id="places">
                                    <!-- <template v-for="(matter, key) in fiveMatters" :key=key>
                                        <option :value="matter.place" v-if="fiveMatters[key -1].place != matter.place"></option>
                                    </template> -->
                                    <option :value="matter.place" v-for="matter in fiveMatters"></option>
                                </datalist>
                            </div>
                        </div>
                        <br>
                        <div class="row mt-3">
                            <button type="submit" class="btn btn-dark mx-auto w-50">登録</button>
                        </div>
                    </form>
                </div>
                <div class="modal-body" v-if="modal.status === 2">
                    <div class="row mb-3">
                        <button type="button" class="btn btn-dark w-50 mx-auto" @click="modal.status = 3">続けて詳細情報入力</button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-dark w-50 mx-auto" @click="closeModal()">一覧へ戻る</button>
                    </div>
                </div>
                <div class="modal-body" v-if="modal.status === 3">
                    
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</template>