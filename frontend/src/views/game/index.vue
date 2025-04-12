<script setup>
    import { ref, onMounted } from 'vue';

    import api from '../../api';
    const games = ref([]);
    const fetchDataGames = async () => {

        //fetch data 
        await api.get('/api/v1/games')

        .then(response => {

            //set response data to state "posts"
            games.value = response.data.data.data

        });
    }

    //run hook "onMounted"
    onMounted(() => {

        //call method "fetchDataPosts"
        fetchDataGames();
    });

    const getImageUrl = (path) => {
        return `http://localhost:8000/storage/${path}`;
    };

</script>

<template>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <router-link :to="{ name: 'admin.game.create' }" class="btn btn-md btn-success rounded shadow border-0 mb-3">ADD NEW POST</router-link>
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Title</th>
                                    <th scope="col" style="width:15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="games.length == 0">
                                    <td colspan="4" class="text-center">
                                        <div class="alert alert-danger mb-0">
                                            Data Belum Tersedia!
                                        </div>
                                    </td>
                                </tr>
                                <tr v-else v-for="(game, index) in games" :key="index">
                                    <td class="text-center">
                                        <img :src="getImageUrl(game.image)" alt="gambar game" width="200" />
                                    </td>
                                    <td>{{ game.title }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'admin.game.edit', params:{id: game.id} }" class="btn btn-sm btn-primary rounded-sm shadow border-0 me-2">EDIT</router-link>
                                        <button class="btn btn-sm btn-danger rounded-sm shadow border-0">DELETE</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>