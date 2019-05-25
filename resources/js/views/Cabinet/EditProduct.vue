<template>

    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

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

                                            <div class="form-group col-sm-6" v-for="(attr, index) in newProduct.additional.attributes">
                                                <label>{{ attr.name }}</label>
                                                <input v-if="attr.format == 'input' && typeof product.attr[index].value === 'undefined'" type="text" class="form-control" v-model="attr.value" required>
                                                <input v-if="attr.format == 'input' && typeof product.attr[index].value != 'undefined'" type="text" class="form-control" v-model="attr.value = product.attr[index].value" required>
                                                <select v-model="attr.value" v-if="attr.format != 'input'" class="form-control" required>
                                                    <option value=""> выбриете {{ attr.name }}</option>
                                                    <option v-for="op in attr.option" :value="op.name">{{ op.name }}</option>
                                                </select>
                                            </div>


                                            <!-- main info -->

                                            <div class="col-sm-12">
                                                <h4>цена и время</h4>
                                                <div class="row">

                                                    <div class="form-group col-sm-4" v-for="(i, index) in newProduct.additional.time">
                                                        <label>{{ i.name }}</label>
                                                        <input v-if="typeof product.time[index].value === 'undefined'" type="text" v-model="i.value" class="form-control" required>
                                                        <input v-if="typeof product.time[index].value != 'undefined'" type="text" v-model="i.value" class="form-control" required>
                                                    </div>


                                                </div>

                                            </div>
                                            <!-- price and time -->

                                            <div class="col-sm-12">

                                                <div class="row">

                                                    <div class="col-sm-4" v-for="(i, index) in images">
                                                        <image-input v-if="typeof product.images[index].value != 'undefined'" :image="'public/storage/' + product.images[index].value" :image_id="index" @selected="setImages"></image-input>
                                                        <image-input v-if="typeof product.images[index].value === 'undefined'" :image_id="index" @selected="setImages"></image-input>
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


                                                <label class="checkbox-product-option" v-for="(option, index) in newProduct.additional.options">
                                                    <input v-if="typeof typeof product.option[index].value === 'undefined'" type="checkbox" v-model="newProduct.option.value">
                                                    <input v-else type="checkbox" v-model="newProduct.option.value = product.option[index]">
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
                options: [],

                newProduct :{
                    additional: {
                        attributes: [],
                        options: [],
                        time: [],
                    },
                    fullname: this.product.fullname,
                    description: this.product.description
                },
                images: [],
                load: false
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
                        this.newProduct.additional.attributes = response.data
                })

                axios.get(route('attribute.index',{type: 'time'}))
                    .then(response => {
                    this.newProduct.additional.time = response.data
                })

                axios.get(route('attribute.index',{type: 'images'}))
                    .then(response => {
                    this.images = response.data
                })
            },
            submit () {
                this.load = true
                notific.text = 'Сохранение информации'
                axios.post(route('products.store'), this.product)
                    .then(response => {
                    this.saveFile(response.data.product.id)
                })
            .catch(error => {
                    this.load = false
                })
            },
            saveFile(product_id){
                notific.text = 'Сохранение информации'

                const config = { 'content-type': 'multipart/form-data' }
                for(var i in this.images)
                {
                    console.log(product_id)
                    const formData = new FormData()
                    formData.append('img', this.images[i].value)
                    formData.append('attr_id', this.images[i].id)
                    formData.append('product_id', product_id)

                    axios.post(route('products.image'), formData	,config)
                        .then(response => console.log(response.data))
                .catch(error => console.log(error))
                }

                this.load = false

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