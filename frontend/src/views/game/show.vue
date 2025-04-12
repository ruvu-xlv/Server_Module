<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'

const route = useRoute()
const gameId = ref(null)

const title = ref('')
const description = ref('')
const slug = ref('')
const imagePath = ref('')
const errorMessage = ref('')

onMounted(async () => {
    gameId.value = route.params.id
    try {
        const response = await axios.get(`http://localhost:8000/api/v1/games/${gameId.value}`)
        const game = response.data.data

        title.value = game.title
        description.value = game.description
        slug.value = game.slug
        imagePath.value = game.image
    } catch (error) {
        errorMessage.value = 'Terjadi masalah saat memuat data game. Silakan coba lagi.'
    }
})

const getImageUrl = (path) => {
    return `http://localhost:8000/storage/${path}`
}
</script>

<template>
  <div class="container mt-5">
    <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>

    <div class="card mb-3" style="max-width: 1100px;" v-else>
      <div class="row g-0">
        <div class="col-md-4">
          <img v-if="imagePath" :src="getImageUrl(imagePath)" alt="gambar game" class="img-fluid rounded-start" />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title"> Title : {{ title }}</h5>
            <p class="card-text">Deskcription : {{ description }}</p>
            <p class="card-text"><small class="text-muted">Slug : {{ slug }}</small></p>
            <a href="#" class="btn btn-md btn-success">Play</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
