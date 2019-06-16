<template>

    <div class="row">
        <div class="col-sm-10">

            <div class="products">
                <transition-group
                        enter-active-class="animated fadeInUp"
                        leave-active-class="animated bounceOutRight" tag="div" class="row product-home">
                    <div class="col-sm-6" v-for="product in sidebar" :key="product.id">


                            <div class="card">
                                <div class="row no-gutters">
                                    <div class="col-sm-6">
                                        <a v-if="product.images != ''" data-toggle="modal" data-target="#exampleModal"
                                           @click="modals = product.images">
                                            <img v-bind:src="assets(product.images[0].value)"
                                                 class="card-img-top">
                                        </a>
                                        <a v-if="product.images == ''" @click="modals = product.images">
                                            <img src="public/img/notFound.png" class="card-img-top" alt="test">
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card-body">
                                            <div class="price">
                                                <div v-for="time in product.time">
                                                    <span>{{ time.name }}</span>
                                                    {{ time.value }} P
                                                </div>
                                            </div>
                                            <hr>
                                            <h5 class="card-title">{{ product.fullname }}</h5>
                                            <p class="card-text">{{ product.description }}</p>
                                            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#exampleModal" @click="openProduct = product">Узнать</button>
                                            <button class="btn btn-block btn-success"><i class="fas fa-phone-square"></i> Вызвать</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <br>
                    </div>

                </transition-group>

            </div>

        </div>

        <div class="filter">

            <button class="filter-button" v-if="window.width <= 768" @click="filterTrigger = !filterTrigger">
                <span v-if="!filterTrigger"><i class="fas fa-search-dollar"></i> фильтр анкет</span>
                <span v-else><i class="fas fa-window-close"></i> закрыть фильтр</span>
            </button>
            <transition name="model">
                <div class="filter-list" v-if="window.width > 768">
                    <div class="form">
                        <h5> Расширенный поиск</h5>
                        <div class="form-group">
                            <!--<label v-for="fil in options"><input type="checkbox" @click="search(fil.id)">{{ fil.name }}</label>-->
                            <label class="checkbox-product-option" v-for="fil in options">
                                <input type="checkbox" @click="search(fil.id)">
                                <span class="text">{{ fil.name }}</span>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </transition>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body profile-more-info bg-white">
                        <div class="carousel">
                            <carousel :navigationEnabled="true"
                                      :perPage="1"
                                      :autoplay="true"
                                      :loop="true">
                                <slide v-for="image in openProduct.images" :key="image.id">
                                    <img v-bind:src="assets(image.value)" class="card-img-top" alt="">
                                </slide>
                            </carousel>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <h3>{{ openProduct.fullname }}</h3>

                                    <p>{{ openProduct.description }}</p>

                                    <ul>
                                        <li v-for="attr in openProduct.attr">
                                            {{ attr.value }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">закрыть</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>

    import {Carousel, Slide} from 'vue-carousel';
    import axios from 'axios'

    export default {
        data(){
            return {
                products: [],
                openProduct: '',
                options: [],
                filters: [],
                window: {
                    width: 0,
                    height: 0
                },
                filterTrigger: false
            }
        },
        methods: {
            fetchProduct()
            {
                axios.get(route('products.index'))
                    .then(res => {
                        this.products = (res.data)
                        this.openProduct = res.data[0]
                        this.$store.commit('set',{type: 'preloader', items: {load: false, text: ''}})
                    })
            },
            search(filter){
                if (this.filters.indexOf(filter) >= 0) {
                    this.filters.splice(this.filters.indexOf(filter), 1)
                } else {
                    this.filters.push(filter)
                }
            },
            handleResize() {
                this.window.width = window.innerWidth;
                this.window.height = window.innerHeight;
            }
        },
        mounted() {
            axios.get(route('attribute.index', {type: 'option'}))
                .then(res => {
                    this.options = res.data
            })
            this.$store.commit('set',{type: 'bg', items: false})
            this.fetchProduct()

        },
        created() {
            window.addEventListener('resize', this.handleResize)
            this.handleResize();
        },
        destroyed() {
            window.removeEventListener('resize', this.handleResize)
        },
        computed: {
            sidebar: function(){
                let f = this.filters
                return this.list.filter(function (product) {
                    if(f != ''){
                        let o = product.options;
                        let check = 0
                        for(let i = 0; i < f.length; i++){
                            for(let x = 0; x < o.length; x++){
                                if(f[i] == o[x].attribute_id){
                                    check++
                                }
                            }
                        }
                        if(check >= f.length)
                        {
                            return product
                        }
                        return false
                    }else{
                        return product
                    }
                })
            },
            list: function () {
                return this.products.filter(function (prodcut) {
                    let attr =  prodcut['attributes']
                    try {
                        prodcut['attr'] = []
                        prodcut['options'] = []
                        prodcut['images'] = []
                        prodcut['time'] = []
                        for(var i = 0; i < attr.length; i++){
                            switch (attr[i].type){
                                case 'attr':
                                    prodcut['attr'].push(attr[i])
                                    break;
                                case 'option':
                                    prodcut['options'].push(attr[i])
                                    break;
                                case 'images':
                                    prodcut['images'].push(attr[i])
                                    break;
                                case 'time':
                                    prodcut['time'].push(attr[i])
                                    break;
                            }
                        }
                        return prodcut
                    }catch (error){
                        console.log(error)
                    }
                })
            }
        },
        components: {
            Carousel,
            Slide
        }
    }

</script>