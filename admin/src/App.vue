<script setup>
  import HomeView from "@/views/HomeView.vue";
  import Header from "@/components/Header.vue";
</script>

<template>
  <main class="w-full flex justify-center items-start py-12">

    <div class="w-4/5 flex flex-col justify-start items-center py-12">

      <RouterView />
    </div>
  </main>
</template>
