<template>
	<div class="row">

		<div class="col-sm-12" v-if="!showModal">
			<div class="row d-flex flex-row">

				<div class="col-md-3 order-md-last">

					<ul class="list-group">
						<li class="list-group-item list-group-item-action ">
							<router-link
									:to="{ name: 'cabinet' }"><i class="fas fa-images"></i> Свои анкеты
							</router-link>
						</li>
						<li class="list-group-item list-group-item-action "  v-if="isAdmin">
							<router-link
									:to="{ name: 'products-check' }"><i class="fas fa-clipboard-check"></i> Проверка анкет
							</router-link>
						</li>
						<li class="list-group-item list-group-item-action">
							<router-link :to="{ name: 'setting' }"><i class="fas fa-users-cog"></i> Персональные данные</router-link>
						</li>
						<li class="list-group-item list-group-item-action ">
							<router-link
									:to="{ name: 'payment' }"><i class="fas fa-wallet"></i> Пополнить счет
							</router-link>
						</li>
						<li class="list-group-item list-group-item-action ">
							<router-link
									:to="{ name: 'products' }"><i class="fas fa-plus-square"></i> Добавить анкету
							</router-link>
						</li>
						<!-- <li class="list-group-item list-group-item-action ">
							<router-link
									:to="{ name: 'rent' }"> Оплатить Аренду
							</router-link>
						</li> -->
						<li class="list-group-item list-group-item-action" v-if="isAdmin">
							<router-link :to="{ name: 'tariff' }">Стоимость Размещения</router-link>
						</li>
						<li class="list-group-item list-group-item-action" v-if="isAdmin">
							<router-link :to="{ name: 'product-settings' }"> Настройка анкет</router-link>
						</li>
					</ul>

				</div>

				<div class="col-md-9 order-md-first">

					<router-view></router-view>

					<div class="jumbotron jumbotron-fluid text-black" v-if="$router.currentRoute.name == 'cabinet'">
						<div class="container">
							<h1 class="display-4">Приветствуем в личном кабинете {{ person.fullname }}</h1>
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
											<img v-bind:src="product.images[0].value"
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
													<button class="btn btn-info" @click="confirmProduct(product)"><i class="fas fa-clipboard-check"></i>
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
		<edit-product :product="product" v-if="editModal" @close="closeModal()"></edit-product>

		<confirm-modal :product="product" v-if="confirmModal" @close="closeModal()"></confirm-modal>
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
	import ConfirmModal from './Cabinet/ConfirmModal'

    export default {
		created(){
            this.person.fullname = window.user.name
            this.$auth.role.roleLevel <= 1 ? this.isAdmin = true : false
        },
        data(){


			return {
				products: [],
				product: '',
				showModal: false,
				editModal: false,
				confirmModal: false,
				isAdmin: false,
				person: {
                    fullname: ''
				}
            }
        },
        mounted(){
            this.fetchProduct()
            this.$store.commit('set',{type:'bg', items: true})
        },
        methods: {
            fetchProduct(){
               if(this.isAdmin){
                   axios.get(route('products.index'))
                       .then(res => {
						   this.products = res.data
				   })
			   }else {
                   axios.get(route('products.cabinet'))
                       .then(res => {
						   this.products = res.data
				   })
			   }
            },
            editProduct(product){
                this.product = product
				this.editModal = true
                this.showModal = true
            },
            deleteProduct(id){
                axios.delete(route('products.destroy', {id: id}))
                    .then(res => {
                    console.log(res.data)
                	this.fetchProduct()
            	})
            },
			confirmProduct(product){
                this.product = product
                this.confirmModal = true
                this.showModal = true
			},
			payProduct(id){
			    axios.post(route('products.pay'), {id: id})
					.then(res => {
					    alert("Продукт проплачен на сутки с до этого времени")
					    this.fetchProduct()
				})
			},
			closeModal(){
			    this.editModal = false
			    this.confirmModal = false
                this.showModal = false
				this.fetchProduct()
			}
        },
        components: {
            'edit-product': EditProduct,
			'confirm-modal': ConfirmModal
        }
    }

</script>