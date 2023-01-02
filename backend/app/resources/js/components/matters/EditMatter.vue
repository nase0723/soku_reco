<script setup>
import { useRouter } from 'vue-router';
import { ref, onBeforeMount } from "vue";
const props = defineProps({
    http: Function,
    id: String,
})
const http = props.http
const id = props.id
const router = useRouter();
const matter = ref({});

onBeforeMount(() => {
    getMatter();
});

const redirectToLoginPage = () => router.push({name : 'login'});

const getMatter = async () => {
    try {
        const response = await http.get('/api/matters/' + id);
        if (response.status == 200) {
            matter.value = response.data.matter;
        }
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        console.log(e);
    }
}

const updateMatter = async () => {
    try {
        const response = await http.put('/api/matters/' + id, matter.value);
        if (response.status == 200) {
            router.push({name: 'MatterDetail', params: { id: String(id) }});
        }
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        console.log(e);
    }
}

const DeleteMatter = async () => {
    try {
        const response = await http.delete('/api/matters/' + id);
        if (response.status == 200) {
            router.push({name: 'matters'});
        }
    } catch (e) {
        if (e.response.status == 401) {
            redirectToLoginPage();
        }
        console.log(e);
    }
}
</script>

<template>
    <div class="container">
        <div class="row d-flex mb-3">
            <div class="col-9">
                <h1>
                    <span class="badge bg-dark">
                        {{ matter && `${(new Date(matter.created_at)).getFullYear()}/${(new Date(matter.created_at)).getMonth() + 1}/${(new Date(matter.created_at)).getDate()}` }}
                    </span>
                </h1>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <button class="btn btn-dark btn-lg" @click="DeleteMatter">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        <form @submit.prevent="updateMatter">
            <div class="row mb-3">
                <div class="col-3">
                    <h3><label for="name" class="text-white">名前</label></h3>
                </div>
                <div class="col-9">
                    <input type="text" class="form-control" id="name" v-model="matter.name">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <h3><label for="place" class="text-white">場所</label></h3>
                </div>
                <div class="col-9">
                    <input type="text" class="form-control" id="place" v-model="matter.place">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <h3><label for="street_value" class="text-white">スト値</label></h3>
                </div>
                <div class="col-9">
                    <select v-model="matter.street_value" class="form-select" id="street_value">
                        <option :value="i" v-for="i in 10">{{ i }}</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <h3><label for="age" class="text-white">年齢</label></h3>
                </div>
                <div class="col-9">
                    <select v-model="matter.age" class="form-select" id="inputAge">
                        <option value="">不明</option>
                        <option :value="i + 17" v-for="i in 18">{{ i + 17 }}</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <h3><label for="work" class="text-white">仕事</label></h3>
                </div>
                <div class="col-9">
                    <input type="text" class="form-control" id="work" v-model="matter.work">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <h3><label for="inputRemarks" class="text-white">備考</label></h3>
                </div>
                <div class="col-9">
                    <textarea class="form-control" v-model="matter.remarks" id="inputRemarks" rows="3"></textarea>
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-dark mx-auto w-50">変更</button>
            </div>
        </form>
    </div>
</template>