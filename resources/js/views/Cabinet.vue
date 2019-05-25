<template>
	<div class="row">
		<div class="col-sm-12" v-if="!showModel">
			<div class="row">

				<div class="col-sm-9">

					<router-view></router-view>

					<div class="jumbotron jumbotron-fluid" v-if="$router.currentRoute.name == 'cabinet'">
						<div class="container">
							<h1 class="display-4">Приветствуем в личном кабинете!!</h1>
							<p class="lead">следите за новостями и контролируйте Ваш личный кабинет</p>
						</div>
					</div>

				</div>

				<div class="col-sm-3">

					<ul class="list-group">
						<li class="list-group-item list-group-item-action">
							<router-link :to="{ name: 'setting' }"> Персональные данные</router-link>
						</li>
						<li class="list-group-item list-group-item-action list-group-item-primary">
							<router-link
									:to="{ name: 'payment' }"> Пополнить счет
							</router-link>
						</li>
						<li class="list-group-item list-group-item-action list-group-item-success">
							<router-link
									:to="{ name: 'products' }"> Добавить анкету
							</router-link>
						</li>
						<li class="list-group-item list-group-item-action list-group-item-primary">
							<router-link
									:to="{ name: 'rent' }"> Оплатить Аренду
							</router-link>
						</li>
						<li class="list-group-item list-group-item-action">
							<router-link :to="{ name: 'tariff' }"> Настройка Тарифов</router-link>
						</li>
						<li class="list-group-item list-group-item-action">
							<router-link :to="{ name: 'product-settings' }"> Настройка анкет</router-link>
						</li>
					</ul>

				</div>
				<div class="col-sm-12" v-if="$router.currentRoute.name == 'cabinet'">

					<div class="row">

						<div class="col-sm-3" v-for="product in products">
							<div class="card">
								<div class="row no-gutters">
									<div class="col-sm-12">
										<a v-if="product.images != ''" data-toggle="modal" data-target="#exampleModal"
										   @click="modals = product.images">
											<img v-bind:src="'public/storage/'+ product.images[0].value"
												 class="card-img-top">
										</a>
										<a v-if="product.images == ''" data-toggle="modal" data-target="#exampleModal"
										   @click="modals = product.images">
											<img src="public/img/notFound.png" class="card-img-top" alt="test">
										</a>
									</div>
									<div class="col-sm-12">
										<div class="card-body text-center">
											<h5 class="card-title">{{ product.fullname }}</h5>
											<div class="row">
												<div class="col-sm-8">
													<button class="btn btn-warning"
															@click="editProduct(product)">Редактировать
													</button>
												</div>
												<div class="col-sm-4">
													<button class="btn btn-danger" @click="deleteProduct(product.id)"><i
															class="fas fa-trash-alt"></i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<br>

						</div>

					</div>

				</div>
			</div>
		</div>
		<edit-product :product="product" v-if="showModel" @close="showModel = !showModel"></edit-product>
	</div>
</template>

<style lang="scss">
	.modal-mask {
		position: absolute;

		.modal-container {
			width: 80%;
		}
	}
</style>


<script>

    import axios from 'axios'
    import EditProduct from './Cabinet/EditProduct'

    export default {
        data(){
            return {
                products: [],
                product: '',
                user_id: '',
                showModel: false
            }
        },
        mounted(){
            this.fetchProduct()
        },
        methods: {
            fetchProduct(){

                axios.get(route('get.user'))
                    .then(res => {
                    this.user_id = res.data.id
            })

                axios.get(route('products.index'), {id: this.user_id})
                    .then(res => {
                    this.products = res.data
            })
            },
            editProduct(product){
                this.showModel = !this.showModel
                this.product = product
            },
            deleteProduct(id){
                axios.delete(route('products.destroy', {id: id}))
                    .then(res => {
                    console.log(res.data)
                this.fetchProduct()
            })
            }
        },
        components: {
            'edit-product': EditProduct
        }
    }

</script>