<template>
    <div>
        <form @submit.prevent="" class="col s12">
            <div class="row">
                <div class="input-field col s6">
                    <input id="nom_complet" type="text" class="validate">
                    <label for="nom_complet">Nom Complet</label>
                </div>
                <div class="input-field col s6">
                    <input id="email" type="email" class="validate">
                    <label for="email">Adresse Email</label>
                </div>
                <div class="input-field col s12">
                    <input id="sujet" type="text" class="validate">
                    <label for="sujet">Objet</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="content" class="materialize-textarea"></textarea>
                    <label for="content">Message</label>
                </div>
            </div>
            <button class="btn waves-effect waves-light light-blue darken-4">Envoyez</button>
        </form>
    </div>
</template>
<script>
    export default {
        mounted() {
            
        },
        data() {
            return {

            }
        },
        methods : {

        },
        computed : {

        }
    }
</script>
