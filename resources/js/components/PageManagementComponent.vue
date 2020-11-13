<template>
    <div>
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>

        <div class="container">
            <template v-if="errorState">
                <div class="red darken-4 card-panel" v-for="err in errors" :key="err[0]">
                    <span class="white-text">{{err[0]}}</span>
                </div>
            </template>
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="material-icons">add</i> Ajouter une page</div>
                    <div class="collapsible-body">
                        <form @submit.prevent="addPage()" class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input v-model="pageFormData.title" id="title" type="text" class="validate">
                                    <label for="title">Titre de la page</label>
                                </div>
                                <div class="input-field col s6">
                                    <input v-model="pageFormData.tag" type="text" id="tag" class="validate">
                                    <label for="tag">Onglet de la page</label>
                                </div>
                                <div class="input-field col s12">
                                    <!-- <textarea v-model="pageFormData.content" id="content" class="materialize-textarea"></textarea> -->
                                    <VueEditor v-model="pageFormData.content" class="validate"></VueEditor>
                                </div>
                            </div>
                            <button class="btn waves-effect waves-light light-blue darken-4">Envoyez</button>
                        </form>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">list</i> Toutes les pages</div>
                    <div class="collapsible-body">
                        <div class="collection">
                            <a v-for="l in listPages" :key="l.slug" href="#modal1" class="collection-item blue-text darken-4 modal-trigger" 
                            @click="EditArticle(l.slug)" >{{ l.title }}</a>
                            <!-- <a class="waves-effect waves-light btn modal-trigger" 
                            @click="EditArticle(article.slug)" href="#modal1"><i class="materialize-textareaterial-icons">edit</i></a> -->
                        </div>
                                
                    </div>
                </li>
            </ul>
             <!-- Modal Structure -->
                  <div id="modal1" class="modal">
                    <div class="modal-content">
                      <h4>Editer cet Article</h4>
                        <form @submit.prevent="updatePage()" class="col s12">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input v-model="titlePage" id="title" type="text" class="validate">
                                    <label for="title"></label>
                                </div>
                                <div class="input-field col s6">
                                    <input v-model="tagPage" type="text" id="tag" class="validate">
                                    <label for="tag"></label>
                                </div>
                                <div class="input-field col s12">
                                    <!-- <textarea v-model="pageFormData.content" id="content" class="materialize-textarea"></textarea> -->
                                    <VueEditor v-model="contenu" class="validate"></VueEditor>
                                </div>
                            </div>
                            <button class="modal-close btn waves-effect waves-light light-blue darken-4">Envoyez</button>
                            <a class="modal-close waves-effect #b71c1c red darken-4 btn" 
                            @click="WaveOutPage(slug)" ><i class="material-icons">delete_sweep</i></a>
                        </form>
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
import { VueEditor } from 'vue2-editor'
    
            $(document).ready(function(){
            $('.modal').modal();
            });
    
    export default {
        components : {
            Loading ,
            VueEditor
        },
        mounted() {
            $('.collapsible').collapsible();
            // 
            this.getListPages()
        },
        data() {
            return {
                pageFormData : {
                    title : "",
                    content : "",
                    tag : "",
                    _token : ""
                },
                isLoading : false,
                fullPage : true,
                errors : [],
                errorState : false,
                listPages : [],
                slug : "",
                titlePage : "",
                contenu : "",
                tagPage : ""
            }
        },
        methods : {
            getListPages : async function () {
                try {
                    let response = await axios.get('/admin/page')
                    this.listPages = response.data
                } catch(error) {
                    alert(error)
                }
            },

            EditArticle :async function (slug){

                 try {
                    let response = await axios.get('/admin/edit-page' + slug)
                    this.slug = response.data.slug;
                    this.titlePage = response.data.title;
                    this.contenu = response.data.content;
                    this.tagPage = response.data.tag;
                } catch(error) {
                    alert(error)
                }
                 // axios.get('/admin/edit-page'+slug)
                 //    .then(response=> {
                 //        this.slug = response.data.slug;
                 //        this.contenu = response.data.content;
                 //        alert(this.slug)
                 //    });

            },

            updatePage :async function (slug){

                 try{
                    var theForm = new FormData()
                    theForm.append('slug',this.slug)
                    theForm.append('title',this.titlePage)
                    theForm.append('content',this.contenu)
                    theForm.append('tag',this.tagPage)

                    let response = await axios.post('/admin/update-page',theForm,
                        {
                            _token : this._token,
                            slug : slug
                        }) 
                if (response) {
                    console.log(response.data);
                    alert("Success!")
                }

                }catch(error){
                    alert(error)
                }

            },

            WaveOutPage : async function(slug){
                    
                    // alert('voila le slug '+ slug);
                    try{
                        let response = await axios.post('/admin/delete-page', 
                        {
                            _token : this._token,
                            slug : slug
                        })
                        if(response){
                            alert('Supprimer definivement');
                            console.log(response.data)
                        }
                    }
                    catch(error){
                        alert(error)
                    }

            },

            addPage : async function () {
                try {
                    this.isLoading = true
                    this.pageFormData._token = this.myToken
                    let response = await axios.post('/admin/page/add',this.pageFormData)
                    if(response.data == 'done') {
                        this.isLoading = false
                        alert("Success !")
                        location.reload()
                    }
                } catch(error) {
                    this.isLoading = false
                    this.errorState = true
                    if(error.response.data) {
                        this.errors = error.response.data.errors
                    }
                    else {
                        this.errors = error
                    }
                    setTimeout(() => {
                        this.errorState = false
                    },5000)
                    
                }
            }
        },
        computed : {
            myToken() {
                return this.$store.state.myToken
            }
        }
    }
</script>