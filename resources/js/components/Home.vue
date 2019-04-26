<template>
	<div>
		<h1>Первое приложение!</h1>
	      <p>
	        <!-- используем компонент router-link для навигации -->
	        <!-- входной параметр `to` определяет URL для перехода -->
	        <!-- `<router-link>` по умолчанию отображается тегом `<a>` -->
	        <router-link to="/foo">Перейти к Foo</router-link>
	        <router-link to="/bar">Перейти к Bar</router-link>
	      </p>
      <!-- отображаем тут компонент, для которого совпадает маршрут -->
      <router-view></router-view>
	</div>
</template>

<script>

    export default {
	  computed: {
	    username () {
	      // Мы скоро разберём что такое `params`
	      return this.$route.params.username
	    }
	  },
	  methods: {
	    goBack () {
	      window.history.length > 1
	        ? this.$router.go(-1)
	        : this.$router.push('/')
	    }
	  }
	}

</script>