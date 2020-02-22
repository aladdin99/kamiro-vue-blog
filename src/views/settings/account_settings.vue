<template>
    <div class="setting">
        <navigationBar></navigationBar>
    </div>
</template>

<script>
    import navigationBar from "components/navigationBar.vue";
    export default {
        name: "managing",
        components: {
            navigationBar
        },
        data(){
            return{

            }
        },
        methods:{

        },

    }
</script>

<style lang="less">
    .setting{display: inline-block;width: 100%; background-color: #f5f6f7;

    }
</style>