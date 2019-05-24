<template>
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
				<li class="list-group-item list-group-item-action"><router-link :to="{ name: 'setting' }"> Персональные данные </router-link></li>
				<li class="list-group-item list-group-item-action list-group-item-primary"><router-link :to="{ name: 'payment' }"> Пополнить счет </router-link></li>
				<li class="list-group-item list-group-item-action list-group-item-success"><router-link :to="{ name: 'products' }"> Добавить анкету </router-link></li>
				<li class="list-group-item list-group-item-action list-group-item-primary"><router-link :to="{ name: 'rent' }"> Оплатить Аренду </router-link></li>
				<li class="list-group-item list-group-item-action"><router-link :to="{ name: 'tariff' }"> Настройка Тарифов </router-link></li>
				<li class="list-group-item list-group-item-action"><router-link :to="{ name: 'product-settings' }"> Настройка анкет </router-link></li>
			</ul>

		</div>
		<div class="col-sm-12" v-if="$router.currentRoute.name == 'cabinet'">

			<div class="row">

				<div class="col-sm-3" v-for="product in products">
					<div class="card">
						<div class="row no-gutters">
							<div class="col-sm-12">
								<a v-if="product.images != ''" data-toggle="modal" data-target="#exampleModal" @click="modals = product.images">
									<img v-bind:src="'public/storage/'+ product.images[0].value" class="card-img-top">
								</a>
								<a v-if="product.images == ''" data-toggle="modal" data-target="#exampleModal" @click="modals = product.images">
									<img src="public/img/notFound.png" class="card-img-top" alt="test">
								</a>
							</div>
							<div class="col-sm-12">
								<div class="card-body text-center">
									<div class="price">
										<div v-for="time in product.time">
											<span>{{ time.name }}</span>
											{{ time.value }} $
										</div>
									</div>
									<hr>
									<h5 class="card-title" >{{ product.fullname }}</h5>
									<button class="btn btn-warning" @click="editProduct(product.id)">Редактировать </button>
								</div>
							</div>
						</div>
					</div>
					<br>

				</div>

			</div>

		</div>

		<modal v-if="showModal" :tag_id="tag_id" :name="tag_name" @close="showModal = false"></modal>

	</div>
</template>


<script>

	import axios from 'axios'
	
	export default {
	    data(){
			return {
			    products: [],
				user_id: ''
			}
        },
		mounted(){
			this.fetchProduct()
		},
		methods: {
		    fetchProduct()
			{

			    axios.get(route('get.user'))
					.then(res => {
					    this.user_id = res.data.id
				})

			    axios.get(route('products.index'), {id: this.user_id})
					.then(res => {
						this.products = res.data
				})
			},
			editProduct(id)
			{

			}
		}
	}

</script>