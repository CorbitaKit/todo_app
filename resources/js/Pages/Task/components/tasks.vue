<script setup>
import Actions from './actions.vue'
import { useTaskStore } from '../store/index'

const taskStore = useTaskStore();
</script>

<template>
    <ul class="space-y-4">
        <li class="flex justify-between items-start p-4 bg-gray-50 rounded-lg shadow mb-2" v-for="task in taskStore.tasks" :key="task.id">
            <div class="flex-1">
                <div class="flex items-center mb-1">
                    <span class="mr-4 font-semibold">{{ task.title }}</span>
                    <span class="text-sm text-gray-500">{{ task.status }}</span>
                </div>
                <p class="text-gray-700"> {{ task.description }}</p>
            </div>
            <Actions :task="task"/>
        </li>
    </ul>
</template>