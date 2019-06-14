<template>

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

                            <div class="row">

                                <div class="col-sm-4 col">
                                    <h3>Инструкция по Загрузке фото: </h3>
                                    <ul>
                                        <li>Фото девушшки</li>
                                        <li>в полный рост</li>
                                        <li>с листком возле лица с датой отправки фото</li>
                                    </ul>
                                </div>

                                <div class="col">
                                    <image-input @selected="setImages"></image-input>
                                </div>

                            </div>

                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-info" @click="$emit('close')">
                                закрыть
                            </button>

                            <button class="btn btn-success" @click="submit()">Отправить на проверку</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>

</template>

<script>

    import Image  from '../../components/Image.vue'
    import axios from 'axios'

    export default {
        props: ['product'],
        data() {
            return {
                img: ''
            }
        },
        methods: {
            submit(){

                const config = { 'content-type': 'multipart/form-data' }
                const formData = new FormData()
                formData.append('img', this.img)
                formData.append('id', this.product.id)

                axios.post(route('products.confirm'), formData ,config)
                    .then(response => console.log(response.data))
                    .catch(error => console.log(error))

                this.$emit('close')

            },
            setImages(file)
            {
                this.img = file.file
            }
        },
        components: {
            'image-input': Image,
        }
    }

</script>