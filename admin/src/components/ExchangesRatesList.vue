<template>
    <div class="w-4/5">
        <div class="w-full flex justify-end items-start pb-4">
            <el-button type="primary" @click="initNewPair">Ajouter un taux de change</el-button>
        </div>
        <el-table 
            class="w-full"
            border
            :data="exchangesRatesList" 
            :row-key='getRowKeys'
            :expand-row-keys="expands"
            :row-class-name="tableRowClassName">
            <el-table-column #default="props" type="expand">

                <div class="grid grid-cols-2 gap-x-8 px-6 py-3">

                    <div class="col-span-2 flex justify-center items-center">
                        <h2 class="text-base font-semibold">Devise principale:</h2>
                    </div>

                    <div class="flex flex-col justify-start items-center">
                        <label for="currencyFrom" class="pb-2">Code:</label>
                        <el-input name="currencyFrom" v-model="primaryCurrencyCode" />
                    </div>

                    <div class="flex flex-col justify-start items-center pb-10">
                        <label for="currencyFrom" class="pb-2">Nom:</label>
                        <el-input name="currencyFrom" v-model="primaryCurrencyName" />
                    </div>

                    <div class="col-span-2 flex justify-center items-center">
                        <h2 class="text-base font-semibold">Devise secondaire:</h2>
                    </div>

                    <div class="flex flex-col justify-start items-center">
                        <label for="currencyFrom" class="pb-2">Code:</label>
                        <el-input name="currencyTo" v-model="secondaryCurrencyCode" />
                    </div>

                    <div class="flex flex-col justify-start items-center pb-10">
                        <label for="currencyFrom" class="pb-2">Nom:</label>
                        <el-input name="currencyTo" v-model="secondaryCurrencyName" />
                    </div>

                    <div class="flex flex-auto flex-col justify-start items-center col-span-2 pb-8">
                        <label for="rate" class="text-base font-semibold pb-4">Taux de change:</label>
                        <el-input-number :step="0.01" controls-position="right" v-model="exchangesRate" />
                    </div>

                    <div class="flex justify-center items-center col-span-2">
                        <el-button v-if="props.row.id === 'new'" type="success" @click="createPair">Créer</el-button>
                        <el-button v-if="props.row.id !== 'new'" type="primary">Enregistrer</el-button>
                        <el-button @click="toggleForm(props.row)">Annuler</el-button>
                    </div>
                </div>
            </el-table-column>
            <el-table-column #default="props" label="devise principal" class="w-full">
                <div class="flex flex-col justify-start items-start">
                    <span class="text-md">{{ props.row.currencyTo.code }}</span>
                    <span class="text-sm">{{ props.row.currencyTo.name }}</span>
                </div>
            </el-table-column>
            <el-table-column #default="props" label="devise de conversion" class="w-full">
                <div class="flex flex-col justify-start items-start">
                    <span class="text-md">{{ props.row.currencyFrom.code }}</span>
                    <span class="text-sm">{{ props.row.currencyFrom.name }}</span>
                </div>
            </el-table-column>
            <el-table-column prop="rate" label="Taux" class="w-full" />
            <el-table-column #default="props" label="Operations" class="w-full">
                <el-button 
                    v-if="props.row.id !== 'new'"
                    size="small"
                    type="primary"
                    @click="toggleForm(props.row)">Modifier</el-button>
                <el-button
                    v-if="props.row.id !== 'new'"
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

<style>
    .el-table .warning-row {
    --el-table-tr-bg-color: var(--el-color-warning-light-9) !important;
    }
    .el-table .success-row {
        --el-table-tr-bg-color: var(--el-color-success-light-9) !important;
    }
</style>

<script setup>
    import { onMounted, ref } from "vue";
    import axios from "axios"

    const tableRowClassName = (item) => {

        if (item.rowIndex === 0 && item.row.id === "new") {
            return 'success-row'
        }

        return ''
    }

    let exchangesRatesList = ref();

    let primaryCurrencyCode = ref(null);
    let primaryCurrencyName = ref(null);
    let secondaryCurrencyCode = ref(null);
    let secondaryCurrencyName = ref(null);
    let exchangesRate = ref(null);

    let deleteDialogVisible = ref(false);
    let expands = ref([]);

    onMounted(() => {

        axios("http://127.0.0.1:8000/api/pairs")
        .then(response => exchangesRatesList.value = response.data);
    });

    function getRowKeys (row) {
        return row.id
    }

    function toggleForm(row) {

        let previousSelect = null;

        if (expands.value.length) {

            previousSelect = expands.value[0];
            closeForm();
        }

        if(row && previousSelect !== row.id) {

            primaryCurrencyCode.value = row.currencyFrom.code;
            primaryCurrencyName.value = row.currencyFrom.name;

            secondaryCurrencyCode.value = row.currencyTo.code;
            secondaryCurrencyName.value = row.currencyTo.name;

            exchangesRate.value = row.rate;

            expands.value.push(row.id);
        }
    }

    function closeForm() {

        if(expands.value.includes("new")) {

            exchangesRatesList.value.shift();
        }

        expands.value = [];

        primaryCurrencyCode.value = null;
        primaryCurrencyName.value = null;

        secondaryCurrencyCode.value = null;
        secondaryCurrencyName.value = null;

        exchangesRate.value = null;
    }

    function initNewPair() {

        exchangesRatesList.value.unshift({
            id: "new",
            currencyFrom: { code: "", name: ""},
            currencyTo: { code: "", name: ""},
            rate: 1
        });

        expands.value = [];
        expands.value.push("new");
    }

    function createPair() {

        const formatedData = {
            currencyFrom: {
                code: primaryCurrencyCode.value,
                name: primaryCurrencyName.value
            },
            currencyTo: {
                code: secondaryCurrencyCode.value,
                name: secondaryCurrencyName.value
            },
            rate: exchangesRate.value
        }

        axios.post("http://127.0.0.1:8000/api/pairs", formatedData).then(res => console.log(res));
    }

    function updatePair() {
        
        console.log(primaryCurrency);
        console.log(secondaryCurrency);
        console.log(exchangesRate);
    }
</script>