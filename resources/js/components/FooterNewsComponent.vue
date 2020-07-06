<template>
    <div>
        <div class="bg-white text-black border mt-10 p-8">
            <div class="container mx-auto">
                <div class="text-2xl mb-8 font-sans">DjiguiProd News</div>
                <div class="grid grid-cols-4">
                    <div>
                        <div class="text-xl font-sans">Actualites</div>
                        <ul class="list-none">
                            <li v-for="n in newsCategory.category" :key="n.slug"> <a :href="'/news/category/'+n.slug" class="hover:text-blue-600">{{n.name}}</a> </li>
                        </ul>
                    </div>
                    <div>
                        <div class="text-xl font-sans">Newsletters</div>
                        <p class="text-grey-darker leading-normal">Souscrivez pour ne rien manquer de l'actualite culturelle !</p>
                        <div class="mt-4 flex">
                            <form @submit.prevent="">
                                <input type="text" class="p-2 border border-grey-light round text-grey-dark text-sm h-auto" placeholder="Votre adresse email" required>
                                <button class="bg-blue-600 p-2 h-auto text-sm font-serif text-white">Souscrire</button>
                            </form>
                        </div>
                    </div>
                    <div>
                        <div class="text-xl font-sans">Reseaux Sociaux</div>
                        <div class="fb-page" data-href="https://www.facebook.com/Djiguiproduction" data-tabs="timeline" data-width="" data-height="70" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Djiguiproduction" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Djiguiproduction">Djigui Prod</a></blockquote></div>
                    </div>
                    <div>
                        <!-- <a class="twitter-timeline h-2" href="https://twitter.com/djiguiprod?ref_src=twsrc%5Etfw">Tweets by djiguiprod</a>  -->
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 border pl-10 pr-10 text-sm">
            <p class="text-center">
                <span>&copy; {{LaDate}} Djiguiprod</span>
                <span class="pl-5" v-for="(l,name) in footerLinks" :key="l"><a class="hover:text-blue-600" :href="'/news/links'+name">{{ l }}</a></span>
            </p>
            <p class="text-right">
                <span><a class="hover:text-blue-600" href="https://www.facebook.com/smartechGuinee" target="_blank">Developp&eacute; par SmartechGuinee</a></span>
            </p>
        </div>
    </div>
</template>
<script>
    export default {
        props : {
            LaDate : String
        },
        mounted() {
            
        },
        data() {
            return {
                footerLinks : {
                    'contact-us' : 'Contactez Nous',
                    'conditions-utilisation'    : "Conditions d'utilisation",
                    'help'  : "Aide"
                }
            }
        },
        methods : {
            
        },
        computed : {
            newsCategory() {
                return this.$store.state.category
            }
        }
    }
</script>
