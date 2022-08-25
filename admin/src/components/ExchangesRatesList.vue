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
                        <el-input 
                            name="currencyFrom" 
                            v-model="exchangesRateForm.currencyFrom.code" 
                            @blur="v$.currencyFrom.code.$touch" />
                        <p 
                            v-for="error of v$.currencyFrom.code.$errors" 
                            :key="error.$uid" 
                            class="self-start font-semibold text-red-600">
                            {{ error.$message }}
                        </p>
                    </div>

                    <div class="flex flex-col justify-start items-center pb-10">
                        <label for="currencyFrom" class="pb-2">Nom:</label>
                        <el-input 
                            name="currencyFrom" 
                            v-model="exchangesRateForm.currencyFrom.name" 
                            @blur="v$.currencyFrom.name.$touch" />
                        <p 
                            v-for="error of v$.currencyFrom.name.$errors" 
                            :key="error.$uid" 
                            class="self-start font-semibold text-red-600">
                            {{ error.$message }}
                        </p>
                    </div>

                    <div class="col-span-2 flex justify-center items-center">
                        <h2 class="text-base font-semibold">Devise secondaire:</h2>
                    </div>

                    <div class="flex flex-col justify-start items-center">
                        <label for="currencyFrom" class="pb-2">Code:</label>
                        <el-input 
                            name="currencyTo" 
                            v-model="exchangesRateForm.currencyTo.code" 
                            @blur="v$.currencyTo.code.$touch" />
                        <p 
                            v-for="error of v$.currencyTo.code.$errors" 
                            :key="error.$uid" 
                            class="self-start font-semibold text-red-600">
                            {{ error.$message }}
                        </p>
                    </div>

                    <div class="flex flex-col justify-start items-center pb-10">
                        <label for="currencyFrom" class="pb-2">Nom:</label>
                        <el-input 
                            name="currencyTo" 
                            v-model="exchangesRateForm.currencyTo.name" 
                            @blur="v$.currencyTo.name.$touch" />
                        <p 
                            v-for="error of v$.currencyTo.name.$errors" 
                            :key="error.$uid" 
                            class="self-start font-semibold text-red-600">
                            {{ error.$message }}
                        </p>
                    </div>

                    <div class="flex flex-auto flex-col justify-start items-center col-span-2 pb-8">
                        <label for="rate" class="text-base font-semibold pb-4">Taux de change:</label>
                        <el-input-number 
                            :step="0.01"
                            :min="0.01"
                            controls-position="right"
                            v-model="exchangesRateForm.rate"
                            @blur="v$.rate.$touch" />
                        <p 
                            v-for="error of v$.rate.$errors"
                            :key="error.$uid"
                            class="font-semibold text-red-600">
                            {{ error.$message }}
                        </p>
                    </div>

                    <div class="flex justify-center items-center col-span-2 pb-8">
                        <el-button 
                            v-if="props.row.id === 'new'"
                            type="success"
                            @click="createPair"
                            :disabled="v$.$invalid">
                            Créer
                        </el-button>
                        <el-button v-if="props.row.id !== 'new'" type="primary">Enregistrer</el-button>
                        <el-button @click="toggleForm(props.row)">Annuler</el-button>
                    </div>

                </div>
            </el-table-column>

            <el-table-column #default="props" label="devise principal" class="w-full">
                <div class="flex flex-col justify-start items-start">
                    <span class="text-md">{{ props.row.currencyFrom.code }}</span>
                    <span class="text-sm">{{ props.row.currencyFrom.name }}</span>
                </div>
            </el-table-column>

            <el-table-column #default="props" label="devise de conversion" class="w-full">
                <div class="flex flex-col justify-start items-start">
                    <span class="text-md">{{ props.row.currencyTo.code }}</span>
                    <span class="text-sm">{{ props.row.currencyTo.name }}</span>
                </div>
            </el-table-column>

            <el-table-column prop="rate" label="Taux" class="w-full" />

            <el-table-column #default="props" label="Operations" class="w-full">
                <el-button 
                    v-if="props.row.id !== 'new'"
                    size="small"
                    type="primary"
                    @click="toggleForm(props.row)">
                    Modifier
                </el-button>
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
    .el-table .success-row {
        --el-table-tr-bg-color: var(--el-color-success-light-9) !important;
    }
</style>

<script setup>
    import { onMounted, reactive, ref } from "vue";
    import useVuelidate from '@vuelidate/core';
    import { required, minLength, maxLength, helpers } from '@vuelidate/validators';
    import axios from "axios";

    const getRowKeys = (row) => row.id;

    const tableRowClassName = (item) => {

        if (item.rowIndex === 0 && item.row.id === "new") {
            return 'success-row'
        }

        return ''
    }

    let exchangesRatesList = ref();

    const exchangesRateForm = reactive({
        currencyFrom: {
            code: "",
            name: ""
        },
        currencyTo: {
            code: "",
            name: ""
        },
        rate: 0
    });

    const rules = {
        currencyFrom: {
            code: {
                required: helpers.withMessage('Cette valeur est requise', required), 
                minLength: helpers.withMessage('Le code de la devise doit faire 3 caractères', minLength(3)),
                maxLength: helpers.withMessage('Le code de la devise doit faire 3 caractères', maxLength(3))
            },
            name: { required: helpers.withMessage('Cette valeur est requise', required) }
        },
        currencyTo: {
            code: {
                required: helpers.withMessage('Cette valeur est requise', required), 
                minLength: helpers.withMessage('Le code de la devise doit faire 3 caractères', minLength(3)),
                maxLength: helpers.withMessage('Le code de la devise doit faire 3 caractères', maxLength(3))
            },
            name: { required: helpers.withMessage('Cette valeur est requise', required) }
        },
        rate: { required: helpers.withMessage('Cette valeur est requise', required) }
    };

    const v$ = useVuelidate(rules, exchangesRateForm);

    let deleteDialogVisible = ref(false);
    let expands = ref([]);

    onMounted(() => {

        axios("http://127.0.0.1:8000/api/pairs").then(response => exchangesRatesList.value = response.data);
    })

    function toggleForm(row) {

        let previousSelect = null;

        if (expands.value.length) {

            previousSelect = expands.value[0];
            closeForm();
        }

        if(row && previousSelect !== row.id) {
             
            exchangesRateForm.currencyFrom.code = row.currencyFrom.code, 
            exchangesRateForm.currencyFrom.name = row.currencyFrom.name,
            exchangesRateForm.currencyTo.code = row.currencyTo.code, 
            exchangesRateForm.currencyTo.name = row.currencyFrom.name, 
            exchangesRateForm.rate = row.rate

            expands.value.push(row.id);
        }
    }

    function closeForm() {

        if(expands.value.includes("new")) {

            exchangesRatesList.value.shift();
        }

        expands.value = [];

        exchangesRateForm.currencyFrom.code = null;
        exchangesRateForm.currencyFrom.name = null;

        exchangesRateForm.currencyTo.code = null;
        exchangesRateForm.currencyTo.name = null;

        exchangesRateForm.rate = null;
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
                code: exchangesRateForm.currencyFrom.code.trim().toUpperCase(),
                name: exchangesRateForm.currencyFrom.name.trim()
            },
            currencyTo: {
                code: exchangesRateForm.currencyTo.code.trim().toUpperCase(),
                name: exchangesRateForm.currencyTo.name.trim()
            },
            rate: exchangesRateForm.rate
        }

        axios.post("http://127.0.0.1:8000/api/pairs", formatedData).then(res => {

            expands.value = [];
            exchangesRatesList.value.shift();
            exchangesRatesList.value.unshift(res.data);
        });
    }

    function updatePair() {
        
        console.log(exchangesRateForm);
    }
</script>