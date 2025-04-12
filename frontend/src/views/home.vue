<script setup>
    import { ref, onMounted } from 'vue';

    import api from '../api';
    const games = ref([]);
    const fetchDataGames = async () => {
        try{
            const response = await api.get('/api/v1/games');

            console.log("Response data:", response.data); 
                        games.value = response.data.data.data;
        } catch (error) {
            console.error('Error fetching game data:', error);
        }
        
    }

    onMounted(() => {
        fetchDataGames();
    });

    const getImageUrl = (path) => {
        return `http://localhost:8000/storage/${path}`;
    };

</script>
<template>
  <div class="container mt-4">
    <div class="row g-3">
      <div v-for="(game, index) in games" :key="index" class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm">
          <img :src="getImageUrl(game.image)" alt="gambar game" class="card-img-top" style="height: 180px; object-fit: cover;"
          />
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Title: {{ game.title }}</h5>
            <p class="card-text">Description:<br />{{ game.description }}</p>
            <router-link :to="{ name: 'show.game', params: { id: game.id } }" class="btn btn-sm btn-success mt-auto">Show or Play</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
