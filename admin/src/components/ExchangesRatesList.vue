<template>
    <div class="w-4/5">

        <div class="w-full flex justify-end items-start pb-4">
            <el-button 
                type="primary" 
                @click="initNewPair"
                :disabled="expands.includes('new')">
                Ajouter un taux de change
            </el-button>
        </div>

        <el-table 
            class="w-full"
            border
            :data="exchangesRatesList" 
            :row-key='getRowKeys'
            :expand-row-keys="expands"
            :row-class-name="tableRowClassName">

            <el-table-column #default="props" type="expand">
                
                <el-form
                    ref="ruleFormRef"
                    :model="exchangesRateForm"
                    :rules="rules"
                    class="demo-ruleForm"
                    label-width="auto"
                    size="default"
                    label-position="top"
                    status-icon>

                    <div class="flex flex-col justify-start items-center pt-6">

                        <div class="flex flex-col justify-start items-center pb-6">

                            <h2 for="currencyFrom" class="text-md font-semibold text-center pb-2">Devise principale:</h2>

                            <el-form-item prop="currencyFromId">

                                <el-select 
                                    class="w-96" 
                                    name="currencyFrom" 
                                    v-model="exchangesRateForm.currencyFromId">

                                    <template v-for="currency in currenciesList" :key="currency.id">
                                        <el-option 
                                            v-model="exchangesRateForm.currencyFromId" 
                                            :label="currency.code" 
                                            :value="currency.id">
                                            {{ currency.code }} ( {{ currency.name }} )
                                        </el-option>
                                    </template>
                                </el-select>
                            </el-form-item>
                        </div>

                        <div class="flex flex-col justify-start items-center pb-6">

                            <h2 for="currencyTo" class="text-md font-semibold text-center pb-2">Devise secondaire:</h2>

                            <el-form-item prop="currencyToId">

                                <el-select 
                                    class="w-96" 
                                    name="currencyTo" 
                                    v-model="exchangesRateForm.currencyToId">

                                    <template v-for="currency in currenciesList" :key="currency.id">
                                        <el-option 
                                            v-model="exchangesRateForm.currencyToId" 
                                            :label="currency.code" 
                                            :value="currency.id">
                                            {{ currency.code }} ( {{ currency.name }} )
                                        </el-option>
                                    </template>
                                </el-select>
                            </el-form-item>
                        </div>

                        <div class="flex flex-col justify-start items-center pb-6">

                            <h2 for="rate" class="text-md font-semibold text-center pb-2">Taux de change:</h2>
                            
                            <el-form-item prop="rate">
                                
                                <el-input-number
                                    name="rate"
                                    :step="0.01"
                                    :min="0.01"
                                    controls-position="right"
                                    v-model="exchangesRateForm.rate" />
                            </el-form-item>
                        </div>

                        <div class="w-full flex justify-center items-center pb-6">

                            <el-button 
                                v-if="props.row.id === 'new'"
                                type="success"
                                @click="createPair">
                                Créer
                            </el-button>

                            <el-button 
                                v-if="props.row.id !== 'new'" 
                                type="primary" 
                                @click="updatePair(props.row.id)">
                                Enregistrer
                            </el-button>

                            <el-button @click="toggleForm(props.row)">Fermer</el-button> 
                        </div>
                    </div>
                </el-form>
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
                    @click="deletedDialogId = props.row.id">
                    Supprimer
                </el-button>
            </el-table-column>
        </el-table>

        <el-dialog
            v-model="deletedDialogId"
            title="Suppression d'un taux de change"
            width="30%"
            destroy-on-close
            center>
            <p class="pb-2">Vous êtes sur le point de supprimer un taux de change ainsi que l'ensemble de son paramétrage</p>
            <p><strong>Souhaitez-vous continuer ?</strong></p>
            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="deletedDialogId = null">Annuler</el-button>
                    <el-button type="danger" @click="deletePair(deletedDialogId)">Confirmer</el-button>
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
    import axios from "axios";

    const getRowKeys = (row) => row.id;
    const tableRowClassName = (item) => item.rowIndex === 0 && item.row.id === "new" ? 'success-row' : '';

    let currenciesList = ref();
    let exchangesRatesList = ref();

    const ruleFormRef = ref();
    const exchangesRateForm = reactive({
        currencyFromId: null,
        currencyToId: null,
        rate: null
    });

    const rules = reactive({
        currencyFromId: [ { required: true, message: 'Cette valeur est requise', trigger: 'blur' } ],
        currencyToId: [ { required: true, message: 'Cette valeur est requise', trigger: 'blur' } ],
        rate: [ { required: true, message: 'Cette valeur est requise', trigger: 'blur' } ]
    });

    let deletedDialogId = ref(null);
    let expands = ref([]);

    onMounted(() => {

        Promise.all([axios("http://127.0.0.1:8000/api/currencies"), axios("http://127.0.0.1:8000/api/pairs")])
        .then(response => {

            currenciesList.value = response[0].data;
            exchangesRatesList.value = response[1].data;
        });
    })

    function toggleForm(row) {

        let previousSelect = null;

        if (expands.value.length) {

            previousSelect = expands.value[0];
            closeForm();
        }

        if(row && previousSelect !== row.id) {
             
            exchangesRateForm.currencyFromId = row.currencyFrom.id;
            exchangesRateForm.currencyToId = row.currencyTo.id;
            exchangesRateForm.rate = row.rate;

            expands.value.push(row.id);
        }
    }

    function initNewPair() {

        exchangesRatesList.value.unshift({
            id: "new",
            currencyFrom: { code: "", name: ""},
            currencyTo: { code: "", name: ""},
            rate: 1
        });

        closeForm();

        exchangesRateForm.rate = 1;

        expands.value.push("new");
    }

    function closeForm() {

        if(expands.value.includes("new")) {

            exchangesRatesList.value.shift();
        }

        expands.value = [];

        exchangesRateForm.currencyFromId = null;
        exchangesRateForm.currencyToId = null;
        exchangesRateForm.rate = null;
    }

    async function createPair() {

        if(!ruleFormRef.value) { 
            return;
        }

        await ruleFormRef.value.validate((valid, fields) => {

            if (valid) {

                axios.post("http://127.0.0.1:8000/api/pairs", exchangesRateForm).then(res => {

                    expands.value = [];
                    exchangesRatesList.value.shift();
                    exchangesRatesList.value.unshift(res.data);
                });
            }
        });
    }

    async function updatePair(id) {

        if(!ruleFormRef.value) { 
            return;
        }
        
        await ruleFormRef.value.validate((valid, fields) => {

            if(valid) {

                axios.put(`http://127.0.0.1:8000/api/pairs/${id}`, exchangesRateForm).then(res => {

                    let exchangesRatesListCopy = [...exchangesRatesList.value];
                    const exchangesRateIndex = exchangesRatesListCopy.findIndex(exchangesRate => exchangesRate.id === id);

                    exchangesRatesListCopy[exchangesRateIndex] = res.data;
                    exchangesRatesList.value = exchangesRatesListCopy;
                })
            }
        })
    }

    function deletePair(id) {

        axios.delete(`http://127.0.0.1:8000/api/pairs/${id}`).then(res => {

            if(expands.value.includes(id)) {
                
                expands.value = [];
            }

            exchangesRatesList.value = exchangesRatesList.value.filter(exchangesRate => exchangesRate.id !== id);

            deletedDialogId.value = null;
        })
    }
</script>