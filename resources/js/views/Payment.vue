<template>
	
	<div class="row">
		
		<h3>Оплата проходит через систему гарант</h3>
		

	</div>

</template>

<script>

	import axios from 'axios'	

	export default {
		data(){
			return {
				content: ''
			}
		},
		mounted()
		{
			// axios.get(route('payment.show'))
			// .then(response => {
			// 	console.log(response)
			// 	this.content = response.data
			// })
			// $.ajax({
			// 	url: route('payment.show'),
			// 	method: 'get',
			// 	dataType: 'html',
			// 	headers: {
		 //        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		 //        },
			// }).done(function(response){
			// 	$('#payment').html(response)
			// })
		}
	}

</script>