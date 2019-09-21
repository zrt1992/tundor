<template>
<<<<<<< HEAD
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All todo Tasks</div>

                    <div class="card-body">

                        <button type="button"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#myModal">
                            Open modal
                        </button>

                        <ul class="list-group" v-for=" t in tasks">
                            <li>
                                {{t.id}} - {{t.name}}
                                <button type="button"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#editModal">
                                    Edit
                                </button>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

=======
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
>>>>>>> e72058590f80e413a7624d2ac5ae510483a0e0cc

        <div>
            {{errors}}
        </div>
<<<<<<< HEAD
        <addtask @recordAdded="refreshRecord"></addtask>
        <edittask :rec="editRec"></edittask>
        <sample-component v-bind:inputvalues="heybaby"></sample-component>
=======


        <samplecomponent v-bind:tasks="tasks" v-bind:inputvalue="test"></samplecomponent>
>>>>>>> e72058590f80e413a7624d2ac5ae510483a0e0cc
    </div>
</template>

<script>
<<<<<<< HEAD

    import SampleComponent from "./SampleComponent";
    Vue.component('addtask', require('./addModelComponent.vue').default);
    Vue.component('edittask', require('./EditModelComponent.vue').default);
=======
    Vue.component('samplecomponent', require('./SampleComponent.vue').default);
>>>>>>> e72058590f80e413a7624d2ac5ae510483a0e0cc
    export default {
        components: {SampleComponent},
        data() {
            return {
<<<<<<< HEAD
                heybaby:"why are you fucing doing this asd",
                tasks: {},
                editRec:{},
                errors:[],


            }
        },
        methods: {
            refreshRecord(record) {
                this.tasks.unshift(record.data)
            },
            getRecordId(id){
                // axios.get('http://tundor.test/tasks'+id)
                //     .then((response) => this.tasks = response.data)
                //     .catch( error => this.errors= error.response.data.errors);
=======
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
>>>>>>> e72058590f80e413a7624d2ac5ae510483a0e0cc
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
