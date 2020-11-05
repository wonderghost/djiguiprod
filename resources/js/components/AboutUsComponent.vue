<template>
    <div>
        <div class="container">
                <nav class="bread">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="/" class="breadcrumb"><i class="material-icons">home</i></a>
                            <a href="#!" class="breadcrumb">A Propos</a>
                            <!-- <a href="#!" class="breadcrumb">Third</a> -->
                        </div>
                    </div>
                </nav>
            </div>
            <!-- PARALLAXE -->
            <div id="index-banner" class="parallax-container">
                <div class="section no-pad-bot">
                    <div class="container">
                        <h1 class="header center white-text">A Propos</h1>
                    </div>
                </div>
                <div class="parallax"><img src="/img/slide-1.jpg" alt="Unsplashed background img 1"></div>
            </div>
            <!-- // -->
            <div v-for="d in aboutUs" :key="d.slug" class="container">
                <h4>{{d.title}}</h4>
                <p v-html="d.content"></p>
            </div>
    </div>    
</template>
<script>
    export default {
        mounted() {
            $('.parallax').parallax();

            this.getData()
        },
        data() {
            return {
                laData : []
            }
        },
        methods : {
            getData : async function () {
                try {
                    let response = await axios.get('/get-prestation')
                    if(response.data) {
                        this.laData = response.data
                    }
                } catch(error) {
                    alert(error)
                }
            }
        },
        computed : {
            aboutUs() {
                return this.laData.filter((d) => {
                    return d.tag == 'about us'
                })
            }
        }
    }
</script>
