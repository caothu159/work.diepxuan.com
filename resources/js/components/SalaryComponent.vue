<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            this._initialize();
            console.log('Component mounted.');
        },
        /**
         * Defines the data used by the component
         * @return {[type]} [description]
         */
        data() {
            return {
                nhanvien: [],
                chamcong: [],
                phancong: [],
                nangsuat: []
            }
        },
        methods: {
            _initialize: function() {
                this._loadNhanvien();
            },
            _loadNhanvien: function() {
                // this.nhanvien = this.loadSheet('nhanvien');
                axios.put(window.location.href, {
                        _method: 'PUT',
                        filename: 'nhanvien.xlsx',
                    }).then(function(response) {
                        console.log(response);
                    })
                    .catch(function(response) {
                        console.log(response);
                    });
            },
            loadSheet: function(file) {
                axios.put(window.location.href, {
                        _method: 'PUT',
                        filename: file,
                    }, {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    }).then(function(response) {
                        console.log(response);
                    })
                    .catch(function(response) {
                        console.log(response);
                    });
            }
        }
    }

</script>
