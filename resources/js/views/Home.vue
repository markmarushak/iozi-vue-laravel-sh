<template>

    <div class="row">

        <div class="col-sm-10">

            <div class="products">

                <transition-group name="fade" tag="div" class="row">
                    <div class="col-sm-6" v-for="product in products" :key="product.id">

                            <div class="card">
                                <div class="row no-gutters">
                                    <div class="col-sm-6">
                                        <a v-if="product.images != ''" data-toggle="modal" data-target="#exampleModal"
                                           @click="modals = product.images">
                                            <img v-bind:src="'public/storage/'+ product.images[0].value"
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
                                                    {{ time.value }} $
                                                </div>
                                            </div>
                                            <hr>
                                            <h5 class="card-title">{{ product.fullname }}</h5>
                                            <p class="card-text">{{ product.description }}</p>
                                            <!--<a href="#" class="btn btn-primary">Узнать </a>-->
                                            <router-link
                                                    class="btn btn-prinary"
                                                    :to="{ name: 'product', params: { product: product } }"> Узнать
                                            </router-link>
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
                            <label v-for="fil in options"><input type="checkbox" @click="search(fil.id)">{{ fil.name }}</label>
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
                    <div class="modal-body profile-more-info">
                        <carousel :navigationEnabled="true" :perPage="1">
                            <slide v-for="modal in modals" :key="modal.id">
                                <img v-bind:src="'public/storage/' + modal.value" class="card-img-top" alt="">
                            </slide>
                        </carousel>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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
                options: [],
                filters: [],
                modals: '123123',
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
            })
            },
            search(filter){
                if (this.filters.indexOf(filter) >= 0) {
                    this.filters.splice(this.filters.indexOf(filter), 1)
                } else {
                    this.filters.push(filter)
                }
                axios.post(route('products.search'), this.filters)
                    .then(res => {
                        this.products = res.data
                })
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
            ;
            this.fetchProduct()

        },
        created() {
            window.addEventListener('resize', this.handleResize)
            this.handleResize();
        },
        destroyed() {
            window.removeEventListener('resize', this.handleResize)
        },
        components: {
            Carousel,
            Slide
        }
    }

</script>