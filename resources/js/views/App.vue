<template>
    <div class="wrap">

        <header id="header">

            <nav class="navbar navbar-expand-lg navbar-dark ">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <i class="fas fa-bars"></i>
                </button>



                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ">
                        <li class="nav-item logo-in-menu">
                            <a class="nav-link d-none d-sm-block bg-main text-uppercase text-right" href="#">ДЕВУШКИ НА ЛЮБОЙ ВКУС
                                <br> НИЖНИЙ НОВГОРОД</a>
                        </li>

                        <li class="nav-item">
                            <router-link class="nav-link bg-main text-uppercase" :to="{ name: 'home' }">Галвная</router-link>
                        </li>

                        <li class="nav-item cabinet-menu" v-if="!$auth.check()">
                            <router-link class="nav-link" :to="{ name: 'login' }">Вход</router-link>
                        </li>
                        <span class="nav-item cabinet-menu">
                        <li v-if="$auth.check()" class="pull-right nav-item">
                                <router-link class="nav-link bg-main text-uppercase text-left" :to="{ name: 'cabinet' }">личный кабинет <br> для девушек</router-link>
                            </li>

                    <li>
                      <span v-show="$auth.impersonating()">
                          &bull;
                          <a v-on:click="unimpersonate()" href="javascript:void(0);">(logout {{ $auth.user().username }})</a>
                      </span>
                    </li>
                   </span>
                    </ul>

                </div>
            </nav>
        </header>
        <div class="container">
            <transition name="slide-fade">
                <router-view></router-view>
            </transition>
        </div>

        <div class="wrap-bg" v-bind:class="{cabinet: $store.getters.bg}"></div>
        <alert v-if="$store.getters.preloader.load"></alert>
    </div>
</template>

<script>

    import Alert  from '../components/Alert.vue'

    export default {
        mounted() {
            var _this = this;
            // Set up $auth.ready with other arbitrary loaders (ex: language file).
            setTimeout(function () {
                _this.loaded = true;
            }, 500);
        },
        created() {
            var _this = this;
            this.$auth.ready(function () {
                console.log('ready ' + this.context);
            });
        },
        methods: {
            logout() {
                this.$auth.logout({
                    makeRequest: true,
                    success() {
                        console.log('success ' + this.context);
                    },
                    error() {
                        console.log('error ' + this.context);
                    }
                });
            },
            unimpersonate() {
                this.$auth.unimpersonate({
                    success() {
                        console.log('success ' + this.context);
                    },
                    error() {
                        console.log('error ' + this.context);
                    }
                });
            }
        },
        components: {
            'alert': Alert
        }
    }
</script>