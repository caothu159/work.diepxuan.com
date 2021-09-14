<template>
    <div class="row">
        <!-- <div class="col-12">
            <h3>Bán hàng</h3>
        </div> -->
        <div class="container-fluid">
            <router-view />
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            recipe: {},
            componentKey: null,
        };
    },

    mounted() {},
    methods: {}
};

</script>
