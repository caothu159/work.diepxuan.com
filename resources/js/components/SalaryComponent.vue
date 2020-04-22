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
                                        {{ nv.nangsuat }}
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
                            <td>{{ congnhat.cong||'-' }}</td>
                            <td>{{ congnhat.kho||'-' }}</td>
                            <td>{{ congnhat.doanhso||'-' }}</td>
                            <td>{{ congnhat.chono||'-' }}</td>
                            <td>{{ congnhat.thuno||'-' }}</td>
                            <td>{{ congnhat.tile||'-' }}</td>
                            <td>{{ congnhat.nangsuat||'-' }}</td>
                            <td>{{ congnhat.heso||'-' }}</td>
                            <td>{{ congnhat.luong.toFixed(2)||'-' }}</td>
                        </tr>
                    </table>
                </div>
            </template>
        </div>
    </div>
</template>
<script>
    class Phancong {
        constructor(phancong, name) {
            let self = this;
            if (typeof self !== typeof phancong)
                return;
            self.thoigian = self.getJsDateFromExcel(phancong.__EMPTY);
            phancong.forEach(function(nv, xe) {
                if (typeof nv !== 'string')
                    return;
                nv = nv.split('-');
                if (nv.indexOf(name) > -1) {
                    self.xe = xe.replace(/^x/gi, 'xe ');
                    self.laixe = nv;
                }
            });
        }
        getJsDateFromExcel(excelDate) {
            return new Date((excelDate - (25567 + 2)) * 86400 * 1000);
        }
    }
    class CongNhat {
        constructor(thoigian, nhanvien) {
            /** primary params */
            this.thoigian = thoigian;
            /** extra params from nhanvien */
            this.luongCoBanTheoNgay = nhanvien.luongCoBanTheoNgay;
            /** cal params */
            this._cong = 0;
            this._phep = 0;
            this.heso = 0;
            this.nangsuat = 0;
            this.chitieu = 0;
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
            return this.heso * this.chitieu || 0;
        }
        get luong() {
            return this.luongCoBan + this.luongNangSuat || 0;
        }
    }
    class Nhanvien {
        constructor(brand) {
            this.index = brand.__EMPTY.split(' ').join('_').toLowerCase();
            this.name = brand.__EMPTY;
            this.luongCoBan = brand['Luong co ban'];
            this.luongKho = brand['Luong kho'];
            this.chiTieu = brand['Chi tieu'];
            this.heSo = {};
            this._congnhat = {};
            let self = this;
            brand.forEach(function(heso, muctieu) {
                if (!isFinite(muctieu)) return;
                if (!isFinite(heso)) return;
                if (heso === 0) return;
                self.heSo[muctieu * 1000] = heso;
            });
        }
        get luongCoBanTheoNgay() {
            return this.luongCoBan / 30;
        }
        /**
         * cong
         */
        get cong() {
            let self = this;
            let _cong = 0;
            $.each(self._congnhat, function(keycc, congnhat) {
                _cong += congnhat.cong || 0;
            });
            return _cong;
        }
        set cong(x) {}
        /**
         * luong
         */
        get luong() {
            let self = this;
            let _luong = 0;
            $.each(self._congnhat, function(keycc, congnhat) {
                _luong += congnhat.luong || 0;
            });
            return _luong;
        }
        set luong(x) {}
        /**
         * congnhat
         */
        get congnhat() {
            return this._congnhat;
        }
        set congnhat(chamcong) {
            let self = this;
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
            let self = this;
            $.each(nghikhongphep, function(keycc, phep) {
                if (undefined == phep.__EMPTY) return;
                self._congnhat[phep.__EMPTY] = self._congnhat[phep.__EMPTY] || new CongNhat(phep.__EMPTY, self);
                self._congnhat[phep.__EMPTY].thoigian = self.getJsDateFromExcel(phep.__EMPTY)
                    .toLocaleDateString('vi-VN', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    });
                self._congnhat[phep.__EMPTY].phep = phep[self.name] || phep[self.name.toLowerCase()] || 0;
            });
        }
        get phancong() {
            return this._congnhat;
        }
        set phancong(_phancong) {
            let self = this;
            $.each(_phancong, function(keypc, phancong) {
                self._congnhat[phancong.__EMPTY] = self._congnhat[phancong.__EMPTY] || new CongNhat(phancong.__EMPTY, self);
                self._congnhat[phancong.__EMPTY].thoigian = self.getJsDateFromExcel(phancong.__EMPTY)
                    .toLocaleDateString('vi-VN', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    });
                let pc = new Phancong(phancong, self.name);
                self._congnhat[phancong.__EMPTY].kho = pc.xe;
                self._congnhat[phancong.__EMPTY].nvkho = pc.laixe;
            });
        }
        /**
         * nang suat
         */
        get nangsuat() {
            let self = this;
            let _nangsuat = 0;
            $.each(self._congnhat, function(keycc, congnhat) {
                _nangsuat += congnhat.nangsuat || 0;
            });
            return _nangsuat;
        }
        set nangsuat(_nangsuat) {
            let self = this;
            _nangsuat.forEach(function(nangsuat) {
                self._congnhat[nangsuat.__EMPTY] = self._congnhat[nangsuat.__EMPTY] || new CongNhat(nangsuat.__EMPTY, self);
                self._congnhat[nangsuat.__EMPTY].thoigian = self.getJsDateFromExcel(nangsuat.__EMPTY)
                    .toLocaleDateString('vi-VN', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    });
                let kho = self._congnhat[nangsuat.__EMPTY].kho || false;
                if (!kho) return;
                kho = kho.replace(/^xe /gi, '');
                self._congnhat[nangsuat.__EMPTY].doanhso = nangsuat['ns ' + kho] || 0;
                self._congnhat[nangsuat.__EMPTY].thuno = nangsuat['thu no ' + kho] || 0;
                self._congnhat[nangsuat.__EMPTY].chono = nangsuat['no ' + kho] || 0;
                if (self._congnhat[nangsuat.__EMPTY].kho === 'kho') {
                    return;
                }
                try {
                    self._congnhat[nangsuat.__EMPTY].tile = 1 / self._congnhat[nangsuat.__EMPTY].nvkho.length;
                } catch (e) {
                    self._congnhat[nangsuat.__EMPTY].tile = 1;
                }
                self._congnhat[nangsuat.__EMPTY].nangsuat = self._congnhat[nangsuat.__EMPTY].tile * (
                    self._congnhat[nangsuat.__EMPTY].doanhso +
                    self._congnhat[nangsuat.__EMPTY].chono * 0.7 -
                    self._congnhat[nangsuat.__EMPTY].thuno * 0.7
                );
                self._congnhat[nangsuat.__EMPTY].chitieu = self._congnhat[nangsuat.__EMPTY].nangsuat;
                self._congnhat[nangsuat.__EMPTY].chitieu -= self.chiTieu / 30 * self._congnhat[nangsuat.__EMPTY].cong;
                self._congnhat[nangsuat.__EMPTY].heso = self.heSo[0] || 0.01;
                self.heSo.forEach(function(heso, muctieu) {
                    if (self._congnhat[nangsuat.__EMPTY].chitieu >= muctieu)
                        self._congnhat[nangsuat.__EMPTY].heso = Math.max(self._congnhat[nangsuat.__EMPTY].heso, heso);
                });
            });
        }
        getJsDateFromExcel(excelDate) {
            return new Date((excelDate - (25567 + 2)) * 86400 * 1000);
        }
    }
    export default {
        mounted() {
            try {
                let self = this;
                self._loadStep = 1;
                (function checkLoadStep() {
                    if (self._loadStep == 1) self._loadSheetNhanvien();
                    if (self._loadStep == 2) self._loadSheetChamcong();
                    if (self._loadStep == 3) self._loadSheetPhancong();
                    if (self._loadStep == 4) self._loadSheetNangsuat();
                    else window.setTimeout(checkLoadStep, 1000);
                })();
                console.log('mounted');
            } catch (e) {}
        },
        /**
         * Defines the data used by the component
         * @return {[type]} [description]
         */
        data() {
            return {
                _loadStep: 0,
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
            },
            phancong: function(newPhancong, oldPhancong) {
                this.importPhancong(newPhancong);
                this.forceRerender();
            },
            nangsuat: function(newNangsuat, oldNangsuat) {
                this.importNangsuat(newNangsuat);
                this.forceRerender();
            }
        },
        methods: {
            forceRerender() {
                this.componentKey += 1;
            },
            _loadSheetNhanvien: function() {
                let self = this;
                self._loadStep = 0;
                /* set up an async GET request with axios */
                axios('/' + window.location.pathname.split('/').filter(v => v != '').join('/') + '/' + 'nhanvien.xlsx', {
                    responseType: 'arraybuffer',
                    headers: {
                        'Cache-Control': 'no-cache'
                    }
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
                    self._loadStep = 2;
                    console.log('_loadSheetNhanvien');
                });
            },
            _loadSheetChamcong: function() {
                let self = this;
                self._loadStep = 0;
                /* set up an async GET request with axios */
                axios('/' + window.location.pathname.split('/').filter(v => v != '').join('/') + '/' + 'chamcong.xlsx', {
                    responseType: 'arraybuffer',
                    headers: {
                        'Cache-Control': 'no-cache'
                    }
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
                    self._loadStep = 3;
                    console.log('_loadSheetChamcong');
                });
            },
            _loadSheetPhancong: function() {
                let self = this;
                self._loadStep = 0;
                /* set up an async GET request with axios */
                axios('/' + window.location.pathname.split('/').filter(v => v != '').join('/') + '/' + 'phancong.xlsx', {
                    responseType: 'arraybuffer',
                    headers: {
                        'Cache-Control': 'no-cache'
                    }
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
                    let _phancong = {};
                    $.each(XLSX.utils.sheet_to_json(workbook.Sheets.phancong), function(keypc, phancong) {
                        _phancong[phancong.__EMPTY] = phancong;
                    });
                    self.phancong = _phancong;
                    self._loadStep = 4;
                    console.log('_loadSheetPhancong');
                });
            },
            _loadSheetNangsuat: function() {
                let self = this;
                self._loadStep = 0;
                /* set up an async GET request with axios */
                axios('/' + window.location.pathname.split('/').filter(v => v != '').join('/') + '/' + 'nangsuat.xlsx', {
                    responseType: 'arraybuffer',
                    headers: {
                        'Cache-Control': 'no-cache'
                    }
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
                    window.nangsuatWB = workbook;
                    let _nangsuat = {};
                    $.each(XLSX.utils.sheet_to_json(workbook.Sheets.nangsuat), function(keyns, nangsuat) {
                        _nangsuat[nangsuat.__EMPTY] = nangsuat;
                    });
                    self.nangsuat = _nangsuat;
                    self._loadStep = 5;
                    console.log('_loadSheetNangsuat');
                });
            },
            importChamcong: function(chamcong) {
                let self = this;
                $.each(self.nhanvien, function(keynv, nv) {
                    nv.congnhat = chamcong;
                    return nv;
                });
            },
            importNghikhongphep: function(nghikhongphep) {
                let self = this;
                $.each(self.nhanvien, function(keynv, nv) {
                    nv.nghikhongphep = nghikhongphep;
                    return nv;
                });
            },
            importPhancong: function(phancong) {
                this.nhanvien.forEach(function(nv) {
                    nv.phancong = phancong;
                });
            },
            importNangsuat: function(nangsuat) {
                this.nhanvien.forEach(function(nv) {
                    nv.nangsuat = nangsuat;
                });
            }
        }
    }

</script>
