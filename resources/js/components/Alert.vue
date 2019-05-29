<template>

    <div>

        <div class='preloader' id="preloader">
            <div class='loader'>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--text'>{{ text }}</div>
            </div>
        </div>

        <div class="preloader_mask"></div>

    </div>

</template>

<style lang="scss">
    .preloader_mask {
        content: '';
        display: block;
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        background: rgba(0,0,0,.5);
        z-index: 0;
    }

    .preloader {
        z-index:12;
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        font-family: Helvetica;
    }

    .loader {
        height: 20px;
        width: 250px;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
    }
    .loader--dot {
        animation-name: loader;
        animation-timing-function: ease-in-out;
        animation-duration: 3s;
        animation-iteration-count: infinite;
        height: 20px;
        width: 20px;
        border-radius: 100%;
        background-color: black;
        position: absolute;
    }
    .loader--dot:first-child {
        background-color: #8cc759;
        animation-delay: 0.5s;
    }
    .loader--dot:nth-child(2) {
        background-color: #8c6daf;
        animation-delay: 0.4s;
    }
    .loader--dot:nth-child(3) {
        background-color: #ef5d74;
        animation-delay: 0.3s;
    }
    .loader--dot:nth-child(4) {
        background-color: #f9a74b;
        animation-delay: 0.2s;
    }
    .loader--dot:nth-child(5) {
        background-color: #60beeb;
        animation-delay: 0.1s;
    }
    .loader--dot:nth-child(6) {
        background-color: #fbef5a;
        animation-delay: 0s;
    }
    .loader--text {
        position: absolute;
        top: 200%;
        left: 0;
        right: 0;
        width: 4rem;
        margin: auto;
        color: #fff;
        text-transform: uppercase;
    }
    /*.loader--text:after {*/
        /*content: "Loading";*/
        /*font-weight: bold;*/
        /*animation-name: loading-text;*/
        /*animation-duration: 3s;*/
        /*animation-iteration-count: infinite;*/
    /*}*/

    @keyframes loader {
        15% {
            transform: translateX(0);
        }
        45% {
            transform: translateX(230px);
        }
        65% {
            transform: translateX(230px);
        }
        95% {
            transform: translateX(0);
        }
    }

</style>

<script>

    export default {
        data(){
            return {
                text:''
            }
        }
    }

</script>