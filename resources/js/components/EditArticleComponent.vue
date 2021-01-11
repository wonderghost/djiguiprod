<template>
    <div class="container row">
    <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        background-color="#FFF"
        opacity="1"
        color="blue"></loading>

        <div class="col s12">
           <!--  <ul class="tabs">
                <li class="tab col s3"><a class="active" href="#test1">Nouvel Article</a></li>
                <li class="tab col s3"><a class="" href="#test2">Nouvel Sous categorie</a></li>
                <li class="tab col s3"><a class="" href="#test3">Nouvel Categorie</a></li>
                <li class="tab col s3"><a class="" href="#test4">Tous les articles</a></li>
            </ul> -->
            </div>
            <div id="test1" class="col m12 s12">
                <!-- AJOUTER UN ARTICLE / UNE CATEGORIE D'ARTICLE / SOUS CATEGORIE -->
                <h5>Editer cet article</h5>
                <div class="row">
                    <form @submit.prevent="addArticle()" class="col s12 m12 my-form">
                        <div class="container row">
                            <div class="input-field col s12 m12">
                                <input v-model="articleForm.name" placeholder="Nom de l'article" type="text" class="validate">
                                <label for="first_name">Nom de l'article</label>
                            </div>
                            <div class="input-field col ">
                                <input type="file"  @change="fileUpload">
                            </div>
                            <div class="col s12 m12">
                                <label for="">Contenu</label>
                                <VueEditor v-model="articleForm.content" class="validate"></VueEditor>
                            </div>
                            <div class="col s12 m12">
                                <dropdown :options="subCategory" :selected="artObject" v-on:updateOption="runOnSelect"></dropdown>
                            </div>
                        </div>
                        <button type="submit" class="btn">Validez</button>
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
import { VueEditor } from 'vue2-editor'
import dropdown from 'vue-dropdowns';


    export default {
        // recuperer articles props
        props: [ 'articles' ],

        components : {
            VueEditor,
            Loading,
            dropdown
        },


        mounted() {
            $('.tabs').tabs();
            $('select.sub').formSelect();
            this.getCategoryList()
        },
        data() {
            return {
                isLoading : false,
                fullPage : true,
                articles: {},
                categoryForm : {
                    _token : document.querySelector("meta[name='csrf-token']").content,
                    name : ""
                },
                subCategoryForm : {
                    _token : document.querySelector("meta[name='csrf-token']").content,
                    name : "",
                    cat : ""
                },
                articleForm:  {
                    _token : document.querySelector("meta[name='csrf-token']").content,
                    name : "",
                    content : "",
                    image : "",
                    tag: "",
                },
                category : [],
                subCategory : [],
                object: {
                    name: 'Categorie',
                },
                artObject : {
                    name : "Tag"
                }
            }
        },
        // created() {

        //     axios.get('http://localhost:8000/news/articles/add')
        //         .then(response => console.log(response.data));

        // },
        methods : {
            fileUpload : function (e) {
                this.articleForm.image = e.target.files[0]
            },
            addArticle : async function () {
                try {
                    this.isLoading = true
                    var theForm = new FormData()
                    theForm.append('name',this.articleForm.name)
                    theForm.append('content',this.articleForm.content)
                    theForm.append('image',this.articleForm.image)
                    theForm.append('tag',this.articleForm.tag)

                    let response = await axios.post('/news/articles/add',theForm,{
                        headers : {
                            'content-type'  : 'multipart/form-data'
                        }
                    })
                    if(response.data == 'done') {
                        this.isLoading = false
                        alert("Success!")
                        location.reload()
                    }
                } catch(error) {
                    this.isLoading = false
                    alert(error)
                }
            },
             methodToRunOnSelect(payload) {
                this.object = payload;
                this.subCategoryForm.cat = this.object.slug
            },
            runOnSelect(payload) {
                this.artObject = payload
                this.articleForm.tag = this.artObject.slug
            },
            getCategoryList : async function () {
                try {
                    let response = await axios.get('/news/articles/get-category')
                    this.category = response.data.category,
                    this.subCategory = response.data.sub_category
                } catch(error) {
                    alert(error)
                }
            },
            addCategory : async function () {
                try {
                    this.isLoading = true
                    let response = await axios.post('/news/articles/add-category',this.categoryForm)
                    if(response.data == 'done') {
                        this.isLoading = false
                        alert("Categorie ajoute !")
                        location.reload()
                    }
                } catch(error) {
                    this.isLoading = false
                    alert(error)
                }
            },
            addSubCategory : async function () {
                try {
                    this.isLoading = true
                    let response = await axios.post('/news/articles/add-sub-category',this.subCategoryForm)
                    if(response.data == 'done') {
                        this.isLoading = false
                        alert("Success!")
                        location.reload()
                    }
                } catch(error) {
                    this.isLoading = false
                    alert(error)
                }
            }
        },
        computed : {

        }
    }
</script>
