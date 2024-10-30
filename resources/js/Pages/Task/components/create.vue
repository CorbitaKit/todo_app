<script setup>
import { useTaskStore } from '../store/index'

const taskStore = useTaskStore()
</script>

<template>
    <form class="mt-6">
        <div class="flex flex-col mb-4">
            <input v-model="taskStore.task.title" type="text" placeholder="Add a new task" :class="['border', taskStore.errors.title ? 'border-red-500' : 'border-gray-300', 'p-2 rounded mb-2']"/>
            <p v-if="taskStore.errors.title" class="text-red-500 text-sm mb-2">{{ taskStore.errors.title[0] }}</p>

            <textarea v-model="taskStore.task.description" placeholder="Add a description" :class="['border', taskStore.errors.description ? 'border-red-500' : 'border-gray-300', 'p-2 rounded mb-4']" rows="3" />
            <p v-if="taskStore.errors.description" class="text-red-500 text-sm mb-2">{{ taskStore.errors.description[0] }}</p>
        </div>
        <button v-if="taskStore.text === 'Add Task'" @click="taskStore.createTask()" class="bg-blue-500 text-white px-4 py-2 rounded" type="button">{{ taskStore.text }}</button>
        <button v-else @click="taskStore.updateTask(taskStore.task.id, taskStore.task)" class="bg-blue-500 text-white px-4 py-2 rounded" type="button">{{ taskStore.text }}</button>
    </form>
</template>