<template>
    
</template>

<style scoped>

</style>

<script setup>
    import { onMounted } from "vue";
    import axios from "axios";

   onMounted(() => axios.post('http://127.0.0.1:8000/api/register')
    .then(response => {
        console.log(response);
    }));
</script>