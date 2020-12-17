<template>
<div class="news-block-center" >
         <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>
    <div class="h-20" style="border : solid 1px #e2e8f0">
        <i>PUBLICITE</i>
    </div>
    
    <div class="w-auto" style="border-bottom : solid 1px #e2e8f0">
        <!-- <div class="bg-blue-600 w-32 p-1 mt-1 text-white rounded-sm"><span>Infos a la une</span></div> -->
        <vue-horizontal-list :items="breaking" :options="options" class="p-0">
            <template v-slot:default="{item}">
            <div class="p-0"> 
                <a :href="'/news/'+item.slug" class="hover:text-blue-800 font-serif">
                    <h6>{{item.name.substring(0,50)+'......'}}</h6>
                </a>
            </div>
            </template>
        </vue-horizontal-list>
    </div>
    <!-- Modal Structure -->
            <div id="modal1" class="modal">
                <div class="modal-content">
                  <h5>Recherchez par titre</h5>
                <input type="text" v-model="q" class="input">
                <table>
                    <tbody>
                      <tr  v-for="n in recuperation.slice(0,5)" :key="n.slug">
                        <td>
                            <div>
                                <a :href="'/news/'+n.slug">
                                    <h5 v-html="n.name.substring(0,50)" ></h5>
                                </a>
                                <h6 v-html="n.description.substring(0,70)" ></h6>
                                {{n.author.name}}
                            </div>
                        </td>
                        <td>
                            <a :href="'/news/'+n.slug">
                                <img :src="'/news-image/'+n.image" height="100px;">
                            </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                   </div>
                <div class="modal-footer">
                </div>
              </div>

    <!-- ici commence les cadres principal -->
    <div class="container row" style="width: 100%;">

        <div class="col s12 m8">
          <div class="card">
            <div v-if="lastNews" class="card-image">
             <a :href="'/news/'+lastNews.slug">
              <img :src="'/news-image/'+lastNews.image" style="height: 480px;">
              <span class="card-title" style="font-size: 40px;
              background: linear-gradient(transparent,black); 
              width: 100%;">
                <h6 style="float:right; margin-top: -240px;" class="hide-on-med-and-down" >{{ new Date(lastNews.date) | dateFormat('DD - MMM') }}</h6>
                <h6 style="margin-bottom: -5px;" v-html="lastNews.sub_cat.name"></h6>
                <h4 v-html="lastNews.name" ></h4>
                <h6 class="hide-on-med-and-down">Par {{ lastNews.author.name }} | {{ new Date(lastNews.date) | dateFormat('DD - MMM - YYYY  HH:mm') }}mn </h6>
              </span>
              </a>
            </div>
          </div>
        </div>
        <div class="col s12 m4">
            <div v-for="n in newsData.slice(1,4)" :key="n.slug" >
                <div class="card">
                    <div class="card-image">
                        <a :href="'/news/'+n.slug">
                          <img :src="'/news-image/'+n.image" style="height: 150px;">
                          <span class="card-title" style="padding-bottom: -20px; 
                          background: linear-gradient(transparent,black);
                          width: 100%;">
                        <h6 style="float:right; margin-top: -60px;" class="hide-on-med-and-down">par {{n.author.name}} le {{ new Date(n.date) | dateFormat('DD - MMM') }}</h6>
                        <h6 style="margin-bottom: -10px;" >{{n.sub_cat.name}}</h6>
                        <h5 style="margin-bottom: -10px;">{{n.name.substring(0,25)}}</h5>
                          </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- fin de la carte principale -->
<!-- quelques publicites -->
    <div class="container row">
        <div style="height: 100px;">
          <div class="col s12 m6">
            <p>publicite</p>
          </div>
          <div class="col s12 m6">
            
          </div>
        </div>
    </div>
<!-- fin -->
<!-- conteneur de news -->
    <div class="container row" style="width: 95%;">
        <h5>Derniere News</h5>
        <div v-if="newsData">
          <div v-for="n in newsData.slice(2,lead)" :key="n.slug"  class="col s12 m3">
            <div class="card small">
                <a :href="'/news/'+n.slug">
                  <div class="card-image">
                    <img :src="'/news-image/'+n.image" height="250px;">
                    <span style="background: linear-gradient(transparent,black);
                  width: 500px;" class="card-title" v-html="n.name.substring(0,30)+'....'"></span>
                  </div>
                </a>
              <div class="card-content">
                <h6 class="blue-text text-darken-2" >Publié le {{ new Date(n.date) | dateFormat('DD - MMM - YYYY') }}</h6>
                <p v-html="n.description.substring(0,60)+'....'"></p>
              </div>
            </div>
          </div>
        </div>
         <div class="row">
            <div class="align-center" >
                <a class="btn" @click="leadMore()" >charger plus<i class="material-icons">plus</i></a>
            </div>
          </div>
    </div>
<!-- fin de news -->
<!-- ici commence la liste par category -->
<div  class="container row" style="width: 90%;">
        
      <div class="col s12 m4">
        <h5>Cultures</h5>
        <div class="card">
            <div v-if="lastCulturesNews" >  
              <div class="card-image">
                <a :href="'/news/'+lastCulturesNews.slug">
                    <img :src="'/news-image/'+lastCulturesNews.image" height="200px;">
                    <span class="card-title" style="background: linear-gradient(transparent,black);">
                        <p v-html="lastCulturesNews.name.substring(0,40)+'....'"></p>
                    </span>
                </a>
                </div>
              <div class="card-content">
                <p v-html="lastCulturesNews.description.substring(0,75)+'....'"></p>
              </div>
            </div>    
          <div v-for="n in newsData.slice(0,7)" v-if="n.cat.slug == 'cultures' " class="card-action">
            <a :href="'/news/'+n.slug" class="blue-text text-darken-2">{{ n.name }}</a>
          </div>
        </div>
      </div>
    <div class="col s12 m4">
        <h5>Sports</h5>
        <div class="card">
            <div v-if="lastSportsNews">  
              <div class="card-image">
                <a :href="'/news/'+lastSportsNews.slug">
                    <img :src="'/news-image/'+lastSportsNews.image" height="200px;">
                    <span class="card-title" style="background: linear-gradient(transparent,black);">
                        <p v-html="lastSportsNews.name.substring(0,40)+'....'"></p>
                    </span>
                </a>
              </div>
              <div class="card-content">
                <p v-html="lastSportsNews.description.substring(0,75)+'....'"></p>
              </div>
            </div>    
          <div v-for="n in newsData.slice(0,7)" v-if="n.cat.slug == 'sports' " class="card-action">
            <a :href="'/news/'+n.slug" class="blue-text text-darken-2">{{ n.name }}</a>
          </div>
        </div>
    </div>
    <div class="col s12 m4">
        <h5>Evenementiels</h5>
        <div class="card">
            <div v-if="lastEventNews">
            <a href="">
                <div class="card-image">
                <img :src="'/news-image/'+lastEventNews.image" height="200px;">
                <span class="card-title" style="background: linear-gradient(transparent,black);">
                    <p v-html="lastEventNews.name.substring(0,50)+'....'"></p>
                </span>
              </div>
            </a>  
              <div class="card-content">
                <p v-html="lastEventNews.description.substring(0,75)+'....'"></p>
              </div>
            </div>    
          <div v-for="n in newsData.slice(0,7)" v-if="n.cat.slug == 'evenements' " class="card-action">
            <a :href="'/news/'+n.slug" class="blue-text text-darken-2">{{ n.name }}</a>
          </div>
        </div>
    </div>
</div>

    <!-- PUBLICITE -->
    <div class="h-20" style="border : solid 1px #e2e8f0">
        <i>PUBLICITE</i>
    </div>
    <!-- // -->
</div>    
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
// import dateformat
import VueFilterDateFormat from '@vuejs-community/vue-filter-date-format';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
import VueHorizontalList from 'vue-horizontal-list'
import InfiniteSlideBar from 'vue-infinite-slide-bar'
import {VueFlux, Transitions ,FluxCaption} from 'vue-flux';
// import 'vue-flux/dist/vue-flux.css';
Vue.use(VueFilterDateFormat);


    export default {
        components : {
            InfiniteSlideBar,
            'vue-horizontal-list' : VueHorizontalList,
            'vue-flux' : VueFlux,
            Transitions,
            'flux-caption' : FluxCaption,
            Loading
        },
        mounted() {
            this.getNewsList()
        },
        data() {
            return {
                lead : 10,
                q : '',
                breaking: [],
                Evenementiels: [],
                categirie: [],
                newsData : [],
                fluxOptions: {
                    autoplay: true
                },
                fluxTransitions:[ 'fade', 'book', 'wave' ],
                vfImages: [],
                vfCaptions: [],
                isLoading : false,
                fullPage : true,
                options: {
                    responsive: [
                        {end: 576, size: 1}, 
                        {start: 576, end: 768, size: 2},
                        {start: 768, end: 992, size: 3},
                        {size: 5}
                    ],
                }
            }
        },
        methods : {
            leadMore(){
                return this.lead += 8
            },
            getNewsList : async function () {
                try {
                    this.isLoading = true
                    let response = await axios.get('/news/articles/get-list')
                    if(response.data) {
                        this.isLoading = false
                        this.breaking = response.data.breaking
                        this.newsData = response.data.data
                        for(var i = 0 ; i < this.breaking.length ; i++) {
                            this.vfImages.push('/news-image/'+this.breaking[i].image)
                            this.vfCaptions.push(this.breaking[i].name)
                        }
                    }
                    
                } catch(error) {
                    alert(error)
                }
            },
            getCategorie : async function () {
                try {
                    this.isLoading = true
                    let response = await axios.get('/news/articles/get-category')
                    if(response.data) {
                        this.isLoading = false
                        this.categirie = response.data
                        this.$store.commit('setCategory',response.data)
                    }
                    
                } catch(error) {
                    alert(error)
                }
            }
        },
        computed : {

            recuperation(){
                return this.newsData.filter( (n) => {
                    return n.name.toLowerCase().includes(this.q.toLowerCase());
                } )
            },

            cultures() {
                return this.newsData.filter( (n) => {
                    return n.cat.slug.match("cultures")
                })
            },
            sports() {
                return this.newsData.filter((n) => {
                    return n.cat.slug.match("sports")
                })
            },
            evenementiels() {
                return this.newsData.filter((n) => {
                    return n.cat.slug.match("evenements")
                })
            },
            lastCulturesNews() {
                return this.cultures[0]
            },
            lastEventNews() {
                return this.evenementiels[0]
            },
            lastSportsNews() {
                return this.sports[0]
            },
            lastNews() {
                return this.newsData[0]
            }
        }
    }
</script>
