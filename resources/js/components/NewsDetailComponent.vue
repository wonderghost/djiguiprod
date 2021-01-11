<template>
    <div class="news-block-center">
       <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        background-color="#FFF"
        opacity="1"
        color="blue"></loading>

        <!-- nav class="bg-grey-light p-3 rounded font-sans w-full m-4">
            <ol class="list-reset flex text-grey-dark">
                <li><a href="/news" class="text-blue font-bold"><i class="material-icons">home</i></a></li>
                <li><span class="mx-2">/</span></li>
                <li><a :href="'/news/category/'+news.cat.slug" class="text-blue font-bold">{{news.cat.name}}</a></li>
                <li><span class="mx-2">/</span></li>
                <li>{{news.name}}</li>
            </ol>
        </nav> -->

        <div class="h-20" style="border : solid 1px #e2e8f0">
            <i>PUBLICITE</i>
        </div>

        <!-- ici se termine le menu  -->
        <div class="container">
            <h4 class="center-align">{{news.name}}</h4>
        </div>
        
        <div class="container row" style="width: 95%;">
            <div class="col s12 m9">
              <div class="card">
                <div class="card-image">
                  <img :src="'/news-image/'+news.image" style="height: 518px;">
                  <span class="card-title">
                    <h6>Par {{news.author}} | {{news.created_at}}</h6>
                  </span>
                </div>
              </div>
            </div>
            <div class="col m3">
              <h5>Plus populaires</h5>
              <div>
                  <template v-if='othersArticle'>
                      <div v-for="n in othersArticle.slice(0,2)" :key="n.slug" class="card horizontal">
                        <div class="card-image">
                            <img :src="'/news-image/'+n.image" style="height: 200px;">
                        </div>
                        <div class="card-stacked">
                            <div class="card-content">
                            <p v-html="n.name.substring(0,50)+'....'"></p>
                            <h6>{{ new Date(n.date) | dateFormat('DD - MMM') }}</h6> 
                            </div>
                            <div class="card-action">
                            <a :href="'/news/'+n.slug">Voir plus</a>
                            </div>
                        </div>
                        </div>
                  </template>
                
              </div>
            </div>
        </div> 
        <div class="container">
          <div>
                <span class="font-serif text-xl">
                    <h6> Auteur : {{news.author}} le {{news.created_at}}</h6> Partagez : 
                </span>
                    
            <!-- SOCIAL SHARING -->
                    <twitter-share 
                        :page_url="url"
                        has_icon>
                    </twitter-share>
                    <facebook-share
                        :page_url="url"
                        has_icon>    
                    </facebook-share>
            <hr>
            <p v-html="news.name"></p>      
          </div>
          <hr>
          <div>
            <h6>Contenu</h6>
            <p v-html="news.description"></p>      
          </div>
        </div> 
        <!-- fin de fin -->
    </div>    
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
// import dateformat
import VueFilterDateFormat from '@vuejs-community/vue-filter-date-format';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

import VueGoodshareFacebook from "vue-goodshare/src/providers/Facebook.vue";
import VueGoodshareTwitter from "vue-goodshare/src/providers/Twitter.vue";

Vue.use(VueFilterDateFormat);

    export default {
        components : {
            'facebook-share' : VueGoodshareFacebook,
            'twitter-share' : VueGoodshareTwitter,
            Loading
        },
        props : {
            details : String,
            url : String
        },
        mounted() {
            this.getDetails()
        },
        data () {
            return {
                news : {},
                others : [],
                isLoading : false,
                fullPage : true
            }
        },
        methods : {
            getDetails : async function () {
                try {
                    this.isLoading = true
                    let response  = await axios.post('/news/'+this.details+'/get-infos' , {
                        _token : document.querySelector("meta[name='csrf-token']").content,
                        slug : this.details
                    })

                    this.news = response.data

                    response = await axios.get('/news/articles/get-list')
                    if (response.data) {
                        this.others = response.data
                        this.isLoading = false
                        
                    }


                } catch(error) {
                    alert(error)
                }
            }
        },
        computed : {
            othersArticle() {
                if(this.others.data) {
                    return this.others.data.filter((a) => {
                        return a.cat.slug == this.news.cat.slug
                    })
                }
            }
        }
    }
</script>
