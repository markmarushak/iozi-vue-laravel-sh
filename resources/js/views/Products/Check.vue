<template>

    <div class="row">

        <table class="table table-dark text-center">
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Статус</th>
                    <th>Фото</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

                <tr v-for="product in products">
                    <td>{{ product.products.fullname }}</td>
                    <td>{{ product.products.confirm }}</td>
                    <td>
                        <div class="images" v-viewer="{movable: false}">
                            <img :src="assets(product.img)" style="width: 25px;">
                        </div>
                    </td>
                    <td>
                        <button @click="confirm(product)" class="btn btn-success">Подтвердить</button>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

</template>

<script>

    export default {
        data(){
            return {
                products: []
            }
        },
        mounted(){
            this.fetch()
        },
        methods: {
            confirm(product){
                axios.post(route('confirm.success'), product)
                    .then(response => {
                        this.fetch()
                })
            },
            fetch(){
                axios.get(route('confirm.list'))
                    .then(res => {
                        this.products = res.data
                })
            }
        },
        computed: {
            list(){
                return this.products.filter((product) => {
                    return product
                })
            }
        }
    }

</script>