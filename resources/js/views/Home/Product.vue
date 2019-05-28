<template>
    <div class="row">
        {{ product }}
        <h1>Product 1</h1>
        <p><i>{{ name }}</i> <b> {{ family }} </b></p>
    </div>
</template>

<script>

    export default {
        props: ['product'],
        data() {
            return {
                name: 'Mark',
                family: 'Dolbaeb scuka'
            }
        }
    }

</script>