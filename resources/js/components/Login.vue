<template>
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Вход в кабинет</h5>
            <form class="form-signin" @submit.prevent="login" method="post">
              <div class="form-label-group">
                <label for="inputEmail">Email address</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus v-model="data.body.email">
              </div>

              <div class="form-label-group">
                <label for="inputPassword">Password</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required v-model="data.body.password">
              </div>

              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input"  v-model="data.rememberMe" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember password</label>
              </div>

              <button class="btn btn-success btn-block" type="submit">Войти</button>
            </form>
            <br>
            <router-link class="btn btn-block btn-info" :to="{ name: 'register' }">Регистрация</router-link>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
   export default {
        data() {
            return {
                context: 'login context',
                data: {
                    body: {
                        email: 'test@gmail.com',
                        password: '123456'
                    },
                    rememberMe: false,
                },
                error: null
            };
        },
        mounted() {
            console.log(this.$auth.redirect());
        },
        methods: {
            login() {
                this.$auth.login({
                    params: {
                      email: this.data.body.email,
                      password: this.data.body.password
                    }, 
                    success: function () {},
                    error: function () {},
                    rememberMe: true,
                    redirect: '/cabinet',
                    fetchUser: true,
                });       
            }

        }
    }
</script>