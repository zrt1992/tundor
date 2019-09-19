<template>
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


        </div>
        <addtask @recordAdded="refreshRecord"></addtask>
        <edittask :rec="editRec"></edittask>
        <sample-component v-bind:inputvalues="heybaby"></sample-component>
    </div>
</template>


<script>

    import SampleComponent from "./SampleComponent";
    Vue.component('addtask', require('./addModelComponent.vue').default);
    Vue.component('edittask', require('./EditModelComponent.vue').default);
    export default {
        components: {SampleComponent},
        data() {
            return {
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
            }

        },
        created() {
            axios.get('http://tundor.test/tasks')
                .then((response) => this.tasks = response.data)
                .catch((error) => console.log(error));

        },
        mounted() {
            console.log('Task Component mounted.')
        }
    }
</script>

<style type="text/css" scoped>

</style>
