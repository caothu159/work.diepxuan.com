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
                try {
                    this._loadSheet('nhanvien');
                } catch (e) {}
            },
            _loadSheet: function(sheetname) {
                var req = new XMLHttpRequest();
                req.open("GET", '/' + window.location.pathname.split('/').filter(v => v != '').join('/') + '/' + sheetname + '.xlsx', true);
                req.responseType = "arraybuffer";
                req.onload = function(e) {
                    var data = new Uint8Array(req.response);
                    var nhanvienWB = XLSX.read(data, {
                        type: "array"
                    });
                    /* DO SOMETHING WITH nhanvienWB HERE */
                    console.log(nhanvienWB);
                }
                req.send();
            }
        }
    }

</script>
