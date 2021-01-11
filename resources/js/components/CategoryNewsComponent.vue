<template>
    <div class="news-block-center">
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        background-color="#FFF"
        opacity="1"
        color="blue"></loading>
        <!-- BREADCRUMB -->
       <!--  <nav class="bg-grey-light p-3 rounded font-sans w-full m-4">
            <ol class="list-reset flex text-grey-dark">
                <li><a href="/news" class="text-blue font-bold"><i class="material-icons">home</i></a></li>
                <li><span class="mx-2">/</span></li>
                <li>{{categoryName}}</li>
            </ol>
        </nav> -->

        <!-- Modal Structure -->
            <div id="modal1" class="modal">
                <div class="modal-content">
                  <h5>Recherchez par titre</h5>
                <input placeholder="Veuiller entrer le mot dans cette zone" type="text" v-model="q" class="input">
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

        <div v-if="nothingState" class="h-20 bg-blue-800 text-white">
            <p class="text-center text-xl">Aucune donnee pour le moment !</p>
        </div>

        <div class="h-20" style="border : solid 1px #e2e8f0">
            <i>PUBLICITE</i>
        </div>

        <div v-if="!nothingState" class="container">
            <div v-if="subCatgoryList" >
                <div class="col s12">
                  <ul class="tabs" >
                    <li class="tab col s3" v-for="sc in subCatgoryList" :key="sc.slug">
                        <a :href="'/news/'+sc.slug"><h6>{{ sc.name }}</h6></a>
                    </li>
                  </ul>
                </div>
                <!-- <span class="font-serif text-4xl mr-10">{{categoryName}} : </span>
                <span class="text-2xl mr-2 pr-2" style="border-right : solid 1px #e2e8f0" v-for="sc in subCatgoryList" :key="sc.slug">{{ sc.name }}</span> -->
            </div>
            <div class="row">
                <div>
                    <div style="border-bottom : solid 1px #e2e8f0">
                        <i>PUBLICITE</i>
                    </div>
                    <h4 class="center-align" >{{categoryName}}</h4>
                    <div v-if="lastNews">
                        <div class="col s12 m10">
                          <div class="card">
                            <div class="card-image">
                            <a :href="'/news/'+lastNews.slug">
                              <img :src="'/news-image/'+lastNews.image" height="450px;">
                              <span class="card-title" style="font-size: 40px;
                               background: linear-gradient(transparent,black); 
                                width: 100%;">
                                <span >
                                <h5 v-html="lastNews.name.substring(0,150)" ></h5>
                                </span>
                                <h6>by {{lastNews.author}} | {{ lastNews.created_at }} </h6>
                              </span>
                            </a>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m10" >   
            <div class="row">
            <div v-if="secondLastNews">
                <div class="col s12 m5">
                  <div class="card">
                    <div class="card-image">
                    <a :href="'/news/'+secondLastNews.slug">
                      <img :src="'/news-image/'+secondLastNews.image" height="250px;">
                      <span class="card-title" style="font-size: 40px;
                        background: linear-gradient(transparent,black); width: 100%;">
                        <h5  v-html="secondLastNews.name.substring(0,40)"></h5>
                        <h6>{{ secondLastNews.created_at}}</h6>
                      </span>
                    </a>
                    </div>
                  </div>
                </div>
             </div>
             <div v-if="thirdLastNews">   
                <div class="col s12 m5">
                  <div class="card">
                    <div class="card-image">
                    <a :href="'/news/'+thirdLastNews.slug">
                      <img :src="'/news-image/'+thirdLastNews.image" height="250px;">
                      <span class="card-title" style="font-size: 40px;
                        background: linear-gradient(transparent,black); width: 100%;">
                        <h5 v-html="thirdLastNews.name.substring(0,40)"></h5>
                        <h6>{{ thirdLastNews.created_at }}</h6>
                      </span>
                    </a>
                    </div>
                  </div>
                </div>
             </div>
            </div>
            </div>

            <div class="row">
                <hr>
                <table>
                    <tbody v-if="data">
                      <tr  v-for="n in data.slice(3,lead)" :key="n.slug">
                        <td>
                            <div>
                                <a :href="'/news/'+n.slug">
                                    <h5 v-html="n.name.substring(0,50)" ></h5>
                                </a>
                                <h6 v-html="n.description.substring(0,70)" ></h6>
                                {{n.author}} | {{ n.created_at }}
                            </div>
                        </td>
                        <td>
                            <a :href="'/news/'+n.slug">
                                <img :src="'/news-image/'+n.image" height="100px;" width="100px;">
                            </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                    <br>
                    <div class="center-align">   
                        <a  class="btn light-blue darken-2" @click="leadMore()" >voir plus</a>
                    </div>
            </div>

                <!--  -->
                <!-- <div class="p-2">
                    <div class="grid grid-cols-1 divide-x divide-gray-400 p-2 lg:grid-cols-2">
                        <div v-if="secondLastNews" class="mb-5 lg:mb-0">
                            <h2 class="font-bold font-serif text-3xl" v-html="secondLastNews.name"></h2>
                            <img :src="'/news-image/'+secondLastNews.image" class="h-48 pr-2 w-full mb-2 lg:mb-0" alt="">
                            <p v-html="secondLastNews.description.substring(0,300)+'...'" class="mb-2 font-serif pr-2"></p>
                            <a :href="'/news/'+secondLastNews.slug" class="bg-blue-600 text-white rounded p-1 hover:bg-blue-700">Lire plus</a>
                        </div>
                        <div v-if="data" class="grid grid-cols-1 divide-y divide-gray-400">
                            <div class="grid grid-cols-2 gap-1 p-1" v-for="n in data.slice(2,5)" :key="n.slug">
                                <div>
                                    <a :href="'/news/'+n.slug" class="hover:text-blue-800 font-serif">
                                        <p v-html="n.name"></p>
                                        <p v-html="n.description.substring(0,100)"></p>
                                    </a>
                                </div>
                                <div>
                                    <a :href="'/news/'+n.slug">
                                        <img :src="'/news-image/'+n.image" class="h-32 w-full rounded lg:h20">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1"></div>
                    </div>
                </div> -->
            </div>
        </div>
      <!--   <div v-if="!nothingState" class="container mx-auto">
            <div v-for="s in subCatgoryList" :key="s.slug" style="border-top : solid 1px #e2e8f0" class="mt-1 mb-4">
                <div class="bg-blue-600 w-32 text-white font-serif p-1 rounded" style="border-top : solid 1px #e2e8f0"><span>{{s.name}}</span></div>
                <div class="grid grid-cols-2 gap-3 mt-2 lg:grid-cols-5">
                    <div v-for="n in getData(s.slug).slice(0,15)" :key="n.slug">
                        <a :href="'/news/'+n.slug" class="hover:text-blue-600">
                            <img :src="'/news-image/'+n.image" class="w-full h-32 rounded" alt="">
                            <p class="font-serif text-xl">{{n.name.substring(0,100)}}...</p>
                        </a>
                    </div>
                </div>
            </div>

        </div>
         -->
</template>
<script>
// Import component
import Loading from 'vue-loading-overlay';
// import dateformat
import VueFilterDateFormat from '@vuejs-community/vue-filter-date-format';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

Vue.use(VueFilterDateFormat);

    export default {
        components : {
            Loading
        },
        props : {
            categorySlug : String,
            categoryName : String
        },
        mounted() {
            this.getSubCategory()
        },
        data() {
            return {
                lead : 10,
                q : '',
                isLoading : false,
                fullPage : true,
                subCatgoryList : [],
                data : [],
                nothingState : false
            }
        },
        methods : {
            leadMore(){
                return this.lead += 5
            },
            getSubCategory : async function () {
                try {
                    this.isLoading = true
                    
                    let response = await axios.post('/news/category/get-subcategory',{
                        _token : document.querySelector("meta[name='csrf-token']").content,
                        category : this.categorySlug
                    })
                    
                    if(response.data) {

                        this.subCatgoryList = response.data.sub_category
                        this.data = response.data.data

                        this.isLoading = false

                        if(this.data.length == 0) {
                            this.nothingState = true
                        }

                    }
                   


                } catch(error) {
                    this.isLoading = false
                    alert(error)
                }
            },
            getData(slug) {
                return this.data.filter( (n) => {
                    return n.id_sub_category.match(slug)
                })
            }
        },
        computed : {
            recuperation(){
                return this.data.filter( (n) => {
                    return n.name.toLowerCase().includes(this.q.toLowerCase());
                } )
            },
            musics() {
                return this.data.filter((d) => {
                    return d.id_sub_category == 'music'
                })
            },
            lastNews() {
                return this.data[0]
            },
            secondLastNews() {
                return this.data[1]
            },
            thirdLastNews() {
                return this.data[2]
            }
        }
    }
</script>
