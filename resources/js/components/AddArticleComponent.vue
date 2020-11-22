<template>
    <div class="container row" style="width: 90%">
    <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>

        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3"><a class="active" href="#test1">Nouvel Article</a></li>
                <li class="tab col s3"><a class="" href="#test2">Sous categorie</a></li>
                <li class="tab col s2"><a class="" href="#test3">Categorie</a></li>
                <li class="tab col s3"><a class="" href="#test4">Tous les articles</a></li>
                <li class="tab col s1"><a class="" href="#test5"><i class="small material-icons">delete_sweep</i></a></li>
            </ul>
        </div>
            <div id="test1" class="col m12 s12">
                <!-- AJOUTER UN ARTICLE / UNE CATEGORIE D'ARTICLE / SOUS CATEGORIE -->
                <h5>Ajouter un article</h5>
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
            <div id="test2" class="col m12 s12">
                <div class="container">
                    <h5>Nouvel sous Categorie</h5>
                    <div class="row">
                        <form @submit.prevent="addSubCategory()" class="col s12 my-form">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <input v-model="subCategoryForm.name" type="text" class="validate">
                                    <label for="">Nom sous categorie</label>
                                </div>
                                 <div class=" col s12 m12">
                                    <dropdown :options="category" :selected="object" v-on:updateOption="methodToRunOnSelect"></dropdown>
                                </div>
                            </div>
                            <button type="submit" class="btn">validez</button>
                        </form>
                    </div>
                </div>
            </div>
            <div id="test3" class="col m12 s12">
                <div class="container">
                    <h5>Nouvel Categorie</h5>
                    <div class="row">
                        <form @submit.prevent="addCategory()" class="col s12 my-form">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <input placeholder="Nom de la Categorie" v-model="categoryForm.name" type="text" class="validate">
                                    <label for="first_name">Nom de la Categorie</label>
                                </div>
                            </div>
                            <button type="submit" class="btn">Validez</button>
                        </form>
                    </div>
                </div>
            </div>


            <!-- article supprime -->
             <div id="test5" class="col m12 s12">
                <h5 class="aligne-center" >Tous les articles supprimés</h5>
                <div>
          <!--      Tableau daffichage des articles supprimes            -->
                  <table class="highlight">
                    <thead>
                      <tr>
                          <th>Numero</th>
                          <th>Libelle</th>
                          <th>Description</th>
                          <th>Image</th>
                          <th>Options</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr  v-for = '(deletee, index) in articleAll.data' 
                        v-if = 'deletee.deleted == true' >
                        <td>{{ index ++ }}</td>
                        <td>{{ deletee.name }}</td>
                        <td>
                           <p v-html="deletee.description.substring(0,150)"></p>
                        </td>
                        <td><img :src="'/news-image/'+deletee.image" 
                            style="height: 100px; width:100px;">
                        </td>
                        <td>
                            <div>
                                 <a class="waves-effect waves-light btn modal-trigger" 
                                 @click="RestoreArticle(deletee.slug)" ><i class="material-icons">loop</i>
                                 </a>

                                 <a class="waves-effect #b71c1c red darken-4 btn" 
                                 @click="DeleteArticle(deletee.slug)" ><i class="material-icons">delete_forever</i></a>
                            </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                <pagination :data="articleAll" @pagination-change-page="getResults"></pagination>

                </div>
            </div>
            <!-- closed -->
            <div id="test4" class="col m12 s12">
                <h5 class="aligne-center" >Tous les articles</h5>
                <div>
          <!--      Tableau daffichage des articles            -->
                  <table class="highlight">
                    <thead>
                      <tr>
                          <th>Numero</th>
                          <th>Libelle</th>
                          <th>Description</th>
                          <th>Image</th>
                          <th>Options</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr v-for = '(article, index) in articleAll.data' 
                          v-if = 'article.deleted == false'>
                        <td>{{ index ++ }}</td>
                        <td>{{ article.name }}</td>
                        <td>
                           <p v-html="article.description.substring(0,150)"></p>
                        </td>
                        <td><img :src="'/news-image/'+article.image" 
                            style="height: 100px; width:100px;">
                        </td>
                        <td>
                         <a class="waves-effect waves-light btn modal-trigger" 
                         @click="EditArticle(article.slug)" href="#modal1"><i class="material-icons">edit</i></a>
                         <a class="waves-effect #b71c1c red darken-4 btn" 
                         @click="WaveOutArticle(article.slug)" ><i class="material-icons">delete_sweep</i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                <pagination :data="articleAll" @pagination-change-page="getResults"></pagination>

            <!-- closed -->

                  <!-- Modal Structure -->
                  <div id="modal1" class="modal">
                    <div class="modal-content">
                      <h4>Editer cet Article</h4>
                      <form @submit.prevent="UpdateArticle" class="col s12 m12 my-form">
                        <div class="container row">
                            <div class="input-field col s12 m12">
                                <input v-model="titleEdit" placeholder="Nom de l'article" type="text" class="validate">
                                <label for="first_name">Nom de l'article</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <input type="file"  @change="fileUpload2">
                            </div>
                            <div class="col s12 m12">
                                <label for="">Contenu</label>
                                <VueEditor v-model="DescEdit" class="validate"></VueEditor>
                            </div>
                            <!-- <div class="col s12 m12">
                                <dropdown :options="category"  :selected="CategorieEdit" 
                                v-on:updateOption="runOnSelect2" ></dropdown>
                            </div> -->
                        </div>
                        <button type="submit" class="modal-close btn">Validez</button>
                    </form>
                    </div>
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
import dropdown from 'vue-dropdowns';
        
        $(document).ready(function(){
            $('.modal').modal();
          });
     
        
    export default {
        components : {
            VueEditor,
            Loading,
            dropdown
        },

        data() {
            return {
                isLoading : false,
                fullPage : true,
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

                articleAll : {},

                slug: '',
                titleEdit: '',
                ImageEdit: '',
                DescEdit: '',
                CategorieEdit: '',

                artObject : {
                    name : "Tag"
                },


            }
        },
        // created() {

        //     axios.get('http://localhost:8000/news/articles/add')
        //         .then(response => console.log(response.data));

        // },
         mounted() {
            $('.tabs').tabs();
            $('select.sub').formSelect();
            this.getCategoryList()
            this.getResults();
        },
        methods : {

            getResults(page = 1) {
            axios.get('/news/all-article?page=' + page)
                .then(response => {
                    console.log(response.data);
                    this.articleAll = response.data;
                });
            },
            fileUpload : function (e) {
                this.articleForm.image = e.target.files[0]
            },
            fileUpload2 : function (event) {
                this.ImageEdit = event.originalTarget.files[0]
            },
            getArticle(slug){
                axios.get('/news/edit-article/' + slug)
                    .then(response=> console.log(response.data))
                    .catch(error=> console.log(error));
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
                        this.getResults();
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
            runOnSelect2(payload) {
                this.artObject = payload
                this.CategorieEdit = this.artObject.slug
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
            },

            // methode qui edite l'article 
            EditArticle(slug){
                axios.get('/news/edit-article'+slug)
                    .then(response=> {
                        this.slug = response.data.slug;
                        this.titleEdit = response.data.name;
                        this.DescEdit = response.data.description;
                        this.ImageEdit = response.data.Image;
                        this.CategorieEdit = response.data.id_sub_category;
                    });
            },

            // methode qui place l'article dans la corbeille
            WaveOutArticle : async function (slug) {

                try {

                    let response = await axios.post('/news/wave-article',{
                        _token : this._token,
                        slug : slug
                    })

                    if(response) {
                        alert('Placé a la corbeille avec Succè');
                        this.getResults();
                        console.log(response.data)
                    }}
                    catch(error){
                        alert(error)
                    }
            },

            DeleteArticle :async function(slug){

                if (confirm('Voulez-vous Vraiment supprimer cette article definivement')) {  
                    try{

                        let response = await axios.post('/news/delete-article', 
                        {
                            _token : this._token,
                            slug : slug
                        })
                        if(response){
                            alert('Supprimer avec succes');
                            this.getResults();
                            console.log(response.data)
                        }
                    }
                    catch(error){
                        alert(error)
                    }
                }else{
                    console.log('suppression annule')
                }

            },

            RestoreArticle :async function(slug){

                    try{
                        let response = await axios.post('/news/restore-article', 
                        {
                            _token : this._token,
                            slug : slug
                        })
                        if (response) {
                            alert('Restauré avec succes')
                            this.getResults();
                            console.log(response.data);
                        }
                    }
                    catch(error){
                        alert(error)
                    }

            },

            // methode qui place l'article dans la corbeille
            UpdateArticle :async function  (){
                try{
                    var theForm = new FormData()
                    theForm.append('slug',this.slug)
                    theForm.append('title',this.titleEdit)
                    theForm.append('image',this.ImageEdit)
                    theForm.append('description',this.DescEdit)

                    let response = await axios.post('/news/update-article',theForm,
                    {
                        headers : {
                        'content-type' : 'multipart/form-data'
                    }
                }) 
                if (response) {
                    console.log(response.data);
                    this.getResults();
                    alert("Success!")
                }

                }catch(error){
                    alert(error)
                }
                
        }
    },
        computed : {
            _token() {
                return this.$store.state._token
            }
        }
    }
</script>
