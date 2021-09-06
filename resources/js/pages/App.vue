<template>
    <div id="app" :key="componentKey" v-if="renderComponent">
        <nav class="navbar fixed-left navbar-light navbar-expand-md" style="background-color: #e3f2fd;">
            <router-link v-for="(route, index) in routerindex" :key="index" class="navbar-brand" :to="routepath(route.path)">
                <img alt="logo" src="pwa-icons/windows10/Square150x150Logo.scale-100.png" />
            </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item" v-for="(route, index) in routers" :key="index">
                        <router-link class=" nav-link" :to="routepath(route.path)">
                            {{route.name}}
                        </router-link>
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <router-link class="dropdown-item" v-for="(childroute, childindex) in route.child" :key="childindex" :to="routepath(childroute.path)">
                                    {{childroute.name}}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Middle Side Of Navbar -->
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto"></ul>
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
        console.log(this.$router.getRoutes());
    },
    data() {
        return {
            routers: this.routers(this.$router),
            routerindex: this.$router.getRoutes().filter(function(route) {
                return route.name == 'Index';
            }),
            renderComponent: 1,
            componentKey: 0,
        };
    },
    watch: {},
    methods: {
        routepath: (path) => {
            if (path !== '') {
                return path;
            }
            return 'tonghop';
        },
        routers($router) {
            self = this;
            return $router.getRoutes().filter((route) => {
                return route.parent == undefined;
            }).filter((route) => {
                return route.name !== 'Index';
            }).map(function(route) {
                route.child = self.childrouters($router, route.name);
                if (route.child.length == 0)
                    route.hovered = 1;
                return route;
            });
        },
        childrouters: ($router, parent = undefined) => {
            return $router.getRoutes().filter((route) => {
                return route.parent !== undefined && route.parent.name == parent;
            }).filter((route) => {
                return route.name !== 'Index';
            });
        },
        forceRerender() {
            // Remove my-component from the DOM
            this.renderComponent = 0;

            this.$nextTick().then(() => {
                // Add the component back in
                this.renderComponent = 1;
            });

            this.componentKey += 1;
        },
    },
    computed: {},
    props: {},
};

</script>
