<template>
	<div class="row">

		<div class="crud-product col-sm-12">
			
			<h2>Создание анкеты</h2>
			<hr>
			
			<form @submit.prevent="productCreate" class="col-sm-12">
				<div class="row">
					
					<div class="col-sm-7">
						<h4>Общая информация</h4>
						<div class="row">
							
							<div class="form-group col-sm-6">
								<label>Имя (Настя Шлюха)</label>
								<input type="text" v-model="name" class="form-control">
							</div>

							<div class="form-group col-sm-6">
								<label>Возраст</label>
								<input type="text" v-model="name" class="form-control">
							</div>

							<div class="form-group col-sm-6">
								<label>Рост</label>
								<input type="text" v-model="name" class="form-control">
							</div>

							<div class="form-group col-sm-6">
								<label>Вес</label>
								<input type="text" v-model="name" class="form-control">
							</div>

							<div class="form-group col-sm-6">
								<label>Размер груди</label>
								<input type="text" v-model="name" class="form-control">
							</div>

							<!-- main info -->

							<div class="col-sm-12">
								<h4>цена и время</h4>
								<div class="row">
									
									<div class="form-group col-sm-4">
										<label>час</label>
										<input type="text" v-model="name" class="form-control">
									</div>

									<div class="form-group col-sm-4">
										<label>2 час</label>
										<input type="text" v-model="name" class="form-control">
									</div>

									<div class="form-group col-sm-4">
										<label>ночь</label>
										<input type="text" v-model="name" class="form-control">
									</div>

								</div>

							</div>
							<!-- price and time -->



						</div>

					</div>

					

				</div>
				

			</form>

		</div>

		<div class="col-sm-12">
			<div class="row">
				
				<div class="col-sm-4" v-for="index in 5">
					<image-input image-src=""></image-input>
				</div>

			</div>
		</div>
		
		<div class="col-sm-12">
			
			<table>
				
			</table>

		</div>

	</div>
</template>

<script>
	
	import Image  from '../components/Image.vue'
	import axios from 'axios'

	export default {
		data() {
			return {
				name: ''
			}
		},
		methods: {

			uploadImage(event) {

			    let data = new FormData();
			    data.append('name', 'my-picture');
			    data.append('file', event.target.files[0]); 

			    let config = {
			      header : {
			        'Content-Type' : 'image/png'
			      }
			    }

			    console.log(data)

			    // axios.post(
			    //   'products/', 
			    //   data,
			    //   config
			    // ).then(
			    //   response => {
			    //     console.log('image upload response > ', response)
			    //   }
			    // )
			  }

		},
		components: {
			'image-input': Image
		}
	}

</script>