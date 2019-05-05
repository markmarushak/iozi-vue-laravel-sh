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

		<div class="col-sm-12">
			

		</div>

	</div>
</template>


<script>
	
	export default {
		mounted(){
		}
	}

</script>