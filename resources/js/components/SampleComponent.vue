<template>
<<<<<<< HEAD
    <div class="container">
        <ul>
            <li v-for="task in tasks">
                {{task.name}}
            </li>
            {{inputvalues}}
        </ul>
=======
    <div class="container" style="border:solid 2px red;">
        <ul>
            <li v-for="task in tasks">
                {{task.task_name}}
            </li>
        </ul>
        {{inputvalue}}
>>>>>>> e72058590f80e413a7624d2ac5ae510483a0e0cc
    </div>



</template>

<script>
    export default {
<<<<<<< HEAD
     props : ['tasks', 'inputvalues'],
        data(){
         return {

         }
=======
        props: ['tasks','inputvalue'],
        data() {
            return {}
        },
        mounted() {
            console.log("go lol");
>>>>>>> e72058590f80e413a7624d2ac5ae510483a0e0cc
        }
    }
</script>
