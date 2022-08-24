<template>
  <main class="w-full flex flex-col justify-start items-center py-12">
    <h1 class="text-2xl font-semibold underline pb-10">Exchange converter</h1>
    <ExchangesRatesList />
  </main>
</template>

<script setup>
  import ExchangesRatesList from '@/components/ExchangesRatesList.vue';
</script>
