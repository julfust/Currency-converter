<template>
    
    <section class="w-full">

        <el-table 
            class="w-full"
            border
            :data="conversionRequestList">

            <el-table-column #default="props" label="devise principal" class="w-full">
                
                <div class="flex flex-col justify-start items-start">
                    
                    <span class="text-md">{{ props.row.pair.currencyFrom.code }}</span>
                    <span class="text-sm">{{ props.row.pair.currencyFrom.name }}</span>
                </div>
            </el-table-column>

            <el-table-column #default="props" label="devise de conversion" class="w-full">

                <div class="flex flex-col justify-start items-start">

                    <span class="text-md">{{ props.row.pair.currencyTo.code }}</span>
                    <span class="text-sm">{{ props.row.pair.currencyTo.name }}</span>
                </div>
            </el-table-column>

            <el-table-column prop="number" label="Nombre de requêtes" class="w-full" />
        </el-table>
    </section>
</template>

<script setup>

    import { ref, onMounted } from "vue";
    import axios from "axios";

    let conversionRequestList = ref();

    onMounted(() => {
        axios("http://localhost:8000/api/conversion-request").then(res => {conversionRequestList.value = res.data; console.log(conversionRequestList.value)});
    })
</script>