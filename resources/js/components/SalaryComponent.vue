<template>
    <div class="col-12">
        <div class="row" :key="componentKey">
            <template v-for="nv in nhanvien">
                <div class="col-sm-3 pl-1 pr-1 pt-0 pb-2">
                    <div class="card text-decoration-none collapsed h-100" :id="'heading' + nv.index">
                        <div class="card-header p-2">
                            <span class="card-title text-success font-weight-bold">
                                {{ nv.name }}
                            </span>
                        </div>
                        <div class="card-body p-2">
                            <div class="card-text font-weight-light text-info">
                                <div class="d-flex justify-content-between">
                                    Lương: <span class="text-success font-weight-bold">{{ nv.luong.toFixed(2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    Công:
                                    <a class="font-weight-normal font-weight-bold" data-toggle="collapse" aria-expanded="false" :href="'#collapse' + nv.index" :aria-controls="'collapse' + nv.index">
                                        {{ nv.cong }}
                                    </a>
                                </div>
                                <div class="d-flex justify-content-between">
                                    {{ 'Năng suất:' }}
                                    <a class="font-weight-normal font-weight-bold" data-toggle="collapse" aria-expanded="false" :href="'#collapse' + nv.index" :aria-controls="'collapse' + nv.index">
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
                <div class="col-sm-12 collapse" :id="'collapse' + nv.index" :aria-labelledby="'heading' + nv.index" data-parent="#accordionSalary">
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
                        <tr v-for="congnhat in nv.congnhat">
                            <td>{{ congnhat.thoigian }}</td>
                            <td>{{ congnhat.cong }}</td>
                            <td>{{ '-' }}</td>
                            <td>{{ '-' }}</td>
                            <td>{{ '-' }}</td>
                            <td>{{ '-' }}</td>
                            <td>{{ '-' }}</td>
                            <td>{{ '-' }}</td>
                            <td>{{ '-' }}</td>
                            <td>{{ congnhat.luong.toFixed(2) }}</td>
                        </tr>
                    </table>
                </div>
            </template>
            <!-- {{ nhanvien }} -->
            <!-- {{ chamcong }} -->
        </div>
    </div>
</template>
<script>
    class CongNhat {
        constructor(thoigian, nhanvien) {
            /** primary params */
            this.thoigian = thoigian;
            /** extra params from nhanvien */
            this.luongCoBanTheoNgay = nhanvien.luongCoBanTheoNgay;
            /** cal params */
            this._cong = 0;
            this._phep = 0;
        }
        get cong() {
            let _cong = 0;
            _cong += this._cong || 0;
            _cong += this._phep || 0;
            if (_cong < -1) _cong = -1;
            return _cong;
        }
        set cong(x) {
            this._cong = x || 0;
        }
        get phep() {
            return this.cong;
        }
        set phep(x) {
            this._phep = x || 0;
        }
        get luongCoBan() {
            return this.cong * this.luongCoBanTheoNgay;
        }
        get luongNangSuat() {
            return 0;
        }
        get luong() {
            return this.luongCoBan + this.luongNangSuat;
        }
    }
    class Nhanvien {
        constructor(brand) {
            this.index = brand.__EMPTY.split(' ').join('_').toLowerCase();
            this.name = brand.__EMPTY;
            this.luongCoBan = brand['Luong co ban'];
            this.luongKho = brand['Luong kho'];
            this.chiTieu = brand['Chi tieu'];
            this._congnhat = {};
        }
        get luongCoBanTheoNgay() {
            return this.luongCoBan / 30;
        }
        get cong() {
            self = this;
            let _cong = 0;
            $.each(self._congnhat, function(keycc, congnhat) {
                _cong += congnhat.cong || 0;
            });
            return _cong;
        }
        set cong(x) {}
        get luong() {
            self = this;
            let _luong = 0;
            $.each(self._congnhat, function(keycc, congnhat) {
                _luong += congnhat.luong || 0;
            });
            return _luong;
        }
        set luong(x) {}
        get congnhat() {
            return this._congnhat;
        }
        set congnhat(chamcong) {
            self = this;
            $.each(chamcong, function(keycc, cong) {
                if (undefined == cong.__EMPTY) return;
                self._congnhat[cong.__EMPTY] = self._congnhat[cong.__EMPTY] || new CongNhat(cong.__EMPTY, self);
                self._congnhat[cong.__EMPTY].thoigian = self.getJsDateFromExcel(cong.__EMPTY)
                    .toLocaleDateString('vi-VN', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    }),
                    self._congnhat[cong.__EMPTY].cong = cong[self.name] || 0;
            });
        }
        get nghikhongphep() {
            return this._congnhat;
        }
        set nghikhongphep(nghikhongphep) {
            self = this;
            $.each(nghikhongphep, function(keycc, phep) {
                if (undefined == phep.__EMPTY) return;
                self._congnhat[phep.__EMPTY] = self._congnhat[phep.__EMPTY] || new CongNhat(cong.__EMPTY, self);
                self._congnhat[phep.__EMPTY].thoigian = self.getJsDateFromExcel(phep.__EMPTY)
                    .toLocaleDateString('vi-VN', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    });
                self._congnhat[phep.__EMPTY].phep = phep[self.name] || phep[self.name.toLowerCase()] || 0;
            });
        }
        getJsDateFromExcel(excelDate) {
            return new Date((excelDate - (25567 + 2)) * 86400 * 1000);
        }
    }
    export default {
        mounted() {
            try {
                this._loadSheetNhanvien();
                console.log('mounted');
            } catch (e) {}
        },
        /**
         * Defines the data used by the component
         * @return {[type]} [description]
         */
        data() {
            return {
                componentKey: 0,
                nhanvien: {},
                chamcong: {},
                nghikhongphep: {},
                phancong: {},
                nangsuat: {}
            }
        },
        watch: {
            chamcong: function(newChamcong, oldChamcong) {
                this.importChamcong(newChamcong);
                this.forceRerender();
            },
            nghikhongphep: function(newNghikhongphep, oldNghikhongphep) {
                this.importNghikhongphep(newNghikhongphep);
                this.forceRerender();
            }
        },
        methods: {
            forceRerender() {
                this.componentKey += 1;
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
                    window.nhanvienWB = workbook;
                    $.each(XLSX.utils.sheet_to_json(workbook.Sheets.nhanvien), function(keynv, nv) {
                        self.nhanvien[nv.__EMPTY] = new Nhanvien(nv);
                    });
                    self._loadSheetChamcong();
                });
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
                    self.nghikhongphep = XLSX.utils.sheet_to_json(workbook.Sheets.nghikhongphep);
                    self._loadSheetPhancong();
                });
            },
            _loadSheetPhancong: function() {
                self = this;
                /* set up an async GET request with axios */
                axios('/' + window.location.pathname.split('/').filter(v => v != '').join('/') + '/' + 'phancong.xlsx', {
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
                    window.phancongWB = workbook;
                    self.phancong = XLSX.utils.sheet_to_json(workbook.Sheets.phancong);
                    console.log(self.phancong);
                });
            },
            importChamcong: function(chamcong) {
                self = this;
                $.each(self.nhanvien, function(keynv, nv) {
                    nv.congnhat = chamcong;
                    return nv;
                });
            },
            importNghikhongphep: function(nghikhongphep) {
                self = this;
                $.each(self.nhanvien, function(keynv, nv) {
                    nv.nghikhongphep = nghikhongphep;
                    return nv;
                });
            }
        }
    }

</script>
