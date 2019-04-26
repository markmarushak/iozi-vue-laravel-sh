<template>
    <div>
        <header>
            
            <div class="container nav-top">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="title name-site">{{ title }}</h3>
                    </div>

                    <div class="col-sm-6 ">
                        <router-link :to="{ name: 'app' }">Главная</router-link> 
                        <router-link :to="{ name: 'cabinet' }">Личный Кабинет</router-link>
                    </div>
                </div>
            </div>
            <!-- <div class="home-image">
                <img src="http://sfwallpaper.com/images/cool-picture-5.jpg" alt="">
            </div> -->
        </header>

        <div class="container">
            <router-view></router-view>
        </div>
        <footer class="footer">
            <div class="container">
                <p class="p-footer">
                @copyriting this site done @ozobochenye
            </p>
            </div>
        </footer>
    </div>
</template>
<script>
    export default {
        name: 'app',
        data() {
            return {
                title: 'Это первый сайт на vue.js',

            }
        }
    }
</script>