<template>

    <div class="self-start">
        <el-button type="danger" @click="logout">Déconnexion</el-button>
    </div>

    <h1 class="text-2xl font-semibold underline pb-10">Exchange converter</h1>

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
    import { ref } from "vue";
    import { RouterLink, useRouter } from "vue-router";

    // Variable for using navigation programmatically
    const router = useRouter();

    // Variable for v-bind class render on nav-link active (text-color)
    let selected = ref("home");

    // Function used for user logout
    function logout() {

        localStorage.removeItem("authenticationToken");
        router.push("/");
    }

</script>