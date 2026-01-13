<template>
    <div class="p-6 bg-gray-50 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-blue-700 mb-2">Character Media Test</h1>

        <div class="mb-4 flex flex-wrap gap-2">
            <input
                v-model="realm"
                type="text"
                placeholder="Realm"
                class="border rounded p-2"
            />
            <input
                v-model="name"
                type="text"
                placeholder="Character Name"
                class="border rounded p-2"
            />
            <Button severity="info" label="Fetch Media" @click="fetchMedia" />
        </div>

        <div v-if="loading" class="text-gray-500 mb-2">Loading...</div>
        <div v-if="error" class="text-red-500 mb-2">{{ error }}</div>

        <div v-if="media" class="mt-4 flex flex-col gap-4">
            <div v-if="media.avatar">
                <p class="font-semibold mb-2">Avatar</p>
                <img :src="media.avatar" alt="Avatar" class="w-32 h-32 rounded shadow-md" />
            </div>
            <div v-if="media.inset">
                <p class="font-semibold mb-2">Inset</p>
                <img :src="media.inset" alt="Inset" class="w-32 h-32 rounded shadow-md" />
            </div>
            <div v-if="media['main-raw']">
                <p class="font-semibold mb-2">Main Raw</p>
                <img :src="media['main-raw']" alt="Main Raw" class="w-64 h-64 rounded shadow-md" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import Button from 'primevue/button';

const realm = ref('draenor');
const name = ref('tenpaw');
const media = ref(null);
const loading = ref(false);
const error = ref('');

const fetchMedia = async () => {
    loading.value = true;
    error.value = '';
    media.value = null;

    await axios
        .get(`/character/${realm.value}/${name.value}/media`)
        .then((response) => {
            const data = response.data;

            if (data.assets) {
                media.value = data.assets;
            } else {
                error.value = 'No media assets found';
            }
            loading.value = false;
        })
        .catch(() => {
            error.value = 'Failed to fetch media';
            loading.value = false;
        });
};
</script>
