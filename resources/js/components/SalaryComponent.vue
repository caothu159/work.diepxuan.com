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
            console.log('Component mounted.')
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
            loadNhanvien: function() {
                this.nhanvien = this.loadSheet('nhanvien');
                console.log(nhanvien);
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
                    .catch(function() {
                        console.log('FAILURE!!');
                    });
            }
        }
    }

</script>
