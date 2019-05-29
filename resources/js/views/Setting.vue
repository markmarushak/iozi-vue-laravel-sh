<template>
	
	<div class="row">
		
		<div class="col-12">
			<h3>
				Настройки Аккаунта
			</h3>
		</div>

		<form @submit.prevent="account" class="col-sm-12">
			
			<div class="row">
				<div class="form-group col-sm-6">
					<label>
						<span>Имя</span>
					</label>
					<div class="input-group">
						<input type="text" v-model="name" class="form-control">	
						<div class="input-group-append">
							<button class="btn btn-info "><i class="fas fa-sync-alt"></i></button>
						</div>
					</div>

				</div>

				<div class="form-group col-sm-6">
					<label>
						<span>Фаммилия</span>
					</label>
					<div class="input-group">
						<input type="text" v-model="lastname" class="form-control">	
						<div class="input-group-append">
							<button class="btn btn-info "><i class="fas fa-sync-alt"></i></button>
						</div>
					</div>
					
				</div>

				<div class="form-group col-sm-6">
					<label>
						<span>Пароль</span>
					</label>
					<div class="input-group">
						<input type="text" v-model="password" class="form-control">	
						<div class="input-group-append">
							<button class="btn btn-info "><i class="fas fa-sync-alt"></i></button>
						</div>
					</div>
				</div>

				<div class="form-group col-sm-6">
					<label>
						<span>E-mail</span>
					</label>
					<div class="input-group">
						<input type="text" v-model="email" class="form-control">	
						<div class="input-group-append">
							<button class="btn btn-info "><i class="fas fa-sync-alt"></i></button>
						</div>
					</div>
				</div>

			</div>

		</form>

	</div>

</template>