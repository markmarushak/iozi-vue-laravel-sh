<template>

	<div class="row">

		<div class="col-sm-10">
			
			<div class="products">
				
				<div class="row">
					
					<div class="col-sm-6" v-for="product in products">
						<div class="card">
						 <div class="row no-gutters">
						 	 <div class="col-sm-6">
								 <a v-if="product.images != ''" data-toggle="modal" data-target="#exampleModal" @click="modals = product.images">
									 <img v-bind:src="'public/storage/'+ product.images[0].value" class="card-img-top">
								 </a>
								 <a v-if="product.images == ''" @click="modals = product.images">
									 <img src="public/img/notFound.png" class="card-img-top" alt="test">
								 </a>
							  </div>
							  <div class="col-sm-6">
							  	<div class="card-body">
							  		<div class="price">
								    	<div v-for="time in product.time">
								    		<span>{{ time.name }}</span>
								    		{{ time.value }} $
								    	</div>
								    </div>
								    <hr>
								    <h5 class="card-title" >{{ product.fullname }}</h5>
								    <p class="card-text">{{ product.description }}</p>
								    <a href="#" class="btn btn-primary">Узнать </a>
								  </div>
								</div>
							  </div>
						 </div>
						 <br>

					</div>

				</div>

			</div>

		</div>

		<div class="filter">
			<div class="form">
				<h5> Расширенный поиск</h5>
				<div class="form-group">
					<label v-for="fil in filter"><input type="checkbox" v-model="fil.value">{{ fil.name }}</label>
				</div>

			</div>

		</div>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel"> </h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body profile-more-info">
		        <carousel :navigationEnabled="true" :perPage="1">
				  <slide v-for="modal in modals" :key="modal.id">
				    <img v-bind:src="'public/storage/' + modal.value" class="card-img-top" alt="">
				  </slide>
				</carousel>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary">Save changes</button>
		      </div>
		    </div>
		  </div>
		</div>

	</div>

</template>

<script>
	
	import { Carousel, Slide } from 'vue-carousel';
	import axios from 'axios'

	export default {
		data(){
			return {
                products: [],
				filter: [],
				modals: '123123',
				user_id: ''
            }
		},
		methods: {
		    fetchProduct()
			{
			    axios.get(route('products.index'))
					.then(res => {
					    this.products = res.data
				})
			},
		},
		mounted() {
		    this.fetchProduct()
            axios.get(route('attribute.index', {type: 'option'}))
                .then(res => {
                	this.filter = res.data
        		});
		},
		components: {
		    Carousel,
		    Slide
		  }
	}

</script>