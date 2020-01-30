<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                    <div class="card-body">
                        {{ nhanvien }}
                        {{ chamcong }}
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
                    this._loadSheetNhanvien();
                    this._loadSheetChamcong();
                } catch (e) {}
            },
            _loadSheetNhanvien: function() {
                self = this;
                /* set up an async GET request with axios */
                axios('/' + window.location.pathname.split('/').filter(v => v != '').join('/') + '/' + 'nhanvien.xlsx', {
                    responseType: 'arraybuffer'
                }).catch(function(err) {
                    /* error in getting data */
                }).then(function(res) {
                    /* parse the data when it is received */
                    var data = new Uint8Array(res.data);
                    var workbook = XLSX.read(data, {
                        type: "array"
                    });
                    return workbook;
                }).catch(function(err) {
                    /* error in parsing */
                }).then(function(workbook) {
                    window.nhanvienWB = workbook
                    self.nhanvien = XLSX.utils.sheet_to_json(workbook.Sheets.nhanvien);
                });
                /**
                var req = new XMLHttpRequest();
                req.open("GET", '/' + window.location.pathname.split('/').filter(v => v != '').join('/') + '/' + sheetname + '.xlsx', true);
                req.responseType = "arraybuffer";
                req.onload = function(e) {
                    var data = new Uint8Array(req.response);
                    window[sheetname + 'WB'] = XLSX.read(data, {
                        type: "array"
                    });
                    console.log(sheetname + 'WB');
                }
                req.send();
                */
            },
            _loadSheetChamcong: function() {
                self = this;
                /* set up an async GET request with axios */
                axios('/' + window.location.pathname.split('/').filter(v => v != '').join('/') + '/' + 'chamcong.xlsx', {
                    responseType: 'arraybuffer'
                }).catch(function(err) {
                    /* error in getting data */
                }).then(function(res) {
                    /* parse the data when it is received */
                    var data = new Uint8Array(res.data);
                    var workbook = XLSX.read(data, {
                        type: "array"
                    });
                    return workbook;
                }).catch(function(err) {
                    /* error in parsing */
                }).then(function(workbook) {
                    window.chamcongWB = workbook;
                    self.chamcong = XLSX.utils.sheet_to_json(workbook.Sheets.chamcong);
                });
            }
        }
    }

</script>
