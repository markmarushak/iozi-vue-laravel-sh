<template>
	<div class="row">

		<div class="col-sm-12" v-if="!showModal">
			<div class="row d-flex flex-row">

				<div class="col-md-3 order-md-last">

					<ul class="list-group">
						<li class="list-group-item list-group-item-action ">
							<router-link
									:to="{ name: 'cabinet' }"> Свои анкеты
							</router-link>
						</li>
						<li class="list-group-item list-group-item-action">
							<router-link :to="{ name: 'setting' }"> Персональные данные</router-link>
						</li>
						<li class="list-group-item list-group-item-action ">
							<router-link
									:to="{ name: 'payment' }"> Пополнить счет
							</router-link>
						</li>
						<li class="list-group-item list-group-item-action ">
							<router-link
									:to="{ name: 'products' }"> Добавить анкету
							</router-link>
						</li>
						<li class="list-group-item list-group-item-action ">
							<router-link
									:to="{ name: 'rent' }"> Оплатить Аренду
							</router-link>
						</li>
						<li class="list-group-item list-group-item-action" v-if="$auth.user_role <= 1">
							<router-link :to="{ name: 'tariff' }"> Настройка Тарифов</router-link>
						</li>
						<li class="list-group-item list-group-item-action" v-if="$auth.user_role <= 1">
							<router-link :to="{ name: 'product-settings' }"> Настройка анкет</router-link>
						</li>
					</ul>

				</div>

				<div class="col-md-9 order-md-first">

					<router-view></router-view>

					<div class="jumbotron jumbotron-fluid" v-if="$router.currentRoute.name == 'cabinet'">
						<div class="container">
							<h1 class="display-4">Приветствуем в личном кабинете!!</h1>
							<p class="lead">следите за новостями и контролируйте Ваш личный кабинет</p>
						</div>
					</div>

				</div>

			</div>

			<div class="row" v-if="!showModal">

				<div class="col-sm-12" v-if="$router.currentRoute.name == 'cabinet'">

					<div class="row">

						<div class="col-sm-3" v-for="product in products">
							<div class="card">
								<div class="row no-gutters">
									<div class="col-sm-12">
										<a v-if="product.images != ''" data-toggle="modal" data-target="#exampleModal"
										   @click="modals = product.images">
											<img v-bind:src="'public/storage/'+ product.images[0].value"
												 class="card-img-top" style="height:280px;">
										</a>
										<a v-if="product.images == ''" data-toggle="modal" data-target="#exampleModal"
										   @click="modals = product.images">
											<img src="public/img/notFound.png" class="card-img-top" alt="test" style="height:280px;">
										</a>
									</div>
									<div class="col-sm-12">
										<div class="card-body text-center">
											<h5 class="card-title">{{ product.fullname }}</h5>
											<p><b>Действительна до </b></p>
											<p>{{ product.time_left }}</p>
											<div class="row">
												<div class="col-3">
													<button class="btn btn-warning" @click="editProduct(product)"><i class="far fa-edit"></i></button>
												</div>
												<div class="col-3">
													<button class="btn btn-info" @click="confirmProduct(product.id)"><i class="fas fa-clipboard-check"></i>
													</button>
												</div>
												<div class="col-3">
													<button class="btn btn-danger" @click="deleteProduct(product.id)"><i class="fas fa-trash-alt"></i>
													</button>
												</div>
												<div class="col-3">
													<button class="btn btn-success" @click="payProduct(product.id)"><i class="fas fa-ruble-sign"></i>
													</button>
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
		<edit-product :product="product" v-if="showModal" @close="closeModal()"></edit-product>
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
                showModal: false
            }
        },
        mounted(){
            this.fetchProduct()
            this.$store.commit('set',{type:'bg', items: true})
			console.log(this.$store.getters.bg)
        },
        methods: {
            fetchProduct(){
                axios.get(route('products.cabinet'))
                    .then(res => {
                    	this.products = res.data
            	})
            },
            editProduct(product){
                this.showModal = !this.showModal
                this.product = product
            },
            deleteProduct(id){
                axios.delete(route('products.destroy', {id: id}))
                    .then(res => {
                    console.log(res.data)
                	this.fetchProduct()
            	})
            },
			confirmProduct(id){
                axios.post(route('products.confirm'), {id: id})
					.then(res => {
					    alert('продукт с id - ' + id + ' отправлен на проверку')
				})
			},
			payProduct(id){
			    axios.post(route('products.pay'), {id: id})
					.then(res => {
					    alert("Продукт проплачен на сутки с до этого времени")
				})
			},
			closeModal(){
                this.showModal = !this.showModal
				this.fetchProduct()
			}
        },
        components: {
            'edit-product': EditProduct
        }
    }

</script>