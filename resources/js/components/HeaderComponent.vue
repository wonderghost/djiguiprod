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
            <nav class="flex items-center justify-between flex-wrap bg-black p-0">
                <div class="flex items-center flex-shrink-0 text-white mr-0">
                    <img src="/img/logo-djigui.png" width="200" alt="">
                </div>
                <div class="visible lg:invisible absolute right-0 mr-20 top-0">
                    <!-- <a class="text-white"><i class="material-icons">menu</i></a> -->
                    <Slide right reveal>
                        <a id="home" href="/news/"> 
                            <span>Home</span>  
                        </a>
                        <a :href="'/news/category/'+k.slug" v-for="k in menu.category" :key="k.slug">
                            <span>{{k.name}}</span>
                        </a>
                        <a v-if="user != 'null'" href="#">
                            <!-- <span>Admin</span> -->
                            <ul class="drop-list rounded w-full">
                                <li><a class="" href="/news/articles/add">Articles</a></li>
                                <li><a class="" href="/admin/manage-pages">Pages</a></li>
                                <li><a class="" href="/admin/manage-users">Utilisateur</a></li>
                                <li><a class="" href="/admin/bannieres">Bannieres</a></li>
                                <li><a class="" style="cursor : pointer !important;" @click="logout()">Logout</a></li>
                            </ul>
                        </a>
                    </Slide>
                </div>
                <ul class="flex mx-auto invisible md:invisible lg:visible">
                    <li class="mr-6"><a class="text-white" href="/news/"><i class="material-icons">home</i></a></li>
                    <li v-for="l in menu.category" :key="l.slug" class="mr-6">
                        <a class="text-white" :href="'/news/category/'+l.slug">{{l.name}}</a>
                    </li>
                    <li v-if="user != 'null'" class="my-dropdown">
                        <a class="text-white btn-drop text-left" @click="dropMenu()" href="#">{{user}} <i class="material-icons">arrow_drop_down</i></a>
                        <!-- admin menu -->
                        <ul v-show="dropState" class="drop-list absolute z-50 shadow-md bg-white p-5 rounded">
                            <li><a class="hover:text-blue-600" href="/news/articles/add">Articles</a></li>
                            <li><a class="hover:text-blue-600" href="/admin/manage-pages">Pages</a></li>
                            <li><a class="hover:text-blue-600" href="/admin/manage-users">Utilisateur</a></li>
                            <li><a class="hover:text-blue-600" href="/admin/bannieres">Bannieres</a></li>
                            <li><a class="hover:text-blue-600" style="cursor : pointer !important;" @click="logout()">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </template>
    </div>
</template>

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
