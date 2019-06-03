<template>

    <div class="row">

        <table>
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Статус</th>
                    <th>Рейтинг</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

                <tr v-for="product in products">
                    <td>{{ product.product.fullname }}</td>
                    <td>{{ product.product.status }}</td>
                    <td>{{ product.product.rating }}</td>
                    <td></td>
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
            axios.get('products.confirm.list')
                .then(res => {
                this.products = res.data
            })
        }
    }

</script>