<template>
    <div class="container">
        <ul>
            <li v-for="task in tasks">
                {{task.name}}
            </li>
            {{inputvalues}}
        </ul>
    </div>
</template>

<script>
    export default {
     props : ['tasks', 'inputvalues'],
        data(){
         return {

         }
        }
    }
</script>
