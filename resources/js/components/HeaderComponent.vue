<template>
    <div>
        <template v-if="type == 'djigui'">
            <div class="navbar-fixed">
                 <!-- Dropdown Structure -->
                <ul id="dropdown1" class="dropdown-content">
                    <li><a href="/news/articles/add">Articles</a></li>
                    <li><a href="/admin/manage-pages">Pages</a></li>
                    <li><a href="/admin/manage-users">Utilisateur</a></li>
                    <li><a href="/admin/bannieres">Bannieres</a></li>
                    <!-- <li><a href="#!">two</a></li> -->
                    <!-- <li class="divider"></li> -->
                    <!-- <li><a href="#!">three</a></li> -->
                </ul>
                <nav>
                    <div class="nav-wrapper my-nav">
                    <a href="/" class="brand-logo"><img src="/img/logo-djigui.png" width="200" height="60" alt="Djiguiprod"></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li v-for="(m , name) in links" :key="name"><a :href="m">{{name}}</a></li>
                        <li v-if="user != 'null'"><a class="dropdown-trigger" href="#!" data-target="dropdown1">{{  user  }}<i class="material-icons right">arrow_drop_down</i></a></li>
                        <li v-if="user != 'null'">
                            <a @click="logout()">Logout</a>
                        </li>
                    </ul>
                    <a class="right sidenav-trigger" data-target="slide-out" style="margin-right : 2% !important;"><i class="material-icons">menu</i></a>
                    </div>
                </nav>
            </div>
            <ul id="slide-out" class="sidenav">
                <li v-for="(m,name) in links" :key="name"><a class="waves-effect" :href="m">{{name}}</a></li>
            </ul>
        </template>
        <template v-if="type == 'djigui-news'">
            <div style="background-color: grey;">
                <a href="/" class="brand-logo"><img src="/img/logo-djigui.png" width="200px" height="50px"></a>
                <div class="hide-on-med-and-down" style="float: right; margin-top: 10px;">
                  <a href="/" class="waves-effect waves-light btn light-blue darken-2" style="font-size: 11px;">A propos</a>
                  <a href="/" class="waves-effect waves-light btn light-blue darken-2" style="font-size: 11px;">Contact</a>
                  <a href="/" class="waves-effect waves-light btn light-blue darken-2" style="font-size: 11px;">Publicite</a>
                </div>
            </div>
<!-- ici se touve le menu principale fixe et dure -->
      <!-- Dropdown Structure -->
              <ul id="dropdown10" class="dropdown-content">
                <li><a class="" href="/news/articles/add">Articles</a></li>
                <li><a class="" href="/admin/manage-pages">Pages</a></li>
                <li><a class="" href="/admin/manage-users">Utilisateur</a></li>
                <li><a class="" href="/admin/bannieres">Bannieres</a></li>
                <li><a class="" style="cursor : pointer !important;" @click="logout()">Logout</a></li>
              </ul>
              <ul id="dropdown02" class="dropdown-content">
               <li><a class="" href="/news/articles/add">Articles</a></li>
                <li><a class="" href="/admin/manage-pages">Pages</a></li>
                <li><a class="" href="/admin/manage-users">Utilisateur</a></li>
                <li><a class="" href="/admin/bannieres">Bannieres</a></li>
                <li><a class="" style="cursor : pointer !important;" @click="logout()">Logout</a></li>
              </ul>
              <nav class="nav grey darken-3">
                  <div class="nav-wrapper">
                    <!-- <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a> -->
                    <ul class="center hide-on-med-and-down" >
                      <li><a href="/news">Dernieres</a></li>
                      <li v-for="l in menu.category" :key="l.slug" class="mr-6">
                        <a class="text-white" :href="'/news/category/'+l.slug">{{l.name}}</a>
                    </li>
                      <li v-if="user != 'null'"><a class="dropdown-trigger" href="#!" data-target="dropdown10">{{  user  }}<i class="material-icons right">arrow_drop_down</i></a></li>
                    </ul>
                    <ul class="side-nav hide-on-large-only" id="mobile-demo">
                        <li>
                             <ul id="slide-out" class="sidenav">
                                <li><a href="/news">Dernieres</a></li>
                                <li v-for="l in menu.category" :key="l.slug" class="mr-6">
                                <a class="text-white" :href="'/news/category/'+l.slug">{{l.name}}</a>
                                </li>
                                <li v-if="user != 'null'"><a class="dropdown-trigger" href="#!" data-target="dropdown02">{{  user  }}<i class="material-icons right">arrow_drop_down</i></a></li>
                              </ul>
                            <a href="#"  data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                        </li>
                     
                    </ul>
                    <a style="float: right; margin-top:15px; margin-right: 15px;" class="modal-trigger" href="#modal1"><i class="material-icons" style="margin-top: -10px;">search</i></a>
                  </div>
              </nav>
<!-- ici se termine le menu  -->
        </template>
    </div>
</template>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
      <script type="text/javascript">
          
          $(document).ready(function(){
            $('.carousel.carousel-slider').carousel({
            fullWidth: true
              });
            $(".dropdown-trigger").dropdown();
          });
        
      </script>
<script>
import { Slide } from 'vue-burger-menu'
    export default {
        components : {
            Slide
        },
        props : {
            type : String,
            user : String
        },
        mounted() {
            $(".dropdown-trigger").dropdown()
            $('.sidenav').sidenav()
            this.getMenuNews()
        },
        data() {
            return {
                links : {
                    'Acceuil' : '/',
                    'Actualites' : '/news',
                    'Prestations' : '/prestations',
                    // 'Videos': '/videos',
                    // 'Evenements': '/events',
                    'A Propos' : '/about-us'
                },
                menu : [],
                dropState : false
            }
        },
        methods : {
            dropMenu : function () {
                try {
                    if(this.dropState == false) {
                        this.dropState = true
                    } else {
                        this.dropState = false
                    }
                } catch(error) {
                    alert(error)
                }
            },
            getMenuNews : async function () {
                try {
                    this.isLoading = true
                    let response = await axios.get('/news/articles/get-category')
                    if(response.data) {
                        this.isLoading = false
                        this.menu = response.data
                        this.$store.commit('setCategory',response.data)
                    }
                    
                } catch(error) {
                    alert(error)
                }
            },
            logout : async function () {
                try {
                    this.isLoading = true
                    
                    let response = await axios.post('/logout',{
                        _token : document.querySelector("meta[name='csrf-token']").content
                    })
                    location.reload()
                } catch(error) {
                    alert(error)
                }
            }
        }
    }
</script>