<template>
    <div>
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>

        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3"><a class="active" href="#test1">Nouvel Utilisateur</a></li>
                <li class="tab col s3"><a class="" href="#test2">Tous les Utilisateur</a></li>
            </ul>
            <div id="test1" class="col m12 s12">
                <div class="container">
                    <h4>Ajoutez un Utilisateur</h4>
                    <form @submit.prevent="" class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate">
                            <label for="">Nom d'utilisateur</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="email" class="validate">
                            <label for="">Adresse Email</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate">
                            <label for="">Telephone</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <dropdown :options="userType" :selected="object" v-on:updateOption="methodToRunOnSelect"></dropdown>
                        </div>
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
import dropdown from 'vue-dropdowns';
    export default {
        components : {
            Loading,
            dropdown
        },
        mounted() {
            $('.tabs').tabs();
        },
        data() {
            return {
                isLoading : false,
                fullPage : true,
                userType : [{
                    'type' : 'redacteur'
                }],
                object : {
                    name : 'type'
                }
            }
        },
        methods : {
            methodToRunOnSelect(payload) {
                this.object = payload;
            }
        },
        computed : {

        }
    }
</script>
