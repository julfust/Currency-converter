<script setup>
  import HomeView from "@/views/HomeView.vue";
  import Header from "@/components/Header.vue";
  import { RouterView, useRouter } from "vue-router";

  const router = useRouter();

  function logout() {

    localStorage.removeItem("authenticationToken");
    router.push("/");
  }
</script>

<template>
  <main class="w-full flex justify-center items-start py-12">

    <div class="w-4/5 flex flex-col justify-start items-center py-12">

      <RouterView />
    </div>
  </main>
</template>
