<template>
    <div class="news-block-center">
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>

        <nav class="bg-grey-light p-3 rounded font-sans w-full m-4">
            <ol class="list-reset flex text-grey-dark">
                <li><a href="/news" class="text-blue font-bold"><i class="material-icons">home</i></a></li>
                <li><span class="mx-2">/</span></li>
                <li><a :href="'/news/category/'+news.cat.slug" class="text-blue font-bold">{{news.cat.name}}</a></li>
                <li><span class="mx-2">/</span></li>
                <li>{{news.name}}</li>
            </ol>
        </nav>

        <div class="h-20" style="border : solid 1px #e2e8f0">
            <i>PUBLICITE</i>
        </div>
        <div class="container mx-auto">
            <h6 class="font-serif text-5xl">{{news.name}}</h6>
            <span class="text-xl"><i class="material-icons">account_circle</i><i>{{news.author}}</i></span>,
            <!-- SOCIAL SHARING -->
            <span class="font-serif text-xl">Partagez : </span>
                <twitter-share 
                    :page_url="url"
                    has_icon>
                </twitter-share>
                <facebook-share
                    :page_url="url"
                    has_icon></facebook-share>
                <!-- <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="box_count" data-size="small"></div> -->
            
            <!-- // -->

            <div class="grid grid-cols-3 divide-x divider-gray-400 gap-1">
                <div class="col-span-3 pr-5 lg:col-span-2">
                    <img :src="'/news-image/'+news.image" class="h-auto w-full" alt="">
                    <p class="font-serif text-xl mt-5 leading-loose" v-html="news.description"></p>

                    <div class="fb-comments w-full" :data-href="url" data-numposts="5" data-width="100%"></div>

                    <!-- MORE POSTS -->
                    <div class="mt-10" style="border-top: solid 1px #e2e8f0">
                        <div class="bg-blue-600 w-32 text-white font-serif p-1"><span>Plus d'Articles</span></div>

                        <div class="mt-10">
                            <div v-for="a in othersArticle" :key="a.slug" class="grid grid-cols-3 gap-1 p-2" style="border-bottom :solid 1px #e2e8f0">
                                <div class="col-span-2 hover:text-blue-600">
                                    <a :href="'/news/'+a.slug">
                                        <p class="font-serif text-xl" v-html="a.name"></p>
                                        <p class="font-serif" v-html="a.description.substring(0,200)"></p>
                                    </a>
                                </div>
                                <div class="col-span-1">
                                    <a :href="'/news/'+a.slug">
                                        <img :src="'/news-image/'+a.image" class="w-full h-32" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-span-1"></div>
            </div>
        </div>

    </div>    
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

import VueGoodshareFacebook from "vue-goodshare/src/providers/Facebook.vue";
import VueGoodshareTwitter from "vue-goodshare/src/providers/Twitter.vue";

    export default {
        props : {
            details : String,
            url : String
        },
        components : {
            Loading,
            'facebook-share' : VueGoodshareFacebook,
            'twitter-share' : VueGoodshareTwitter
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
                    this.others = response.data

                    this.isLoading = false

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
