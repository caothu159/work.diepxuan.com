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
                // filename: 'nhanvien.xlsx',
                var url = window.location.href + 'nhanvien.xlsx';
                /* set up async GET request */
                var req = new XMLHttpRequest();
                req.open("GET", url, true);
                req.responseType = "arraybuffer";
                req.onload = function(e) {
                    var data = new Uint8Array(req.response);
                    var workbook = XLSX.read(data, {
                        type: "array"
                    });
                    /* DO SOMETHING WITH workbook HERE */
                    console.log(workbook);
                }
                req.send();
            },
            loadSheet: function(file) {
                axios.put(window.location.href, {
                        _method: 'PUT',
                        filename: file,
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
