<template>
    <div class="container row">
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        background-color="#FFF"
        opacity="1"
        color="blue"></loading>

        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3"><a class="active" href="#test1">Nouvel Utilisateur</a></li>
                <li class="tab col s3"><a class="" href="#test2">Tous les Utilisateur</a></li>
            </ul>
            <div id="test1" class="col m12 s12">
                <div class="container">
                    <h4>Ajoutez un Utilisateur</h4>
                    <template v-if="errors">
                        <div class="red darken-1 white-text" style="margin : 1% ; padding : 1%;" v-for="e in errors" :key="e">
                            <span >{{e}}</span>
                        </div>
                    </template>
                    <form @submit.prevent="addNewUser()" class="row">
                        <div class="input-field col s12 m6">
                            <input v-model="data.name" type="text" class="validate">
                            <label for="">Nom d'utilisateur</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input v-model="data.email" type="email" class="validate">
                            <label for="">Adresse Email</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input v-model="data.phone" type="text" class="validate">
                            <label for="">Telephone</label>
                        </div>
                        <div class="input-field col s12 m6" >
                            <select v-model="data.typeUser">
                                <option value="" disabled selected>-- Choisissez un type --</option>
                                <option v-for="t in userType" :key="t.type" :value="t.type">{{ t.type }}</option>
                            </select>
                            <label>User Type</label>
                        </div>
                        <button type="submit" class="btn">Validez</button>
                    </form>
                </div>
            </div>
            <div id="test2" class="col m12 s12">
                <div class="container">
                    <h4>Les Utilisateurs</h4>
                </div>
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
            $('.tabs').tabs();
            $('select').formSelect();
        },
        data() {
            return {
                isLoading : false,
                fullPage : true,
                userType : [{
                    'type' : 'redacteur'
                }],
                data : {
                    _token : "",
                    name : "",
                    email : "",
                    phone : "",
                    typeUser : ""
                },
                errors : []
            }
        },
        methods : {
            addNewUser : async function () {
                try {
                    this.isLoading = true
                    this.data._token = document.querySelector("meta[name=csrf-token]").content
                    let response  = await axios.post('/admin/users/add',this.data)

                    if(response.data == 'done') {
                        this.isLoading = false
                        alert("Success !")
                        location.reload()
                    }
                    
                } catch(error) {
                    this.isLoading = false
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
