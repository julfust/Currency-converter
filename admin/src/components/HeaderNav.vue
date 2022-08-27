<template>

    <ul class="self-start flex justify-start items-center py-6">
        
        <li class="pr-4" :class="{ active: selected === 'home' }">
            <RouterLink @click="selected = 'home'" to="/home">Taux de convertion</RouterLink>
        </li>

        <li :class="{ active: selected === 'request' }">
            <RouterLink @click="selected = 'request'" to="/request">Nombre de requêtes</RouterLink>
        </li>
    </ul>
</template>

<style>
    .active {
        color: #409eff;
    }
</style>

<script setup>
    import { RouterLink } from "vue-router";
    import { ref } from "vue";

    let selected = ref("home");

</script>