<template>
    <div class="news-block-center">
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>
        <div class="">
            <div class="row">
                <div class="col s12 m12">
                    <h3>{{categoryName}}</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m8">
                <img :src="'/news-image/'+data[data.length-1].image" style="width:100%;height:500px">
                <h5 style="text-align : center">
                   <a href="#" class="news-link black-text">{{data[data.length-1].name}}</a>
                </h5>
                <p style="text-align : center">
                    par <i style="font-weight : bold"> {{data[data.length-1].author}}</i>,
                    <i>{{data[data.length-1].created_at}}</i>
                </p>
            </div>
        </div>
        <div class="row">
            <div v-for="n in subCatgoryList" :key="n.slug" class="col s12 m5">
                <div class="col s12">
                        <div class="cat-title">
                            <h5><a class="white-text">{{n.name}}</a></h5>
                        </div>
                    </div>
                    
                    <div v-for="i in getData(n.slug)" :key="i.slug" class="col s12 m6">
                        <a class="black-text news-link" :href="'/news/'+i.slug">
                            <div class="card white" style="box-shadow : none !important; margin : 2% !important;margin-bottom : 0 !important;">
                                <div class="card-content" style="padding : 0px !important;">
                                    <img :src="'/news-image/'+i.image" style="width : 40% ;height:70px; float : left !important;margin-right : 2% !important;" alt="">
                                    <div style="padding : 1% !important">
                                        <span class="" style="margin-left: 0.5 !important;font-weight:bold">
                                            {{i.name.substring(0,50)}} ...
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            </div>
            <div class="col s12 m2">

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
                data : []
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

                    this.subCatgoryList = response.data.sub_category
                    this.data = response.data.data

                    this.isLoading = false

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
            
        }
    }
</script>
