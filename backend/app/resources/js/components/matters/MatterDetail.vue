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

</script>

<template>
    <div class="container">
        <div class="row d-flex mb-3">
            <div class="col-9">
                <h1>
                    <span class="badge bg-dark">
                        {{ matter && matter.name + '&nbsp;&nbsp;' + `${(new Date(matter.created_at)).getFullYear()}/${(new Date(matter.created_at)).getMonth() + 1}/${(new Date(matter.created_at)).getDate()}` }}
                    </span>
                </h1>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <button class="btn btn-dark btn-lg" @click="router.push({name: 'EditMatter', params: {id : id}})">
                    <i class="bi bi-pencil"></i>
                </button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <h3><label for="place" class="text-secondary">場所</label></h3>
            </div>
            <div class="col-9">
                <input type="text" class="form-control" id="place" :value="matter && matter.place" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <h3><label for="street_value" class="text-secondary">スト値</label></h3>
            </div>
            <div class="col-9">
                <input type="text" class="form-control" id="street_value" :value="matter && matter.street_value" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <h3><label for="age" class="text-secondary">年齢</label></h3>
            </div>
            <div class="col-9">
                <input type="text" class="form-control" id="age" :value="matter && matter.age" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <h3><label for="work" class="text-secondary">仕事</label></h3>
            </div>
            <div class="col-9">
                <input type="text" class="form-control" id="work" :value="matter && matter.work" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <h3><label for="inputRemarks" class="text-secondary">備考</label></h3>
            </div>
            <div class="col-9">
                <textarea class="form-control" :value="matter && matter.remarks" id="inputRemarks" rows="3" disabled></textarea>
            </div>
        </div>
    </div>
</template>