<template>
    <div>
        <footer class="page-footer grey darken-3">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <div class="text-2xl mb-8 font-sans">DjiguiProd News</div>
                    <div>
                        <div class="text-xl font-sans">Newsletters</div>
                        <p class="text-grey-darker leading-normal">Souscrivez pour ne rien manquer de l'actualite culturelle !</p>
                        <div class="mt-4 flex">
                            <form @submit.prevent="">
                                <input type="text" class="p-2 border border-grey-light round text-grey-dark text-sm h-auto" placeholder="Votre adresse email" required>
                                <button class="waves-effect waves-light btn light-blue darken-2">Souscrire</button>
                            </form>
                        </div>
                    </div>
              </div>
              <div class="col l4 offset-l2 s12">
               <div>
                        <div class="text-xl font-sans">Reseaux Sociaux</div>
                        <div class="fb-page" data-href="https://www.facebook.com/Djiguiproduction" data-tabs="timeline" data-width="" data-height="70" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Djiguiproduction" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Djiguiproduction">Djigui Prod</a></blockquote></div>
                    </div>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
                <p class="text-center">
                    <span>&copy; {{LaDate}} Djiguiprod</span>
                    <span class="pl-5" v-for="(l,name) in footerLinks" :key="l"><a class="hover:text-blue-600" :href="'/news/links'+name">{{ l }}</a></span>
                </p>
                <p class="text-right">
                    <span><a class="hover:text-blue-600" href="https://www.facebook.com/smartechGuinee" target="_blank">Developp&eacute; par SmartechGuinee</a></span>
                </p>
            </div>
          </div>
        </footer>
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
