<script setup>
import { ref } from "vue";
import { useTaskStore } from '../store/index'

const taskStore = useTaskStore()

const statuses = ref([
    {
        label: 'All',
        value: 'All'
    },
    {
        label: 'To Do',
        value: 'To Do'
    },
    {
        label: 'In Progress',
        value: 'In Progress'
    },
    {
        label: 'Completed',
        value: 'Completed'
    },
])
</script>

<template>
    <div class="mb-4">
        <label for="status-filter" class="mr-2">Filter by status:</label>
        <select v-model="taskStore.status" id="status-filter" class="border border-gray-300 rounded p-2" @change="taskStore.filterTask()">
            <option v-for="(status, i) in statuses" :key="i" :value="status.value">{{ status.label }}</option>
        </select>
    </div>
</template>