<template id="image-input-template">
    <div class="Image-input">
         <div class="Image-input__input-wrapper">
            <i v-show="! imageSrc" class="fas fa-plus"></i>
            <i v-show="imageSrc" class="fas fa-retweet"></i>
            <input @change="previewThumbnail" class="Image-input__input" name="thumbnail" type="file">
        </div>
        <div class="Image-input__image-wrapper">
            <i v-show="! imageSrc" class="icon fa fa-picture-o"></i>
            <img v-show="imageSrc" class="Image-input__image" :src="imageSrc">
        </div>

       
    </div>
</template>

<style>
    
.Image-input {
    display: flex;
    flex-direction: column;
    box-shadow: 0 0 1px 1px #aaa;
    margin-bottom: 10px;
}

.Image-input__image-wrapper {
    flex-basis: 80%;
    height: 150px;
    flex: 2.5;
    border-radius: 1px;
    overflow-y: hidden;
    border-radius: 1px;
    background: #eee;
    justify-content: center;
    align-items: center;
    display: flex;
}

.Image-input__image-wrapper > .icon {
    color: #fff;
    font-size: 50px;
    cursor: default;
}

.Image-input__image {
    max-width: 100%;
    border-radius: 1px;
}

.Image-input__input-wrapper {
    overflow: hidden;
    position: relative;
    background: #17a2b8;
    border-radius: 1px;
    float: left;
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    color: rgba(0,0,0,0.2);
    transition: 0.4s background;
}

.Image-input__input-wrapper:hover {
    background: #e0e0e0;
}


.Image-input__input {
    cursor: inherit;
    display: block;
    font-size: 999px;
    min-height: 100%;
    opacity: 0;
    position: absolute;
    right: 0;
    text-align: right;
    top: 0;
    cursor: pointer;
}

</style>

<script>
    
    import axios from 'axios'

    export default {


        props: ['index'],
        data(){
            return {
                imageSrc: ''
            }
        },
        methods: {
            previewThumbnail: function(event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    var vm = this;
                    reader.onload = function(e) {
                        vm.imageSrc = e.target.result;
                    }

                    reader.readAsDataURL(input.files[0]);
                    this.$emit("image", {file: input.files[0], index: vm.index})
                }
            },
        }

    }

</script>