<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All todo Tasks</div>

                    <div class="card-body">

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Open modal
                        </button>

                        <ul class="list-group" v-for=" t in tasks">
                           <li>{{t.id}} - {{t.names}}


                           </li>

                       </ul>

                    </div>
                </div>
            </div>


        </div>
        <addtask @recordAdded="refreshRecord"></addtask>
    </div>



</template>



<script>
    // window.onload = function() {
    //     if (window.jQuery) {
    //         // jQuery is loaded
    //         alert("Yeah!");
    //     } else {
    //         // jQuery is not loaded
    //         alert("Doesn't Work");
    //     }
    // },
    Vue.component('addtask', require('./addModelComponent.vue').default);
    export default {
        data(){
            return{
                tasks:{},

            }
        },
        methods:{
            refreshRecord(record){
                this.tasks.unshift(record.data)
            }

        },
        created(){
            axios.get('http://tundor.test/tasks')
                .then((response)=>this.tasks=response.data)
                .catch((error) => console.log(error));

        },
        mounted() {
            console.log('Task Component mounted.')
        }
    }
</script>

<style type="text/css" scoped>

</style>