<template>
    <div>
        <template v-if="type == 'djigui'">
            <div class="navbar-fixed">
                 <!-- Dropdown Structure -->
                <ul id="dropdown1" class="dropdown-content">
                    <li><a href="/news/articles/add">Articles</a></li>
                    <!-- <li><a href="#!">two</a></li> -->
                    <!-- <li class="divider"></li> -->
                    <!-- <li><a href="#!">three</a></li> -->
                </ul>
                <nav>
                    <div class="nav-wrapper my-nav">
                    <a href="/" class="brand-logo"><img src="/img/logo-djigui.png" width="200" height="60" alt="Djiguiprod"></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li v-for="(m , name) in links" :key="name"><a :href="m">{{name}}</a></li>
                        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">{{user}}<i class="material-icons right">arrow_drop_down</i></a></li>
                    </ul>
                    </div>
                </nav>
            </div>
        </template>
        <template v-if="type == 'djigui-news'">
             
            <div class="navbar-fixed">
                <!-- Dropdown Structure -->
                <ul id="dropdown1" class="dropdown-content">
                    <li><a href="/news/articles/add">Articles</a></li>
                    <li><a href="/admin/users">Utilisateurs</a></li>
                    <li><a @click="logout()">Logout</a></li>
                </ul>
                <nav>
                    <div class="nav-wrapper grey darken-3">
                        <a href="/news" class="brand-logo"><img src="/img/logo-djigui.png" width="200" height="60" alt="Djiguiprod"></a>
                        <ul class="right hide-on-med-and-down">
                            <li>
                                <input type="text" placeholder="Recherche " class="white-text" style="border-color : #fff;">
                            </li>
                            <li v-if="user !== 'null'"><a class="dropdown-trigger" href="#!" data-target="dropdown1">{{user}}<i class="material-icons right">arrow_drop_down</i></a></li>
                        </ul>
                        <ul class="right hide-on-med-and-down">
                            <li><a href="/news"><i class="material-icons">home</i></a></li>
                            <li v-for="m in menu.category" :key="m.slug"><a :href="'/news/category/'+m.slug">{{m.name}}</a></li>
                        </ul>
                        <ul class="left">
                            <li><a data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a></li>
                        </ul>
                    </div>
                </nav>


                
            </div>
                <ul id="slide-out" class="sidenav">
                    <li>
                        <div class="user-view">
                            <div class="background">
                                <img src="/img/slide-2.jpg">
                            </div>
                        </div>
                    </li>
                    <li><a href="/news"><i class="material-icons">home</i>Acceuil</a></li>
                    <li v-for="m in menu.category" :key="m.slug">
                        <a :href="'/news/category/'+m.slug"><i class="material-icons">lens</i>{{m.name}}</a>
                    </li>
                    <!-- <li><a href="#!">Second Link</a></li> -->
                    <li><div class="divider"></div></li>
                    <li v-if="user !== 'null'"><a class="subheader">{{user}}</a></li>
                     <li><a href="/news/articles/add">Articles</a></li>
                     <li><a href="/admin/users">Utilisateurs</a></li>
                </ul>
        </template>
    </div>
</template>
<script>
    export default {
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
                    'Prestations' : '/services',
                    'Videos': '/videos',
                    'Evenements': '/events',
                    'A Propos' : '/about-us'
                },
                menu : []
            }
        },
        methods : {
            getMenuNews : async function () {
                try {
                    let response = await axios.get('/news/articles/get-category')
                    this.menu = response.data
                } catch(error) {
                    alert(error)
                }
            },
            logout : async function () {
                try {
                    let response = await axios.post('/logout',{
                        _token : document.querySelector("meta[name='csrf-token']").content
                    })
                    if(response.data === 'done') {
                        location.reload()
                    }
                } catch(error) {
                    alert(error)
                }
            }
        }
    }
</script>
