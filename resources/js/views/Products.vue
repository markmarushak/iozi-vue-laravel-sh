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
							
							<div class="form-group col-sm-6" v-for="attr in product.attributes">
								<label>{{ attr.name }}</label>
								<input v-if="attr.type == 'input'" type="text" class="form-control" v-model="attr.value">
								<select v-model="attr.value" v-if="attr.type != 'input'" class="form-control">
									<option v-for="op in attr.option" v-bind:value="op.id">{{ op.name }}</option>
								</select>
							</div>

							
							<!-- main info -->

							<div class="col-sm-12">
								<h4>цена и время</h4>
								<div class="row">
									
									<div class="form-group col-sm-4">
										<label>час</label>
										<input type="text" v-model="product.time.one" class="form-control">
									</div>

									<div class="form-group col-sm-4">
										<label>2 час</label>
										<input type="text" v-model="product.time.two" class="form-control">
									</div>

									<div class="form-group col-sm-4">
										<label>ночь</label>
										<input type="text" v-model="product.time.night" class="form-control">
									</div>

								</div>

							</div>
							<!-- price and time -->

							<div class="col-sm-12">

								<div class="row">
									
									<div class="col-sm-4" v-for="i in product.images">
										<image-input imageSrc="" @selected="setImages"></image-input>
									</div>

								</div>
							</div>

						</div>

					</div>

					<div class="col-sm-5">
						
						<h4>Выберите услуги</h4>
						<hr>

						<div class="row">
							
							<div class="col-sm-12 wrap-product-option">
								

								<label class="checkbox-product-option" v-for="option in product.options">
									<input type="checkbox">
									<span class="text">{{ option.name }}</span>
									<span></span>
								</label>

							</div>

						</div>

					</div>

					

				</div>
				

			</form>

		</div>

		
		
	</div>
</template>

<style lang="scss">

.wrap-product-option {
	overflow-y: auto;
	max-height: 100vh;
}

.checkbox-product-option {
	display: block;
	border-radius: 10px;
	overflow: hidden;
	margin: 5px 0;
	padding: 7px 0;
	position: relative;
	border: 1px dotted #28a745;

	input {
		visibility: hidden
	}

	input:checked + .text {
		position: relative;
		z-index: 2;
		color: #fff;
	}

	input:checked + .text + span {
	    background: rgba(23, 162, 184, 0.64);
	    width: 100%;
	    display: block;
	    height: 100%;
	    position: absolute;
	    top: 0;
	    left: 0;
	    z-index: 1;
	}

	.off, .on {
		position: absolute;
		right: 10px;
		top: 0;
	}
	.on{color: green}
	.off{color: red}	
}

</style>

<script>
	
	import Image  from '../components/Image.vue'
	import axios from 'axios'

	export default {
		mounted(){
			this.fetch()
		},
		data() {
			return {
				product :{
					attributes: [],
					options: [],
					time: {
						one:'',
						two:'',
						night:''
					},
					images: {
						0: {
							data: ''
						},
						1: {
							data: ''
						},
						2: {
							data: ''
						},
						3: {
							data: ''
						},
						4: {
							data: ''
						},
						
					},
				}
			}
		},
		methods: {
			fetch() {
				axios.get(route('option.index'))
				.then(response => {
					this.product.options = response.data
				})

				axios.get(route('attribute.index'))
				.then(response => {
					console.log(response.data)

					this.product.attributes = response.data
				})
			},
			submit () {
			    const config = { 'content-type': 'multipart/form-data' }
			    const formData = new FormData()
			    formData.append('product', this.product)

			    axios.post(route('products.store'), formData, config)
			        .then(response => console.log(response.data.message))
			        .catch(error => console.log(error))
			},
			setImages(file)
			{
				console.log(target.value);
				console.log(file);
			}
		},
		components: {
			'image-input': Image
		}
	}

</script>