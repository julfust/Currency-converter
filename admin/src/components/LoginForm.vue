<template>
    
    <el-form
        ref="ruleFormRef"
        :model="loginForm"
        :rules="rules"
        label-width="auto"
        size="default"
        label-position="top"
        status-icon
        class="w-1/2 flex flex-col justify-start items-center border-2 border-solid border-gray-200 border p-6 demo-ruleForm">
        
        <h2 class="text-xl font-semibold pb-4">Authentification</h2>

        <div class="flex flex-col justify-start items-center pb-6">

            <h3 class="text-md font-semibold text-center pb-2">Nom complet:</h3>

            <el-form-item prop="name">
                <el-input v-model="loginForm.name" />
            </el-form-item>
        </div>

        <div class="flex flex-col justify-start items-center pb-6">

            <h3 class="text-md font-semibold text-center pb-2">Adresse email:</h3>

            <el-form-item prop="email">
                <el-input v-model="loginForm.email" />
            </el-form-item>
        </div>

        <div class="flex flex-col justify-start items-center pb-6">

            <h3 class="text-md font-semibold text-center pb-2">Mots de passe:</h3>

            <el-form-item prop="password">
                <el-input 
                    v-model="loginForm.password" 
                    type="password" 
                    show-password />
            </el-form-item>
        </div>

        <div class="flex flex-col justify-start items-center pb-6">

            <h3 class="text-md font-semibold text-center pb-2">Confirmation mots de passe:</h3>

            <el-form-item prop="c_password">
                <el-input 
                    v-model="loginForm.c_password" 
                    type="password" 
                    show-password />
            </el-form-item>
        </div>

        <el-button
            type="primary" 
            @click="login">
            Connexion
        </el-button>
    </el-form>
</template>

<style scoped>

</style>

<script setup>
    import { reactive, ref } from "vue";
    import { useRouter } from "vue-router";
    import axios from "axios";

    const router = useRouter();

    const ruleFormRef = ref();

    let loginForm = reactive({
        name: "",
        email: "",
        password: "",
        c_password: ""
    });

    const rules = reactive({
        name: { required: true, message: "Ce champs est requis", trigger: "blur" },
        email: [
            { required: true, message: "Ce champs est requis", trigger: "blur" },
            { type: 'email', message: "Veuillez rentrer une adrresse mail valide", trigger: 'blur' }
        ],
        password: { required: true, message: "Ce champs est requis", trigger: "blur" },
        c_password: [
            { required: true, message: "Ce champs est requis", trigger: "blur" },
            { validator: checkConfirmPassword, trigger: "blur" }
        ]
    })

    function checkConfirmPassword(rule, value, callback) {

        if (value !== loginForm.password) {
            callback(new Error("Les deux mots de passe ne sont pas identiques"));
        } else {
            callback();
        }
    }

    async function login() {

        if(!ruleFormRef.value) {
            return;
        }

        await ruleFormRef.value.validate((valid, fields) => {

            if(valid) {

                axios.post('http://127.0.0.1:8000/api/login', loginForm).then(res => {

                    localStorage.setItem("authenticationToken", res.data.data.token);
                    router.push("/home");
                });
            }
        })
    }
</script>