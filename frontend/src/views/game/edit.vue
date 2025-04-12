<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

const gameId = ref(null);
const image = ref(null);
const imagePreview = ref(null);
const title = ref('');
const description = ref('');
const slug = ref('');
const siput = ref('');
const errors = ref({});
const errorMessage = ref('');
const isLoading = ref(false);

onMounted(async () => {
    gameId.value = route.params.id;
    try {
        const response = await axios.get(`http://localhost:8000/api/v1/games/${gameId.value}`);
        const game = response.data.data;
        siput.value = game.siput;
        title.value = game.title;
        description.value = game.description;
        slug.value = game.slug;
        imagePreview.value = game.image_url;
    } catch (error) {
        errorMessage.value = 'Terjadi masalah saat memuat data game. Silakan coba lagi.';
    }
});

const handleFileChange = (event) => {
    const file = event.target.files[0];
    image.value = file;
    if (file) {
        imagePreview.value = URL.createObjectURL(file);
    }
};

const updateGame = async () => {
    const formData = new FormData();
    formData.append('_method', 'POST');

    if (image.value) {
        formData.append('image', image.value);
    }

    formData.append('title', title.value);
    formData.append('description', description.value);
    formData.append('slug', slug.value);
    formData.append('siput', siput.value);

    isLoading.value = true;

    try {
        const response = await axios.post(`http://localhost:8000/api/v1/games/${gameId.value}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        console.log('Data berhasil diperbarui:', response.data);
        router.push({ path: '/admin/game' });
    } catch (error) {
        if (error.response) {
            errors.value = error.response.data.errors || {};
            errorMessage.value = '';
        } else {
            errors.value = {};
            errorMessage.value = 'Terjadi masalah dengan koneksi API atau server. Silakan coba lagi.';
        }
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <form @submit.prevent="updateGame">
                            <div v-if="errorMessage" class="alert alert-danger">
                                <span>{{ errorMessage }}</span>
                            </div>

                            <div v-if="imagePreview" class="mb-3">
                                <img :src="imagePreview" alt="Preview Gambar" class="img-fluid" style="max-height: 200px;" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Image</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    class="form-control"
                                    @change="handleFileChange"
                                />
                                <div v-if="errors.image" class="alert alert-danger mt-2">
                                    <span>{{ errors.image[0] }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Siput</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="siput"
                                />
                                <div v-if="errors.siput" class="alert alert-danger mt-2">
                                    <span>{{ errors.siput[0] }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">title</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="title"
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
                                ></textarea>
                                <div v-if="errors.description" class="alert alert-danger mt-2">
                                    <span>{{ errors.description[0] }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Slug</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="slug"
                                />
                                <div v-if="errors.slug" class="alert alert-danger mt-2">
                                    <span>{{ errors.slug[0] }}</span>
                                </div>
                            </div>

                            <button
                                type="submit"
                                class="btn btn-md btn-primary rounded-sm shadow border-0"
                                :disabled="isLoading"
                            >
                                <span v-if="isLoading">Saving...</span>
                                <span v-else>Save</span>
                            </button>

                            <button>
                            <router-link :to="{ name: 'admin.game.index' }" class="btn btn-md btn-warning rounded-sm shadow border-0">
                             Back
                            </router-link>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>