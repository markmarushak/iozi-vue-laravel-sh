<template>

    <div class="">

        <attribute
            title="Опции"
            :isFormat="false"
            type="option"
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