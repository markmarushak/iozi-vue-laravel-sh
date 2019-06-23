a<template>

    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container text-black">

                    <div class="modal-header">
                        <slot name="header">
                            {{ product.fullname}}
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">

                            <form @submit.prevent="submit" id="form-product" class="col-sm-12">

                                <div class="row">

                                    <div class="col-sm-7">
                                        <h4>Общая информация</h4>
                                        <div class="row">

                                            <div class="form-group col-sm-6">
                                                <label>Полное Имя</label>
                                                <input type="text" class="form-control" v-model="newProduct.fullname" required>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label>Описание</label>
                                                <textarea v-model="newProduct.description" style="width: 100%" rows="3" class="form-control"></textarea>
                                            </div>

                                            <div class="form-group col-sm-6" v-for="(attr, index) in newProduct.additional.attr">
                                                <label>{{ attr.name }}</label>
                                                <input v-if="typeof list('attr')[index] == 'undefined'" type="text" class="form-control" v-model="attr.value" required>
                                                <input v-if="typeof list('attr')[index] != 'undefined'" type="text" class="form-control" v-model="attr.value = list('attr')[index].value" required>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label>Номер телефона</label>
                                                <input type="text" class="form-control" v-model="product.phone" required>
                                            </div>


                                            <!-- main info -->

                                            <div class="col-sm-12">
                                                <h4>цена и время</h4>
                                                <div class="row">

                                                    <div class="form-group col-sm-4" v-for="(i, index) in newProduct.additional.time">
                                                        <label>{{ i.name }}</label>
                                                        <input v-if="typeof list('time')[index] == 'undefined'" type="text" v-model="i.value" class="form-control" required>
                                                        <input v-if="typeof list('time')[index] != 'undefined'" type="text" v-model="i.value = list('time')[index].value" class="form-control" required>
                                                    </div>


                                                </div>

                                            </div>
                                            <!-- price and time -->

                                            <div class="col-sm-12">

                                                <div class="row">

                                                    <div class="col-sm-4" v-for="(i, index) in images">
                                                        <image-input v-if="typeof product.images[index] != 'undefined'" :image="assets(product.images[index].value)" :image_id="index" @selected="setImages"></image-input>
                                                        <image-input v-if="typeof product.images[index] == 'undefined'" :image_id="index" @selected="setImages"></image-input>
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


                                                <label class="checkbox-product-option" v-for="(option, index) in listOption">
                                                    <input type="checkbox" v-model="option.value" :value="option.value">
                                                    <span class="text">{{ option.name }}</span>
                                                    <span></span>
                                                </label>

                                            </div>

                                        </div>

                                    </div>



                                </div>


                            </form>

                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-info" @click="$emit('close')">
                                закрыть
                            </button>
                            <button class="btn btn-info" @click="submit()">
                                Сохранить изменения
                            </button>
                        </slot>
                    </div>

                </div>
            </div>
        </div>
    </transition>

</template>

<script>

    import axios from 'axios'
    import Image  from '../../components/Image.vue'

    export default {

        props: [
            'product'
        ],
        mounted()
        {
            this.fetch()
        },
        data(){
            return {
                newProduct :{
                    id: this.product.id,
                    additional: {
                        attr: [],
                        options: [],
                        time: [],
                    },
                    fullname: this.product.fullname,
                    description: this.product.description,
                    phone: this.product.phone
                },
                images: [],

            }
        },
        methods: {
            fetch() {
                axios.get(route('attribute.index',{type: 'option'}))
                    .then(response => {
                    this.newProduct.additional.options = response.data
                })

                axios.get(route('attribute.index',{type: 'attr'}))
                    .then(response => {
                        this.newProduct.additional.attr = response.data
                })

                axios.get(route('attribute.index',{type: 'time'}))
                    .then(response => {
                    this.newProduct.additional.time = response.data
                })

                this.fetchImg()
            },
            fetchImg(){
                axios.get(route('attribute.index',{type: 'images'}))
                    .then(response => {
                        this.images = response.data
                })
            },
            submit () {
                axios.put(route('products.update'), this.newProduct)
                    .then(response => {
                })
            .catch(error => {
                })
            },
            saveFile(index){
                let images = this.images
                const config = { 'content-type': 'multipart/form-data' }
                const formData = new FormData()
                formData.append('img', images[index].value)
                formData.append('attr_id', images[index].id)
                formData.append('id', this.product.id)

                if(!!(index in this.product.images)){
                    formData.append('old', this.product.images[index].old)
                }

                axios.post(route('products.image.upload'), formData	,config)
                    .then(response => {
                        if(response.data.old){
                            console.log(response.data.old)
                            this.product.images[index] = {old: response.data.old}
                        }
                        console.log(response.data)
                    })
                    .catch(error => console.log(error))
            },
            setImages(file)
            {
                this.images[file.index].value = file.file
                this.saveFile(file.index)
            },
            list(name) {
                let op = this.product[name]
                let vars = this.newProduct.additional[name]
                try {
                    return vars.filter(function(attr) {
                        var i = 0
                        while(i < op.length ){
                            if(attr.id == op[i].attribute_id){
                                attr.value = op[i].value
                                return attr
                            }
                            i++
                        }

                        return option
                    })
                }catch (error){
                    console.log(name)
                }
            }
        },
        computed: {
            listOption(){
                let op = this.product.options
                let options = this.newProduct.additional.options
                return options.filter(function(option) {
                    var i = 0
                    while(i < op.length ){
                        if(option.id == op[i].attribute_id){
                            option.value = true
                            return option
                        }
                        i++
                    }
                    return option
                })
            },



        },
        components: {
            'image-input': Image,
        }


    }

</script>