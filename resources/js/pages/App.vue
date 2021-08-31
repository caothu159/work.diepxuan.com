<template>
    <div id="app">
        <nav class="navbar navbar-light text-success navbar-expand-md">
            <div class="container-fluid">
                <router-link v-for="(route, index) in routerindex" :key="index" class="nav-link" :to="routepath(route.path)">
                    <img alt="logo" src="favicon.png" />
                </router-link>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item" v-for="(route, index) in routers" :key="index">
                            <router-link class="nav-link" :to="routepath(route.path)" v-html="route.name" v-if="route.name != 'Index'"></router-link>
                        </li>
                    </ul>

                    <!-- Middle Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto"></ul>
                </div>
            </div>
        </nav>
        <main class="container-fluid">
            <router-view />
        </main>
    </div>
</template>

<script>
export default {
    name: 'App',
    mounted() {
        // console.log(router.getRoutes());
        // console.log(this.$router.getRoutes());
    },
    data() {
        return {
            routers: this.$router.getRoutes(),
            routerindex: this.$router.getRoutes().filter(function (route) {
                return route.name == 'Index';
            }),
        };
    },
    watch: {},
    methods: {
        routepath: (path) => {
            if (path !== '') {
                return path;
            }
            return 'index.html';
        },
    },
    computed: {},
    props: {},
};
</script>
