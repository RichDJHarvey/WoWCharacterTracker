<template>
    <div class="p-6 bg-gray-50 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-blue-700 mb-2">Testinggggggggg</h1>
        <p class="text-gray-700 mb-4">Testing this is a test</p>

        <Button severity="info" label="Test" @click="increment" />
        <p class="mt-2">Count: {{ count }}</p>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Button from 'primevue/button';
const count = ref(0);

const increment = () => {
    count.value++
}
</script>
