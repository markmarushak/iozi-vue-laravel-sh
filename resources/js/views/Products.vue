<template>
	<div class="row">
		<div class="crud-product col-12">
			
			<div class="row">
				<div class="col-sm-6">
					<h2>Создание анкеты</h2>
				</div>
				<div class="col-sm-6 text-right	">
					<button class="btn btn-success" form="form-product">Создать анкету</button>
				</div>

			</div>

			<form @submit.prevent="submit" id="form-product" class="col-sm-12">

				<div class="row">

					<div class="col-sm-7">
						<h4>Общая информация</h4>
						<div class="row">

							<div class="form-group col-sm-6">
								<label>Полное Имя</label>
								<input type="text" class="form-control" v-model="product.fullname" required>
							</div>

							<div class="form-group col-sm-6">
								<label>Описание</label>
								<textarea v-model="product.description" style="width: 100%" rows="3" class="form-control"></textarea>
							</div>

							<div class="form-group col-sm-6">
								<label>Номер телефона</label>
								<input type="text" class="form-control" v-model="product.phone" required>
							</div>

							<div class="form-group col-sm-6" v-for="attr in product.additional.attributes">
								<label>{{ attr.name }}</label>
								<input v-if="attr.format == 'input'" type="text" class="form-control" v-model="attr.value" required>
								<select v-model="attr.value" v-if="attr.format != 'input'" class="form-control" required>
									<option value=""> выбриете {{ attr.name }}</option>
									<option v-for="op in attr.option" :value="op.name">{{ op.name }}</option>
								</select>
							</div>


							<!-- main info -->

							<div class="col-sm-12">
								<h4>цена и время</h4>
								<div class="row">

									<div class="form-group col-sm-4" v-for="i in product.additional.time">
										<label>{{ i.name }}</label>
										<input type="text" v-model="i.value" class="form-control" required>
									</div>


								</div>

							</div>
							<!-- price and time -->

							<div class="col-sm-12">

								<div class="row">

									<div class="col-sm-4" v-for="(i, index) in images">
										<image-input :image_id="index" @selected="setImages"></image-input>
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


								<label class="checkbox-product-option" v-for="option in product.additional.options">
									<input type="checkbox" v-model="option.value">
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
					additional: {
                        attributes: [],
                        options: [],
                        time: [],
					},
					fullname: '',
					description: '',
					phone: ''
				},
                images: [],
            }
		},
		methods: {

			fetch() {

				axios.get(route('attribute.index',{type: 'option'}))
				.then(response => {
					this.product.additional.options = response.data
				})

				axios.get(route('attribute.index',{type: 'attr'}))
				.then(response => {

					this.product.additional.attributes = response.data
				})

                axios.get(route('attribute.index',{type: 'time'}))
                    .then(response => {
						this.product.additional.time = response.data
				})

                axios.get(route('attribute.index',{type: 'images'}))
                    .then(response => {
					this.images = response.data
				})
			},
			submit () {
			    axios.post(route('products.store'), this.product)
			        .then(response => {
						this.saveFile(response.data.product.id)
            		})
			        .catch(error => {
			        })
			},
			saveFile(product_id){

                const config = { 'content-type': 'multipart/form-data' }
                for(var i in this.images)
				{
                    const formData = new FormData()
                    formData.append('img', this.images[i].value)
					formData.append('attr_id', this.images[i].id)
					formData.append('product_id', product_id)

                    axios.post(route('products.image'), formData	,config)
                        .then(response => console.log(response.data))
                		.catch(error => console.log(error))
				}
				this.$router.push({name: '/'})
            },
			setImages(file)
			{
				this.images[file.index].value = file.file
				console.log(this.images[file.index])
			}
		},
		components: {
			'image-input': Image,
		}
	}

</script>