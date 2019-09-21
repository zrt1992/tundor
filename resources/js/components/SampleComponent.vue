<template>
    <div class="container" style="border:solid 2px red;">
        <ul>
            <li v-for="task in tasks">
                {{task.task_name}}
            </li>
        </ul>
        {{inputvalue}}
    </div>



</template>

<script>
    export default {
        props: ['tasks','inputvalue'],
        data() {
            return {}
        },
        mounted() {
            console.log("go lol");
        }
    }
</script>
