<script setup>
  import HomeView from "@/views/HomeView.vue";
  import HeaderNav from "@/components/HeaderNav.vue";
  import { RouterView } from "vue-router";
</script>

<template>
  <main class="w-full flex justify-center items-start py-12">
    <div class="w-4/5 flex flex-col justify-start items-center py-12">
      <h1 class="text-2xl font-semibold underline pb-10">Exchange converter</h1>
      <HeaderNav />
      <RouterView />
    </div>
  </main>
</template>
