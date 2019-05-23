<template>

    <div class="">

        <attribute
                title="Время"
                :isFormat="false"
                type="time"
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