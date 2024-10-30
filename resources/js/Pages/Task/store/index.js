import { defineStore } from "pinia";
import axios from "axios";
import Swal from 'sweetalert2'

export const useTaskStore = defineStore('tasks', {
    state: () => {
        return {
            tasks: [],
            task: {
                title: '',
                description: '',
                status: 'To Do'
            },
            errors: [],
            text: 'Add Task',
            status: 'All'
        }
    },
    actions: {
        async fetchTasks () {
            await axios.get('api/tasks')
            .then(response => {
               
                this.tasks = response.data
            })
        },

        async createTask () {
            await axios.post('api/tasks', this.task)
            .then(response => {
                Swal.fire({
                    title: "Success!",
                    text: "Task created successfully!",
                    icon: "success"
                  });
                this.tasks.push(response.data)
                this.resetTask()
            }).catch(err => {
                Swal.fire({
                    title: "Opps!",
                    text: "Please fill up all the fields",
                    icon: "error"
                });

                this.errors = err.response.data.errors
            })
        },

        deleteTask (task_id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('api/tasks/' + task_id)
                    .then(res => {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your task has been deleted.",
                            icon: "success"
                        });

                        this.tasks = this.tasks.filter(task => task.id != task_id)
                        
                    })
                    
                }
            });
        },

        async updateTask (task_id, data) {
            axios.patch('api/tasks/' + task_id, data)
            .then(res => {
                const index = this.tasks.findIndex(task => task.id === task_id);
                this.tasks = this.tasks.filter(task => task.id != task_id)
                this.tasks.splice(index, 0, res.data)
                Swal.fire({
                    title: "Updated!",
                    text: "Your task has been updated.",
                    icon: "success"
                });
                this.resetTask()
            })
     
        },

        async filterTask () {
            await axios.get('api/tasks/filter-by-status/' + this.status)
            .then(response => {
                this.tasks = response.data
            })
        },

        resetTask () {
            this.task.title = '',
            this.task.description = ''
        }
    }
})