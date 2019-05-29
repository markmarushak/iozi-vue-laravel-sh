<template>
    <div class="row">
        <div class="col-10 align-content-center">

            <div class="row">

                <div class="col-sm-8 col-12">

                    <carousel :navigationEnabled="true" :perPage="1">
                        <slide v-for="image in product.images" :key="image.id">
                            <img v-bind:src="'/public/storage/' + image.value" class="card-img-top" alt="">
                        </slide>
                    </carousel>

                    <h3>{{ product.fullname }}</h3>
                    <hr>

                    <p>{{ product.description }}</p>
                </div>

                <div class="col-md-4 col-12">

                    <div class="btn btn-block btn-main-color" v-for="p in product.attr">
                        <h4>{{ p.name }} <i>{{ p.value }}</i></h4>
                    </div>

                </div>

            </div>

        </div>
    </div>
</template>

<script>

    import {Carousel, Slide} from 'vue-carousel';

    export default {
        data() {
            return {
                product: ''
            }
        },
        mounted(){
            this.fetch()
        },
        methods: {
            fetch(){
                axios.get(route('products.show', {id: this.$router.currentRoute.params.id}))
                    .then(res => {
                    this.product = res.data
                })
            }
        },
        components: {
            'carousel': Carousel,
            'slide': Slide
        }
    }

</script>