<template>
    <div>
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"
        loader="bars"></loading>

         <VueCarousel :data="slides"></VueCarousel>
         <!-- ABOUT US -->
        <div class="container who-we-are">
            <h4>DjiguiProd</h4>
            <p v-for="i in aboutUsPage" :key="i.slug" v-html="i.content.substring(0,300)+'...'"></p>
            <a href="/about-us" class="btn light-blue darken-4 waves-effect waves-light">En savoir plus</a>
        </div>
         <!-- // -->
        <!-- NOS PRESTATIONS -->
        <div id="index-banner" class="parallax-container">
            <div class="section no-pad-bot">
                <div class="container">
                    <h1 class="header white-text">Nos Prestations</h1>
                </div>
            </div>
            <div class="parallax"><img src="/img/slide-1.jpg" alt="Unsplashed background img 1"></div>
        </div>
         <div class="container">
             <!-- <h5>Nos Prestations</h5> -->
             <div class="row">
                 <div v-for="n in prestationList" :key="n.slug" class="col s4">
                     <div class="card-panel grey lighten-5">
                        <h5 class="">{{n.title}}</h5>
                        <p v-html="n.content.substring(0,100)+'...'" class=""></p>
                        <a :href="'/prestations/'+n.slug" class="btn waves-effect waves-light light-blue darken-4">En savoir plus</a>
                    </div>
                 </div>
             </div>
         </div>
         <!-- PARTENAIRES -->
        <!-- <div class="container">
            <h5>Nos Partenaires & Sponsors</h5>
            <div class="row">
                <InfiniteSlideBar>
                    <img v-for="i in partners" :alt="i" :key="i" style="width : 100px ;height : auto ; margin-left : 10%" :src="'/partners/'+i">
                </InfiniteSlideBar>
            </div>
        </div> -->
        <div id="index-banner" class="parallax-container">
            <div class="section no-pad-bot">
                <div class="container">
                    <h4 class="header white-text">Nos Partenaires</h4>
                    <InfiniteSlideBar>
                        <img v-for="i in partners" :alt="i" :key="i" style="width : 100px ;height : auto ; margin-left : 10%" :src="'/partners/'+i">
                    </InfiniteSlideBar>
                </div>
            </div>
            <div class="parallax"><img src="/img/slide-1.jpg" alt="Unsplashed background img 1"></div>
        </div>
         <!-- // -->
         <!-- CONTACT US -->
        <div class="news-block-center">
            <h5>Contactez Nous</h5>
            <div class="row">
                <div class="col s6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15739.979827424939!2d-13.720976772473483!3d9.509166741018598!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xf1cd09165fb2f8f%3A0xced159547560a99!2zS2Fsb3VtLCBHdWluw6ll!5e0!3m2!1sfr!2s!4v1593188754060!5m2!1sfr!2s" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
                <div class="col s6">
                    <contact-form></contact-form>
                </div>
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
import VueCarousel from '@chenfengyuan/vue-carousel';
import InfiniteSlideBar from 'vue-infinite-slide-bar'

    export default {
        components : {
            Loading,
            VueCarousel,
            InfiniteSlideBar
        },
        mounted() {
            $('.parallax').parallax();
            // 
            // this.getAllPage()
        },
        data() {
            return {
                isLoading : false,
                fullPage : true,
                slides : [
                    {   
                        id : 1,
                        message : "hello world",
                        content : "<img src='/img/slide-1.jpg'/>"
                    },
                    {
                        id : 2,
                        message : "",
                        content : "<img src='/img/slide-2.jpg'/>"
                    }
                ],
                services : [],
                partners : ['partner1.jpg','partner2.png','partner3.png','partner4.jpg'],
            }
        },
        methods : {
            getAllPage : async function () {
                try {
                    this.isLoading = true
                    let response = await axios.get('/get-prestation')
                    this.services = response.data
                    this.isLoading = false
                } catch(error) {
                    alert(error)
                }
            },
            
        },
        computed : {
            prestationList() {
                return this.services.filter((s) => {
                    return s.tag == 'prestation'
                })
            },
            aboutUsPage() {
                return this.services.filter((s) => {
                    return s.tag == 'about us'
                })
            }
        }
    }
</script>
