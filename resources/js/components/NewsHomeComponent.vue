<template>
    <div class="news-block-center">
         <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>
        
        <div class="row">
            <div class="col m6" >
                <!-- PUBLICITE -->
            </div>
            <div class="col m6">
                <!-- PUBLICITE -->
            </div>
            <div class="col s12 m12">
                <div class="breaking-news">
                    <span>A la une</span>
                    <vue-horizontal-list :items="breaking" :options="{responsive: [{end: 576, size: 1}, {start: 576, end: 768, size: 2},{size: 4}]}">
                    <template v-slot:default="{item}">
                        <div class="item">
                            <a :href="'/news/'+item.slug" class="black-text news-link">
                                <h5>{{item.name.substring(0,100)}}</h5>
                                <!-- <p v-html="(item.description)"></p> -->
                            </a>
                        </div>
                    </template>
                    </vue-horizontal-list>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6">
                <!-- BANNIERE -->
                    <vue-flux
                        :options="fluxOptions"
                        :images="vfImages"
                        :transitions="fluxTransitions"
                        :captions="vfCaptions"
                        ref="slider">

                        <template v-slot:caption>
                            <flux-caption v-slot="captionProps">
                                <a :href="captionProps.caption.url" target="_blank" class="flux-caption">
                                    <h3>{{ captionProps.text }}</h3>
                                </a>
                            </flux-caption>
                        </template>

                    </vue-flux>
                <!-- // -->
            </div>
            <div class="col m6 s12">
                <div class="row" >
                    <div v-for="i in breaking.slice(0,8)" :key="i.slug" class="col m6">
                        <div class="card horizontal" style="height : 100px !important;margin:0.5% !important">
                            <div class="card-image">
                                <img :src="'/news-image/'+i.image" class="img-news">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                    <p class="text-paragraphe"><a :href="'/news/'+i.slug" class="black-text news-link">{{i.name.substring(0,100)}}...</a></p>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>  
        <!-- ARTICLES -->
        <div class="row">
            <div class="col s12 m10">
                <div class="row">
                    <div class="col s12">
                        <div class="cat-title">
                            <h5><a class="white-text">Cultures</a></h5>
                        </div>
                    </div>
                    
                    <div v-for="i in cultures.slice(0,12)" :key="i.slug" class="col s12 m3">
                        <a class="black-text news-link" :href="'/news/'+i.slug">
                            <div class="card white" style="box-shadow : none !important; margin : 2% !important;margin-bottom : 0 !important;">
                                <div class="card-content" style="padding : 0px !important;">
                                    <img :src="'/news-image/'+i.image" style="width : 40% ;height:70px; float : left !important;margin-right : 2% !important;" alt="">
                                    <div style="padding : 1% !important">
                                        <span class="" style="margin-left: 0.5 !important;font-weight:bold">
                                            {{i.name.substring(0,50)}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col s12 m2">
                <div class="fb-page" data-href="https://www.facebook.com/Djigui-Prod-362798861143645" data-tabs="" data-width="" data-height="" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Djigui-Prod-362798861143645" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Djigui-Prod-362798861143645">Djigui Prod</a></blockquote></div>
            </div>
        </div>
        <!-- // -->
        <!-- SPORTS -->
        <div class="row">
            <div class="col s12 m10">
                <div class="row">
                    <div class="col s12 m12">
                        <div class="cat-title">
                            <h5><a class="white-text darken-2" href="#">Sports</a></h5>
                        </div>
                    </div>
                    
                    <div v-for="i in sports.slice(0,12)" :key="i.slug" class="col m3">
                        <a class="black-text news-link" :href="'/news/'+i.slug">
                            <div class="card white" style="box-shadow : none !important">
                                <div class="card-content" style="padding : 0px !important;">
                                    <img :src="'/news-image/'+i.image" style="height:200px;width : 100%;" alt="">
                                    <div style="padding : 1% !important">
                                        <span class="">
                                            {{i.name}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col m2">
                <!-- publicite -->
            </div>
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
            VueHorizontalList,
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
                fluxTransitions:[ 'fade', 'cube', 'book', 'wave' ],
                vfImages: [],
                vfCaptions: [],
                isLoading : false,
                fullPage : true
            }
        },
        methods : {
            getNewsList : async function () {
                try {
                    this.isLoading = true
                    let response = await axios.get('/news/articles/get-list')
                    this.breaking = response.data.breaking
                    this.newsData = response.data.data
                    for(var i = 0 ; i < this.breaking.length ; i++) {
                        this.vfImages.push('/news-image/'+this.breaking[i].image)
                        this.vfCaptions.push(this.breaking[i].name)
                    }
                    this.isLoading = false
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
            }
        }
    }
</script>
