<template>
    <div class="w-4/5">
        <el-table :data="exchangesRatesList" border class="w-full">
            <el-table-column type="expand">
                <div class="w-full flex justify-start items-start">
                    <div class="flex flex-col justify-start items-start py-6 px-3">
                        <label for="currencyFrom">Devise principal:</label>
                        <input type="text" name="currencyFrom" />
                    </div>
                    <div class="flex flex-col justify-start items-start">
                        <label for="currencyFrom">Devise de conversion:</label>
                        <input type="text" name="currencyFrom" />
                    </div>
                    <div class="flex flex-col justify-start items-start">
                        <label for="currencyFrom">Taux de change:</label>
                        <input type="text" name="currencyFrom" />
                    </div>
                </div>
            </el-table-column>
            <el-table-column prop="currencyFrom.code" label="devise principal" class="w-full"></el-table-column>
            <el-table-column prop="currencyTo.code" label="devise de conversion" class="w-full" />
            <el-table-column prop="rate" label="Taux" class="w-full" />
            <el-table-column label="Operations" class="w-full">
                <el-button size="small">Modifier</el-button>
                <el-button
                    size="small"
                    type="danger"
                    @click="deleteDialogVisible = true">
                    Supprimer
                </el-button>
            </el-table-column>
        </el-table>

        <el-dialog
            v-model="deleteDialogVisible"
            title="Suppression d'un taux de change"
            width="30%"
            destroy-on-close
            center>
            <p class="pb-2">Vous êtes sur le point de supprimer un taux de change ainsi que l'ensemble de son paramétrage</p>
            <p><strong>Souhaitez-vous continuer ?</strong></p>
            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="deleteDialogVisible = false">Annuler</el-button>
                    <el-button type="danger" @click="deleteDialogVisible = false">Confirmer</el-button>
                </span>
            </template>
        </el-dialog>
    </div>
</template>

<script setup>
    import { onMounted, ref } from "vue";
    import axios from "axios"

    let exchangesRatesList = ref();
    let deleteDialogVisible = ref(false);

    onMounted(() => axios("http://127.0.01:8000/api/pairs").then(response => exchangesRatesList.value = response.data));
</script>