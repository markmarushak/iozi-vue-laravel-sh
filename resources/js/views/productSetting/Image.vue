<template>

    <div class="">

        <attribute
                title="Фото"
                :isFormat="false"
                type="images"
        ></attribute>

    </div>

</template>

<script>
    import Attribute from '../../components/Attribute'
    export default {
        components: {
            'attribute':Attribute
        }
    }

</script>