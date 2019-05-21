<template>

    <div class="">

        <attribute
                title="Атрибут"
                :isFormat="true"
                type="attr"
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