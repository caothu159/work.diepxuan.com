<template>
    <div class="row">
        <div class="col-sm-3 pl-1 pr-1 pt-0 pb-2" v-for="(nv, index) in nhanvien">
            <div class="card text-decoration-none collapsed h-100" :id="'heading' + index">
                <div class="card-header p-2">
                    <span class="card-title text-success font-weight-bold">
                        {{ nv.__EMPTY }}
                    </span>
                </div>
                <div class="card-body p-2">
                    <div class="card-text font-weight-light text-info">
                        <div class="d-flex justify-content-between">
                            Lương: <span class="text-success font-weight-bold">{{ }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            Công:
                            <a class="font-weight-normal font-weight-bold" data-toggle="collapse" aria-expanded="false" :href="'#collapse' + index" :aria-controls="'collapse' + index">
                                {{ nv.cong }}
                            </a>
                        </div>
                        <div class="d-flex justify-content-between">
                            {{ 'Năng suất:' }}
                            <a class="font-weight-normal font-weight-bold" data-toggle="collapse" aria-expanded="false" :href="'#collapse' + index" :aria-controls="'collapse' + index">
                                <!-- {{ number_format($salary->turnover, 2) }}
                                @if ($salary->productivity!=0 && isset($controller) && $controller->isAdmin())
                                <span class="font-weight-lighter">
                                    /{{ number_format($salary->chitieu, 2) }}
                                </span>
                                @endif -->
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 collapse" v-for="(nv, index) in nhanvien" :id="'collapse' + index" :aria-labelledby="'heading' + index" data-parent="#accordionSalary">
            <table class="table table-hover table-condensed table-sm text-center">
                <tr>
                    <th></th>
                    <th>công</th>
                    <th></th>
                    <th>Doanh số</th>
                    <th>Cho nợ</th>
                    <th>Thu nợ</th>
                    <th>Tỉ lệ</th>
                    <th>Năng suất</th>
                    <th>Hệ số</th>
                    <th>Lương</th>
                </tr>
                <tr v-for="($cong, $time) in nv.chamcong">
                    <td>{{ $time }}</td>
                    <td>{{ $cong }}</td>
                    <td>{{ '-' }}</td>
                    <td>{{ '-' }}</td>
                    <td>{{ '-' }}</td>
                    <td>{{ '-' }}</td>
                    <td>{{ '-' }}</td>
                    <td>{{ '-' }}</td>
                    <td>{{ '-' }}</td>
                    <td>{{ '-' }}</td>
                </tr>
            </table>
        </div>
        {{ nhanvien }}
        {{ chamcong }}
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
        watch: {
            chamcong: function(newChamcong, oldChamcong) {
                this.importChamcong(newChamcong)
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
            },
            importChamcong: function(chamcong) {
                $.each(this.nhanvien, function(keynv, nv) {
                    nv.chamcong = {};
                    nv.cong = 0;
                    $.each(chamcong, function(keycc, chamcong) {
                        if (undefined == chamcong.__EMPTY) return;
                        nv.chamcong[chamcong.__EMPTY] = chamcong[nv.__EMPTY];
                        nv.cong += chamcong[nv.__EMPTY];
                    });
                });
            }
        }
    }

</script>
