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
                    </div>
                </nav>
            </div>
        </template>
        <template v-if="type == 'djigui-news'">
            <nav class="flex items-center justify-between flex-wrap bg-black p-0">
                <div class="flex items-center flex-shrink-0 text-white mr-0">
                    <img src="/img/logo-djigui.png" width="200" alt="">
                </div>
                <ul class="flex mx-auto">
                    <li class="mr-6"><a class="text-white" href="/news/"><i class="material-icons">home</i></a></li>
                    <li v-for="l in menu.category" :key="l.slug" class="mr-6">
                        <a class="text-white" :href="'/news/category/'+l.slug">{{l.name}}</a>
                    </li>
                </ul>
            </nav>
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
                    'Prestations' : '/prestations',
                    // 'Videos': '/videos',
                    // 'Evenements': '/events',
                    'A Propos' : '/about-us'
                },
                menu : []
            }
        },
        methods : {
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
