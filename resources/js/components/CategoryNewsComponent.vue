<template>
    <div class="news-block-center">
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>
        <!-- BREADCRUMB -->
        <nav class="bg-grey-light p-3 rounded font-sans w-full m-4">
            <ol class="list-reset flex text-grey-dark">
                <li><a href="/news" class="text-blue font-bold"><i class="material-icons">home</i></a></li>
                <li><span class="mx-2">/</span></li>
                <li>{{categoryName}}</li>
            </ol>
        </nav>

        <div v-if="nothingState" class="h-20 bg-blue-800 text-white">
            <p class="text-center text-xl">Aucune donnee pour le moment !</p>
        </div>

        <div class="h-20" style="border : solid 1px #e2e8f0">
            <i>PUBLICITE</i>
        </div>

        <div v-if="!nothingState" class="container mx-auto">
            <div class="mt-5">
                <span class="font-serif text-4xl mr-10">{{categoryName}} : </span>
                <span class="text-2xl mr-2 pr-2" style="border-right : solid 1px #e2e8f0" v-for="sc in subCatgoryList" :key="sc.slug">{{ sc.name }}</span>
            </div>
            <div class="grid grid-cols-2 gap-3 divide-x divider-gray-400">
                <div>
                    <div class="h-20 mb-2" style="border-bottom : solid 1px #e2e8f0">
                        <i>PUBLICITE</i>
                    </div>
                    <div>
                        <a :href="'/news/'+lastNews.slug">
                            <img :src="'/news-image/'+lastNews.image" class="w-full p-2" style="height : 25rem !important;" alt="">
                            <h6 class="font-serif font-bold text-2xl text-center p-2">{{lastNews.name}}</h6>
                        </a>
                    </div>
                    <div class="h-48 mt-3 mb-3" style="border : solid 1px #e2e8f0">
                        <i>PUBLICITE</i>
                    </div>
                </div>
                <!--  -->
                <div class="p-2">
                    <div class="grid grid-cols-2 divide-x divide-gray-400 p-2">
                        <div>
                            <h2 class="font-bold font-serif text-3xl" v-html="secondLastNews.name"></h2>
                            <img :src="'/news-image/'+secondLastNews.image" class="h-48 pr-2 w-full" alt="">
                            <p v-html="secondLastNews.description.substring(0,300)+'...'" class="mb-2 font-serif pr-2"></p>
                            <a :href="'/news/'+secondLastNews.slug" class="bg-blue-600 text-white rounded p-1 hover:bg-blue-700">Lire plus</a>
                        </div>
                        <div class="grid grid-cols-1 divide-y divide-gray-400">
                            <div class="grid grid-cols-2 gap-1 p-1" v-for="n in data.slice(2,5)" :key="n.slug">
                                <div>
                                    <a :href="'/news/'+n.slug" class="hover:text-blue-800 font-serif">
                                        <p v-html="n.name"></p>
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
                        <div class="grid grid-cols-1"></div>
                    </div>
                </div>
            </div>
            <!-- // -->

        </div>
        <div v-if="!nothingState" class="container mx-auto">
            <div v-for="s in subCatgoryList" :key="s.slug" style="border-top : solid 1px #e2e8f0" class="mt-1 mb-4">
                <div class="bg-blue-600 w-32 text-white font-serif p-1 rounded" style="border-top : solid 1px #e2e8f0"><span>{{s.name}}</span></div>
                <div class="grid grid-cols-5 gap-3 mt-2">
                    <div v-for="n in getData(s.slug).slice(0,15)" :key="n.slug">
                        <a :href="'/news/'+n.slug" class="hover:text-blue-600">
                            <img :src="'/news-image/'+n.image" class="w-full h-32 rounded" alt="">
                            <p class="font-serif text-xl">{{n.name.substring(0,100)}}...</p>
                        </a>
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
                isLoading : false,
                fullPage : true,
                subCatgoryList : [],
                data : [],
                nothingState : false
            }
        },
        methods : {
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
            }
        }
    }
</script>
