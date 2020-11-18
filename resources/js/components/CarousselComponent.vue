<template>
	<div>
		
	   <h4 class="center-align" >Gestion des banniere</h4>
		   <div class="container" style="width: 80%" >
			   <h7 >Ajouter un caroussel</h7>
			   	<div class="row">
			   		<div class="input-field col s5">
				       <input v-model="bannerForm.name" placeholder="Libelle" type="text" class="validate">
				    </div>
				    <div class="input-field col s5" style="margin-top:-5px">
				         <div class="file-field input-field">
					      <div class="btn">
					        <span>File</span>
					        <input type="file" @change="fileUpload">
					      </div>
					      <div class="file-path-wrapper">
					        <input class="file-path validate" type="text">
					      </div>
				      	 </div>
				    </div>
				    <div class="input-field col s2">
				    	<a @click="AddCaroussel()" class="waves-effect waves-light btn">Valider <i class="material-icons left">send</i></a>
				    </div>
			    </div>
			    <div class="row">
			    	<div>
          <!--      Tableau daffichage des banniere            -->
          		  <h7 class="center-align">Liste des Caroussels</h7>
                  <table class="highlight">
                    <thead>
                      <tr>
                          <th>numero</th>
                          <th>Libelle</th>
                          <th>Image</th>
                          <th>Etat</th>
                          <th>Options</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr  v-for = '(banner,index) in banners.data' :key='banner.slug'>
                        <td>{{ index+1 }}</td>
                        <td>{{ banner.name }}</td>
                        <td><img :src="'/news-image/'+banner.image" 
                            style="height: 100px; width:150px;">
                        </td>
                        <td v-if='banner.state == 0'>
                        	<a class="waves-effect #b71c1c red darken-4 btn modal-trigger" 
                             @click="ActiveBanner(banner.slug)" >Activer
                             </a>
                        </td>
                        <td v-else>
                        	<a class="waves-effect waves-light btn modal-trigger" 
                             @click="blockBanner(banner.slug)" >Blocker
                             </a>
                        </td>
                        <td>
                            <div>
                             <a class="waves-effect waves-light btn modal-trigger" 
                             @click="(banner.slug)" ><i class="material-icons">edit</i>
                             </a>

                             <a class="waves-effect #b71c1c red darken-4 btn" 
                             @click="DeleteArticle(banner.slug)" ><i class="material-icons">delete_forever</i></a>
                            </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <pagination :data="banners" @pagination-change-page="getResults"></pagination>
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
import VueHorizontalList from 'vue-horizontal-list'
import InfiniteSlideBar from 'vue-infinite-slide-bar'
import { VueFlux, Transitions ,FluxCaption} from 'vue-flux';
// import 'vue-flux/dist/vue-flux.css';



    export default {
    	data() {
    		return {
    			isLoading : false,
                fullPage : true,

                banners: {},

                bannerForm:  {
                    _token : document.querySelector("meta[name='csrf-token']").content,
                    slug : "",
                    name : "",
                    image : ""
                }
    		}
    	},

    	mounted() {
			// Fetch initial results
			this.getResults();
		},
    	methods : {
    		getResults(page = 1) {
			axios.get('/admin/allBanner?page=' + page)
				.then(response => {
					console.log(response.data);
					this.banners = response.data;
				});
			},

    		fileUpload : function (e) {
                this.bannerForm.image = e.target.files[0]
            },

            ActiveBanner :async function(slug){

                    try{
                        let response = await axios.post('/admin/active-banner', 
                        {
                            _token : this._token,
                            slug : slug
                        })
                        if (response) {
                            alert('Active avec succes')
                            this.getResults();
                            console.log(response.data);
                        }
                    }
                    catch(error){
                        alert(error)
                    }

            },

            blockBanner :async function(slug){

                    try{
                        let response = await axios.post('/admin/block-banner', 
                        {
                            _token : this._token,
                            slug : slug
                        })
                        if (response) {
                            alert('Blocké avec succes')
                            this.getResults();
                            console.log(response.data);
                        }
                    }
                    catch(error){
                        alert(error)
                    }

            },

    		AddCaroussel : async function () {

    			try {
                    // this.isLoading = true
                    var theForm = new FormData()
                    theForm.append('name',this.bannerForm.name)
                    theForm.append('image',this.bannerForm.image)

                    let response = await axios.post('/admin/save-caroussel',theForm,{
                        headers : {
                            'content-type'  : 'multipart/form-data'
                        }
                    })
                    if(response.data == 'done') {
                        // this.isLoading = false
                        alert("Success!")
                        location.reload()
                    }
                } catch(error) {
                    // this.isLoading = false
                    alert(error)
                }
            }
    	}
        
    }
</script>
