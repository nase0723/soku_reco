<script setup>
import axios from "axios";
// import { useRouter } from 'vue-router';
import { ref, onBeforeMount } from "vue";
const props = defineProps({
    baseUrl: String,
})
const baseUrl = props.baseUrl

const http = axios.create({
    baseURL: baseUrl,
    withCredentials: true,
});

const matters = ref();
const fiveMatters = ref();
const newMatter = ref({});
const newMatterDetails = ref({});
const createdMatter = ref();
const modal = ref({});
const errors = ref();
const selectedSortColumn = ref('created_at');
const columnsForSort = {
    created_at: { type: 'desc', name: '登録日', expression: '新しい順' },
    street_value: { type: 'desc', name: 'スト値', expression: '高い順' },
    age: { type: 'asc', name: '年齢', expression: '若い順' },
};

onBeforeMount(() => {
    getMatters({ column: 'created_at', type: 'desc' });
    initModal();
});

const initModal = () => {
    newMatter.value = {}
    errors.value = {};
    modal.value.status = 1;
};

const closeModal = () => document.getElementById('btnCloseModal').click();

const getMatters = async (orderBy) => {
    try {
        const response = await http.get(`/api/matters?column=${orderBy.column}&type=${orderBy.type}`);
        matters.value = response.data.matters;
        fiveMatters.value = matters.value.slice(0, 5);
    } catch (e) {
        console.log(e);
    }
}

const createMatter = async () => {
    try {
        const response = await http.post('/api/matters', newMatter.value);
        if (response.status == 200) {
            createdMatter.value = response.data.matter;
            getMatters({ column: 'created_at', type: 'desc' });
            modal.value.status = 2;
        }
    } catch (e) {
        errors.value = e.response.data.errors;
    }
}

const createMatterDetails = async () => {
    try {
        const response = await http.put('/api/matters/' + createdMatter.value.id, newMatterDetails.value);
        if (response.status == 200) {
            getMatters({ column: 'created_at', type: 'desc' });
            closeModal();
        }
    } catch (e) {
        errors.value = e.response.data.errors;
    }
} 

const sortMatters = () => {
    let column = selectedSortColumn.value;
    let type = columnsForSort[selectedSortColumn.value].type;
    getMatters({ column: column, type: type });
}

</script>

<template>

    <div class="container mt-3 mb-3">
        <div class="row justify-content-between">
            <div class="col-7">
                <select class="form-select" @change="sortMatters" v-model="selectedSortColumn">
                    <option :value="column" v-for="(value, column) in columnsForSort">{{ value.name + '：' +
        value.expression
}}</option>
                </select>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-info rounded-circle p-0"
                    style="width:4rem; height:4rem; font-size:35px;" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop" @click="initModal">＋</button>
            </div>
        </div>
    </div>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th class="text-center">名前</th>
                <th class="text-center">場所</th>
                <th class="text-center">{{ columnsForSort[selectedSortColumn].name }}</th>
                <th class="text-center">詳細</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="matter in matters">
                <td class="text-center">{{ matter.name }}</td>
                <td class="text-center">{{ matter.place }}</td>
                <td class="text-center">
                {{
                    {
                        created_at: `${(new Date(matter.created_at)).getMonth() + 1}/${(new Date(matter.created_at)).getDate()}`,
                        street_value: matter.street_value,
                        age: matter.age
                    }[selectedSortColumn]
                }}
                </td>
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
                    <h5 class="modal-title" id="staticBackdropLabel">{{ {1: '基本情報入力', 2: '登録完了しました', 3: '詳細情報入力'}[modal.status]}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btnCloseModal"></button>
                </div>
                <div class="modal-body" v-if="modal.status === 1">
                    <form @submit.prevent="createMatter">
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="inputName" class="col-form-label">名前</label>
                            </div>
                            <div class="col-9">
                                <input type="text" v-model="newMatter.name" class="form-control" id="inputName">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="inputPlace" class="col-form-label">場所</label>
                            </div>
                            <div class="col-9">
                                <input type="text" v-model="newMatter.place" class="form-control" list="places"
                                    id="inputPlace">
                                <datalist id="places">
                                    <option :value="matter.place" v-for="matter in fiveMatters"></option>
                                </datalist>
                            </div>
                        </div>
                        <br>
                        <div class="alert alert-danger" role="alert" v-for="error in errors">{{ error[0] }}</div>
                        <div class="row mt-3">
                            <button type="submit" class="btn btn-dark mx-auto w-50">登録</button>
                        </div>
                    </form>
                </div>
                <div class="modal-body" v-if="modal.status === 2">
                    <div class="row mb-3">
                        <button type="button" class="btn btn-dark w-50 mx-auto"
                            @click="modal.status = 3">続けて詳細情報入力</button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-secondary w-50 mx-auto" @click="closeModal()">一覧へ戻る</button>
                    </div>
                </div>
                <div class="modal-body" v-if="modal.status === 3">
                    <form @submit.prevent="createMatterDetails">
                        <div class="row mb-3">
                            <div class="col-3">
                                <label class="col-form-label">名前</label>
                            </div>
                            <div class="col-9">
                                <input type="text" :value="createdMatter.name" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="street_value" class="col-form-label">スト値</label>
                            </div>
                            <div class="col-9">
                                <select v-model="newMatterDetails.street_value" class="form-select" id="street_value">
                                    <option :value="i" v-for="i in 10">{{ i }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="inputAge" class="col-form-label">年齢</label>
                            </div>
                            <div class="col-9">
                                <select v-model="newMatterDetails.age" class="form-select" id="inputAge">
                                    <option value="">不明</option>
                                    <option :value="i + 17" v-for="i in 18">{{ i + 17 }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="inputAddress" class="col-form-label">住み</label>
                            </div>
                            <div class="col-9">
                                <input type="text" v-model="newMatterDetails.address" class="form-control" id="inputAddress">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="inputWork" class="col-form-label">仕事</label>
                            </div>
                            <div class="col-9">
                                <input type="text" v-model="newMatterDetails.work" class="form-control" id="inputWork">
                            </div>
                        </div>
                        <br>
                        <div class="alert alert-danger" role="alert" v-for="error in errors">{{ error[0] }}</div>
                        <div class="row mt-3">
                            <button type="submit" class="btn btn-dark mx-auto w-50">登録</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                </div> -->
            </div>
        </div>
    </div>

</template>