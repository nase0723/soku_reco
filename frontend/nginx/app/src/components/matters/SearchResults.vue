<script setup>
// import { useRouter } from 'vue-router';
import { ref, onBeforeMount } from "vue";
const props = defineProps({
    http: Function,
    keyword: String,
})
const http = props.http;
const keyword = ref(props.keyword);
const keywordToShow = ref();

const matters = ref();

const getMatters = async (orderBy, keyword) => {
    try {
        const response = await http.get(`/api/matters?column=${orderBy.column}&type=${orderBy.type}&keyword=${keyword}`);
        matters.value = response.data.matters;
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        console.log(e);
    }
}

const search = async () => {
    await getMatters({ column: 'created_at', type: 'desc' }, keyword.value);
    keywordToShow.value = keyword.value;
}

search();
</script>

<template>
    <div class="container">
        <div class="row mb-3">
            <form class="d-flex mt-3" role="search" @submit.prevent="search">
                <input class="form-control me-2" type="search" placeholder="名前、場所、住み、仕事、備考" aria-label="検索" v-model="keyword">
                <button class="btn btn-dark flex-shrink-0" type="submit">検索</button>
            </form>
        </div>
        <div class="row mb-2 d-flex justify-content-center">
            <div class="col-10 d-flex justify-content-center">
                <h1><span class="badge bg-secondary">「 {{ keywordToShow }} 」 の検索結果</span></h1>
            </div>
        </div>
    </div>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th class="text-center">名前</th>
                <th class="text-center">場所</th>
                <!-- <th class="text-center">{{ columnsForSort[selectedSortColumn].name }}</th> -->
                <th class="text-center">詳細</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="matter in matters">
                <td class="text-center">{{ matter.name }}</td>
                <td class="text-center">{{ matter.place }}</td>
                <!-- <td class="text-center">
                {{
                    {
                        created_at: `${(new Date(matter.created_at)).getMonth() + 1}/${(new Date(matter.created_at)).getDate()}`,
                        street_value: matter.street_value,
                        age: matter.age
                    }[selectedSortColumn]
                }}
                </td> -->
                <td class="text-center">
                    <router-link :to="{ name: 'MatterDetail', params: { id: String(matter.id) } }" class="btn btn-info">
                        <i class="bi bi-search"></i>
                    </router-link>
                </td>
            </tr>
        </tbody>
    </table>
</template>