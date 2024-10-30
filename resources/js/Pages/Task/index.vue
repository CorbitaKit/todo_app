<script setup>
import Header from './components/header.vue'
import Filter from './components/filter.vue'
import Tasks from './components/tasks.vue'
import Create from './components/create.vue'
import { useTaskStore } from './store/index'
import { onMounted } from 'vue'

const taskStore = useTaskStore();

onMounted(() => {
    taskStore.fetchTasks()
})
</script>


<template>
    
    <Header />
    <!-- Main Content -->
    <main class="container mx-auto mt-8 p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Tasks</h2>
            <div class="mb-4">
               <Filter />
            </div>
            <Tasks />
            <Create />
        </div>
    </main>
</template>