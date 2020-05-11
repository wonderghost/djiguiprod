<template>
    <div class="news-block-center">
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>

        <div class="row">
            <div class="col m12 s12">
                <!-- <h3>Publicites</h3> -->
            </div>
            <div class="col m12 s12">
                <div class="container">
                    <!-- ARTICLE CONTENT -->
                    <h2>{{news.name}}</h2>
                    <div>
                        <i class="material-icons" style="float : left">account_circle</i> <i>{{news.author}}</i> |
                        <i>{{news.created_at}}</i>
                    </div>
                    <div style="margin:1%">
                        <div class="fb-like" :data-href="url" data-width="" data-layout="button_count" data-action="like" data-size="large" data-share="true"></div>
                    </div>
                    <img :src="'/news-image/'+news.image" style="width:100%;height:800px" alt="">
                    <p style="font-size : 20px " v-html="news.description"></p>
                    <div class="fb-comments" :data-href="url" data-numposts="5" data-width="1000"></div>
                    <!-- // -->
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
        props : {
            details : String,
            url : String
        },
        components : {
            Loading
        },
        mounted() {
            this.getDetails()
        },
        data () {
            return {
                news : {},
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
                    this.isLoading = false
                } catch(error) {
                    alert(error)
                }
            }
        },
        computed : {

        }
    }
</script>
