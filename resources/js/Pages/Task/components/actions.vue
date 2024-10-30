<script setup>
import { ref } from 'vue'
import { useTaskStore } from '../store/index'

const taskStore = useTaskStore()
const props = defineProps({
    task: Object
})

const statuses = ref([
   
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

const editTask = () => {
    taskStore.text = 'Update Task'
    taskStore.task = props.task
}


</script>

<template>
    <div class="flex items-center">
        <button class="bg-yellow-500 text-white px-2 py-1 rounded mr-2" @click="editTask()">Edit</button>
        <button class="bg-red-500 text-white px-2 py-1 rounded" @click="taskStore.deleteTask(task.id)">Delete</button>
        <select v-model="task.status" class="ml-2 border border-gray-300 rounded p-1" @change="taskStore.updateTask(task.id, {status: task.status})">
            <option v-for="(status, i) in statuses" :key="i" :value="status.value">{{ status.label }}</option>
        </select>
    </div>
</template>