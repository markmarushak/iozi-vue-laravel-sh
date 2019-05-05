<template>

	<div class="row">
		
		<div class="col-sm-10">
			
			<div class="products">
				
				<div class="row">
					
					<div class="col-sm-6" v-for="index in 10" :key="index">
						
						<div class="card">
						 <div class="row no-gutters">
						 	 <div class="col-sm-6">
							  	<a href="" data-toggle="modal" data-target="#exampleModal"><img src="https://lamcdn.net/wonderzine.com/post-cover/DQqy_LGgARBSI5JhgAuPjg-default.jpg" class="card-img-top" alt=""></a>
							  </div>
							  <div class="col-sm-6">
							  	<div class="card-body">
							  		<div class="price">
								    	<div>
								    		<span>час</span>
								    		600 $
								    	</div>
								    	<div>
								    		<span>2 часа</span>
								    		1000 $
								    	</div>
								    	<div>
								    		<span>ночь</span>
								    		3000 $
								    	</div>
								    </div>
								    <hr>
								    <h5 class="card-title" >Настя Шлюха</h5>
								    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
								    <a href="#" class="btn btn-primary">Узнать поближе</a>
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
					<h6>массаж</h6>
					<label><input type="checkbox">Классический</label>
					<label><input type="checkbox">Классический</label>
					<label><input type="checkbox">Классический</label>
				</div>
				<div class="form-group">
					<h6>Выезд</h6>
					<label><input type="checkbox">Классический</label>
					<label><input type="checkbox">Классический</label>
					<label><input type="checkbox">Классический</label>
				</div>

				<div class="form-group">
					<h6>аппартаменты</h6>
					<label><input type="checkbox">Классический</label>
					<label><input type="checkbox">Классический</label>
					<label><input type="checkbox">Классический</label>
				</div>
				<div class="form-group"><label>ЭЛИТНЫЕ VIP ДЕВОЧКИ ЭСКОРТ</label></div>
				<div class="form-group"><label>ДЕВУШКИ С ПРОВЕРЕННЫМИ ФОТО</label></div>

			</div>

		</div>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Настя шлюха</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body profile-more-info">
		        <carousel :navigationEnabled="true" :perPage="1">
				  <slide >
				    <img src="https://lamcdn.net/wonderzine.com/post-cover/DQqy_LGgARBSI5JhgAuPjg-default.jpg" class="card-img-top" alt="">
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

	export default {
		
		components: {
		    Carousel,
		    Slide
		  }
	}

</script>