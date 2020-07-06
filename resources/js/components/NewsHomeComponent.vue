<template>
    <div class="news-block-center">
         <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>
    
    <div class="h-20" style="border : solid 1px #e2e8f0">
        <i>PUBLICITE</i>
    </div>
    
    <div class="" style="border-bottom : solid 1px #e2e8f0">
        <!-- <div class="bg-blue-600 w-32 p-1 mt-1 text-white rounded-sm"><span>Infos a la une</span></div> -->
        <vue-horizontal-list :items="breaking" :options="options" class="p-0">
            <template v-slot:default="{item}">
            <div class="p-0">
                <a :href="'/news/'+item.slug" class="hover:text-blue-800 font-serif">
                    <h6>{{item.name.substring(0,100)}}</h6>
                </a>
            </div>
            </template>
      </vue-horizontal-list>
    </div>

    <div class="grid grid-cols-2 gap-3 divide-x divider-gray-400">
        <div>
            <div class="h-20 mb-2" style="border-bottom : solid 1px #e2e8f0">
                <i>PUBLICITE</i>
            </div>
            <!-- BANNIERE -->
            <vue-flux
            :images="vfImages"
            :transitions="fluxTransitions"
            :captions="vfCaptions"
            :options="fluxOptions">
                <template v-slot:caption>
                    <flux-caption v-slot="caption" class="bg-black bg-opacity-75">
                        <p class="text-white p-2 text-xl font-serif">{{caption.caption}}</p>
                    </flux-caption>
                </template>
            </vue-flux>
            <!-- // -->
            <div class="h-48 mt-3 mb-3" style="border : solid 1px #e2e8f0">
                <i>PUBLICITE</i>
            </div>
        </div>
        <!--  -->
        <div class="p-2">
            <div class="grid grid-cols-2 divide-x divide-gray-400 p-2">
                <div>
                    <h2 class="font-bold font-serif text-3xl" v-html="lastNews.name"></h2>
                    <img :src="'/news-image/'+lastNews.image" class="h-48 pr-2 w-full" alt="">
                    <p v-html="lastNews.description.substring(0,700)+'...'" class="mb-2 font-serif pr-2"></p>
                    <a :href="'/news/'+lastNews.slug" class="bg-blue-600 text-white rounded p-1 hover:bg-blue-700">Lire plus</a>
                </div>
                <div class="grid grid-cols-1 divide-y divide-gray-400 p-1">
                    <div class="grid grid-cols-2 gap-3 p-1" v-for="n in newsData.slice(0,5)" :key="n.slug">
                        <div>
                            <a :href="'/news/'+n.slug" class="hover:text-blue-800 font-serif">
                                <p v-html="n.name.substring(0,100)"></p>
                                <p v-html="n.description.substring(0,100)"></p>
                            </a>
                        </div>
                        <div>
                            <a :href="'/news/'+n.slug">
                                <img :src="'/news-image/'+n.image" class="h-20 w-full rounded">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cultures -->
    <div class="container mx-auto " style="border-top:solid 1px #e2e8f0">
        <div class="bg-blue-600 w-20 text-white font-serif p-1"><span>Cultures</span></div>
        <div class="grid grid-cols-3">
            <div class="col-span-2">
                <a :href="'/news/'+lastCulturesNews.slug">
                    <img :src="'/news-image/'+lastCulturesNews.image" class="w-full p-2" style="height : 25rem !important;" alt="">
                    <h6 class="font-serif font-bold text-2xl text-center p-2">{{lastCulturesNews.name}}</h6>
                </a>
            </div>
            <div class="col-span-1 mt-2">
                <div class="grid grid-rows-2 grid-flow-col gap-1">
                    <div v-for="n in cultures.slice(0,4)" :key="n.slug">
                        <a :href="'/news/'+n.slug" class="">
                            <img :src="'/news-image/'+n.image" class="w-full h-20 rounded" alt="">
                            <h6 class="font-serif hover:text-blue-600">{{n.name}}</h6>
                            <i>
                                <p class="font-serif text-sm" v-html="n.description.substring(0,150)"></p>
                            </i>
                            <!-- <span><i></i></span> -->
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- // -->
    <!-- Sports -->
    <div class="container mx-auto" style="border-top:solid 1px #e2e9f0">
       <div class="bg-blue-600 w-20 text-white font-serif p-1"><span>Sports</span></div>
       <div class="grid grid-cols-3">
            <div class="col-span-2">
                <a :href="'/news/'+lastSportsNews.slug">
                    <img :src="'/news-image/'+lastSportsNews.image" class="w-full p-2" style="height : 25rem !important;" alt="">
                    <h6 class="font-serif font-bold text-2xl text-center p-2">{{lastSportsNews.name}}</h6>
                </a>
            </div>
            <div class="col-span-1 mt-2">
                <div class="grid grid-rows-2 grid-flow-col gap-1">
                    <div v-for="n in sports.slice(0,4)" :key="n.slug">
                        <a :href="'/news/'+n.slug" class="">
                            <img :src="'/news-image/'+n.image" class="w-full h-20 rounded" alt="">
                            <h6 class="font-serif hover:text-blue-600">{{n.name}}</h6>
                            <i>
                                <p class="font-serif text-sm" v-html="n.description.substring(0,150)"></p>
                            </i>
                            <!-- <span><i></i></span> -->
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- // -->
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
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
import VueHorizontalList from 'vue-horizontal-list'
import InfiniteSlideBar from 'vue-infinite-slide-bar'
import { VueFlux, Transitions ,FluxCaption} from 'vue-flux';
// import 'vue-flux/dist/vue-flux.css';



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
                breaking: [],
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
            }
        },
        computed : {
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
            lastCulturesNews() {
                return this.cultures[0]
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
