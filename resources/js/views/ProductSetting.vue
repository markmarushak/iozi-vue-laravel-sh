<template>

    <div class="row bg-white">

       <div class="col-12">
           <ul class="nav  nav-pills">
               <li class="nav-item">
                   <router-link class=" btn btn-outline-dark" :to="{ name: 'attribute' }">Атрибуты</router-link>
               </li>
               <li class="nav-item">
                   <router-link class=" btn btn-outline-dark" :to="{ name: 'option' }">Услуги</router-link>
               </li>
               <li class="nav-item">
                   <router-link class=" btn btn-outline-dark" :to="{ name: 'time' }">Время</router-link>
               </li>
               <li class="nav-item">
                   <router-link class=" btn btn-outline-dark" :to="{ name: 'image' }">Картинки</router-link>
               </li>
           </ul>
       </div>

        <div class="col-sm-12">

            <attribute v-if="$router.currentRoute.name == 'product-settings'"></attribute>
            <router-view></router-view>


        </div>

    </div>

</template>

<script>

    import attribute from './productSetting/Attribute'

    export default {
        components: {
            'attribute': attribute
        }
    }

</script>