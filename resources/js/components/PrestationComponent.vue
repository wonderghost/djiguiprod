<template>
    <div>
       <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        background-color="#FFF"
        opacity="1"
        color="blue"></loading>

        <template v-if="type == 'main'">
            <div class="container">
                <nav class="bread">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="/" class="breadcrumb"><i class="material-icons">home</i></a>
                            <a href="#!" class="breadcrumb">Prestations</a>
                            <!-- <a href="#!" class="breadcrumb">Third</a> -->
                        </div>
                    </div>
                </nav>
            </div>
            <!-- PARALLAXE -->
            <div id="index-banner" class="parallax-container">
                <div class="section no-pad-bot">
                    <div class="container">
                        <h1 class="header center white-text">Nos Prestations</h1>
                    </div>
                </div>
                <div class="parallax"><img src="/img/slide-1.jpg" alt="Unsplashed background img 1"></div>
            </div>
            <!-- // -->
            <!-- LIST SERVICES -->
            <div class="news-block-center">
                <div class="row">
                    <div v-for="i in prestationList" :key="i.slug" class="col s4">
                        <div class="card-panel grey lighten-5">
                            <h5 class="">{{i.title}}</h5>
                            <p class="" v-html="i.content.substring(0,100)"></p>
                            <a :href="'/prestations/'+i.slug" class="btn waves-effect waves-light light-blue darken-4">En savoir plus</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // -->
        </template>
        <template v-else>
            <div class="container">
                <nav class="bread">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="/" class="breadcrumb"><i class="material-icons">home</i></a>
                            <a href="/prestations" class="breadcrumb">Prestations</a>
                            <a href="#!" class="breadcrumb">{{details.title}}</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="index-banner" class="parallax-container">
                <div class="section no-pad-bot">
                    <div class="container">
                        <h1 class="header center white-text">{{details.title}}</h1>
                    </div>
                </div>
                <div class="parallax"><img src="/img/slide-1.jpg" alt="Unsplashed background img 1"></div>
            </div>
            <div class="container">
                <p v-html="details.content"></p>
            </div>
        </template>
    </div>    
</template>
<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        props: {
            type : String
        },
        components : {
            Loading
        },
        mounted() {
            $('.parallax').parallax();
            // 

            if(this.type == 'main') {

                this.getPrestationList()
            }
            else {

                this.getPrestationDetails()
            }

        },
        data() {
            return {
                isLoading : false,
                fullPage : true,
                services : [],
                details : {}
            }
        },
        methods : {
            getPrestationList : async function () {
                try {
                    this.isLoading = true
                    let response = await axios.get('/get-prestation')
                    this.services = response.data
                    this.isLoading = false
                } catch(error) {
                    alert(error)
                }
            },
            getPrestationDetails : async function () {
                try{
                    this.isLoading = true
                    let response = await axios.post('/prestations/get-prestation-details',{
                        _token : this.myToken,
                        slug : this.type
                    })

                    this.details = response.data
                    this.isLoading = false

                } catch(error) {
                    alert(error)
                }
            }
        }, 
        computed : {
            prestationList() {
                return this.services.filter((s) => {
                    return s.tag == 'prestation'
                })
            },
            myToken() {
                return this.$store.state.myToken
            }
        }
    }
</script>
