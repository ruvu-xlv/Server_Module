<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';


const router = useRouter();


const image = ref(null);
const title = ref('');
const description = ref('');
const slug = ref('');
const errors = ref({});
const errorMessage = ref('');

const storeGame = async()=>{
    const formData = new FormData();

        if (image.value) {
            formData.append('image', image.value);
        }

    
    formData.append('title',title.value);
    formData.append('description',description.value);   
    formData.append('slug',slug.value);
    try{
        const response=await axios.post('http://localhost:8000/api/v1/games',formData,{
            headers:{
                'Content-Type': 'multipart/form-data',
            },
        });
        console.log('Data berhasil disimpan:', response.data);
        router.push({ path: '/admin/game' });
    }catch (error) {
            if (error.response) {
                errors.value = error.response.data.errors || {}; 
                errorMessage.value = ''; 
            } else {
                errors.value = {};
                errorMessage.value = 'Terjadi masalah dengan koneksi API atau server. Silakan coba lagi.';
            }
        }

}
</script>
 
<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <form @submit.prevent="storeGame">
                            <div v-if="errorMessage" class="alert alert-danger">
                                <span>{{ errorMessage }}</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Image</label>
                                <input
                                    type="file"
                                    class="form-control"
                                    @change="image = $event.target.files[0]"
                                />
                                <div v-if="errors.image" class="alert alert-danger mt-2">
                                    <span>{{ errors.image[0] }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Title</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="title"
                                    placeholder="Masukkan Judul"
                                />
                                <div v-if="errors.title" class="alert alert-danger mt-2">
                                    <span>{{ errors.title[0] }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea
                                    class="form-control"
                                    v-model="description"
                                    rows="5"
                                    placeholder="Masukkan Deskripsi Buku"
                                ></textarea>
                                <div v-if="errors.description" class="alert alert-danger mt-2">
                                    <span>{{ errors.description[0] }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Slug</label>
                                <textarea
                                    class="form-control"
                                    v-model="slug"
                                    rows="5"
                                    placeholder="Masukkan Slug"
                                ></textarea>
                                <div v-if="errors.slug" class="alert alert-danger mt-2">
                                    <span>{{ errors.slug[0] }}</span>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-block">
                                <button type="submit" class="btn btn-primary rounded-sm shadow border-0 me-2" >Save</button>
                                <router-link :to="{ name: 'admin.game.index' }" class="rounded-sm shadow border-0 me-2 btn btn-md btn-warning">
                                    Back
                                </router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>