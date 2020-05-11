<template>
    <div>
         <VueCarousel :data="slides"></VueCarousel>
         <!-- ABOUT US -->
        <div class="container">
            <h4></h4>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad itaque, repellat reiciendis nam consequuntur voluptatibus labore hic rem quis necessitatibus. Minus qui vel similique repellendus nostrum neque ab alias magni.
            </p>
            <a href="#" class="btn light-blue darken-4 waves-effect waves-light">En savoir plus</a>
        </div>
         <!-- // -->
        <!-- NOS PRESTATIONS -->
         <div class="container">
             <h5>Nos Prestations</h5>
             <div class="row">
                 <div v-for="n in services" :key="n" class="col s4">
                     <div class="card-panel grey lighten-5">
                        <h5 class="">{{n}}</h5>
                        <p class="">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta excepturi vitae distinctio dolor incidunt molestias repellat, exercitationem consequatur perferendis provident, vel id voluptatibus, impedit maxime libero quae molestiae. Eius, nisi.
                        </p>
                        <a href="#" class="btn waves-effect waves-light light-blue darken-4">En savoir plus</a>
                    </div>
                 </div>
             </div>
         </div>
         <!-- PARTENAIRES -->
        <div class="container">
            <h5>Nos Partenaires & Sponsors</h5>
            <div class="row">
                <InfiniteSlideBar>
                    <img v-for="i in partners" :alt="i" :key="i" style="width : 100px ;height : 60px ; margin-left : 10%" :src="'/partners/'+i">
                </InfiniteSlideBar>
            </div>
        </div>
         <!-- // -->
         <!-- CONTACT US -->
        <div class="container">
            <div class="row">
                <div class="col s6">
                    MAPS    
                </div>
                <div class="col s6">
                    CONTACT FORM
                </div>
            </div>
        </div>
         <!-- // -->
    </div>
    
</template>
<script>
import VueCarousel from '@chenfengyuan/vue-carousel';
import InfiniteSlideBar from 'vue-infinite-slide-bar'

    export default {
        components : {
            VueCarousel,
            InfiniteSlideBar
        },
        mounted() {
            
        },
        data() {
            return {
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
                services : ['Conseils & Coaching',"Management Artistique","Evenementiel","Gestion de projet","Expertise & Marketing"],
                partners : ['partner1.jpg','partner2.png','partner3.jpg','partner4.jpg']
            }
        },
        methods : {

        }
    }
</script>
