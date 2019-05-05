<template>
	
	<div class="row">
		
		<h2>Оплата аренды</h2>
		<hr>

		<div class="col-sm-12">
			
			<div class="row">
				
				<div class="col-sm-4" v-for="a in 3">
					
					<div class="card-body">
				        <h1 class="card-title pricing-card-title">${{a + 6}}0 <small class="text-muted">/ mo</small></h1>
				        <ul class="list-unstyled mt-3 mb-4">
				          <li>Анкеты: {{ 5 + a}}</li>
				          <li>Время: Сутки</li>
				          <li>Рекламма</li>
				        </ul>
				        <button type="button" class="btn btn-lg btn-block btn-outline-primary">Заказать услугу</button>
				      </div>	

				</div>
				
			</div>

		</div>

	</div>

</template>