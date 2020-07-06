<template>
    <div>
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>

        <div class="container mx-auto">
            <div class="w-full max-w-xs">
                <form @submit.prevent="loginUser()" class="bg-white shadow-md rounded px-8 pt-6 pb-8 ml-64 mt-48 w-full">
                    <h1 class="text-3xl">Authentification</h1>
                    <template v-if="errors">
                        <div class="bg-red-600 rounded p-2 m-2 text-white shadow-md" v-for="e in errors" :key="e">
                            <span >{{e}}</span>
                        </div>
                    </template>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                            E-mail
                        </label>
                        <input v-model="formData.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="email" placeholder="Adresse Email">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <input v-model="formData.password" class="shadow appearance-none  rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        components : {
            Loading
        },
        mounted() {
            
        },
        data() {
            return {
                isLoading : false,
                fullPage : true,
                formData : {
                    _token : document.querySelector("meta[name='csrf-token']").content,
                    email : "",
                    password : ""
                },
                errors : []
            }
        },
        methods: {
            loginUser : async function () {
                try {
                    this.isLoading = true
                    let response = await axios.post('/connexion',this.formData)
                    
                    if(response.data == 'done') {
                        this.isLoading = false
                        alert('success!')
                        location.reload()
                    }
                } catch(error) {
                    
                    if(error.response.data.errors) {
                        let errorTab = error.response.data.errors
                        for (var prop in errorTab) {
                            this.errors.push(errorTab[prop][0])
                        }
                    } else {
                        this.errors.push(error.response.data)
                    }
                }
            }
        },
        computed : {

        }
    }
</script>
