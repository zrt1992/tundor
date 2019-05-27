<template>
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <textarea v-model="record"></textarea>
                    <ul>
                        <li>asdasd</li>
                    </ul>
                    <ul >
                        <li class="alert alert-danger" v-for="err of error.names">
                            {{ err }}
                        </li>
                    </ul>

                </div>


                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" v-on:click="addRecord">Save</button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                record: '',
                error: [],

            }
        },
        methods: {
            addRecord() {
                axios.post('http://tundor.test/tasks', {
                    'names': this.record,
                })
                    .then(data => this.$emit('recordAdded', data))
                    .catch(error => {
                        this.error = error.response.data.errors;
                        console.log(error.response.data.errors);
                    })

            }

        },
        mounted() {
            console.log('Modal Component mounted.')
        }
    }
</script>

<style type="text/css" scoped>

</style>