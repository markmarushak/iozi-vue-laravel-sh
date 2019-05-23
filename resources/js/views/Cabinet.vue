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

				<div class="col-sm-2" v-for="product in products">

					<div class="card">
						<img v-if="product.images != ''" v-bind:src="'public/storage/'+ product.images[0].value" class="card-img-top" alt="">
						<div class="card-body">
							<h5 class="card-title">Card title</h5>
							<p class="card-text"></p>
							<a href="#" class="btn btn-primary btn-sm">редактировать</a>
						</div>
					</div>

				</div>

			</div>

		</div>

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
			}
		}
	}

</script>