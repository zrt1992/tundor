<template>
    <div class="container" style="border:solid 2px yellow;">
        <div class="col-md-8">
            <ul class="list-group" v-for="task in tasks">
                <li>
                    <input name="text" v-model="task.task_name"/>
                    <button v-on:click="saveRecord(task.id,task.task_name)">save</button>
                </li>
            </ul>
            {{tasks}}
        </div>
        <input type="text" v-model="test"/>

        <div>
            {{errors}}
        </div>


        <samplecomponent v-bind:tasks="tasks" v-bind:inputvalue="test"></samplecomponent>
    </div>
</template>

<script>
    Vue.component('samplecomponent', require('./SampleComponent.vue').default);
    export default {
        data() {
            return {
                test:"",
                tasks: [],
                update: {
                    firstName: 'Fred',
                    data: 'Flintstone'
                },
                errors: []
            }
        },
        methods: {
            getRecordId(id) {
                axios.get('http://tundor.test/tasks' + id)
                    .then((response) => this.tasks = response.data)
                    .catch(error => this.errors = error.response.data.errors);
            },
            saveRecord(id, name) {
                axios.put('http://tundor.test/tasks/' + id, {
                    id: id,
                    name: name
                })
                    .then(function (response) {
                        console.log(response.data);
                    })
            }
        },
        created() {
            axios.get('http://tundor.test/tasks')
                .then((response) => this.tasks = response.data)
                .catch((error) => this.errors = error.response);

        },
        mounted() {


        }
    }
</script>

<style type="text/css" scoped>

</style>
