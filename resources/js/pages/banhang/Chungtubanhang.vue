<template>
    <div class="row ctubanhang-container">
        <div class="col-12 pb-3">
            <h4 class="mb-3 mt-3">Hóa đơn bán hàng</h4>
            <form @submit="formSubmit">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Ngày chứng từ</div>
                            </div>
                            <input type="text" class="form-control" v-model="date.from">
                        </div>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control mb-2" v-model="date.to">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" v-bind:disabled="loading">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="loading"></span>
                    <span>Tìm kiếm</span>
                </button>
            </form>
        </div>
        <div class=" col-12 ctubanhang-content" v-if="ctubanhangLst">
            <div class="text-center m-3" v-if="loading">
                <div class="spinner-border text-success spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <table class="table table-hover table-condensed table-sm text-monospace" v-if="!loading">
                <!-- <tr class="text-danger"> -->
                <tr>
                    <th>Ngày</th>
                    <th>Mã khách hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Diễn giải</th>
                    <th>Số lượng</th>
                    <th class="text-right">Tổng tiền</th>
                    <th>Số hóa đơn</th>
                    <th>Mã thanh toán</th>
                    <th>Mã phiếu thu</th>
                </tr>
                <tr v-for="ctubanhang in ctubanhangLst" v-bind:class="{ selected: ctubanhang.selected }">
                    <td>
                        <router-link :to="{ name: 'Hoa don ban hang chi tiet', params: { id: ctubanhang.stt_rec }}" class="text-dark text-decoration-none">
                            {{ formatDate(ctubanhang.ngay_ct) }}
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="{ name: 'Hoa don ban hang chi tiet', params: { id: ctubanhang.stt_rec }}" class="text-dark text-decoration-none">
                            {{ ctubanhang.ma_kh }}
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="{ name: 'Hoa don ban hang chi tiet', params: { id: ctubanhang.stt_rec }}" class="text-dark text-decoration-none">
                            {{ ctubanhang.ten_kh_vat }}
                        </router-link>
                    </td>
                    <td>{{ ctubanhang.dien_giai }}</td>
                    <td>{{ formatNumber(ctubanhang.t_so_luong) }}</td>
                    <td class="text-right">{{ formatNumber(ctubanhang.t_tt) }}</td>
                    <td>{{ ctubanhang.so_ct }}</td>
                    <td>{{ ctubanhang.ma_httt }}</td>
                    <td>{{ ctubanhang.tk_pt }}</td>
                </tr>
                <tr>
                    <th>Tổng</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ ctubanhangLst.sum('t_so_luong') }}</th>
                    <th class="text-right">{{ formatNumber(ctubanhangLst.sum('t_tt')) }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </table>
        </div>
        <div class="col-12" v-if="ctubanhangid">
            <router-view :key="ctubanhangid" />
        </div>
    </div>
</template>
<script>
export default {
    name: 'Chungtubanhang',
    data() {
        return {
            ctubanhangLst: null,
            helper: window.Helper,
            date: {
                from: window.Helper.formatDate(),
                to: window.Helper.formatDate(),
            },
            loading: true,
        };
    },
    mounted() {
        this.initDanhSach(this.ctubanhangid);
    },
    methods: {
        formSubmit(event) {
            event.preventDefault();
            this.initDanhSach();
        },
        initDanhSach(id = null) {
            let self = this;
            let pathname = "/api/v1/hdbh";
            self.loading = true;
            if (id) {
                pathname = [pathname, id].join('/');
            }
            self.helper.timeout(() => {
                if (!isAuthenticated)
                    return false;
                if (typeof axios.defaults.headers.common['Authorization'] !== 'undefined' &&
                    axios.defaults.headers.common['Authorization'] !== undefined) {
                    return true;
                }
                return false;
            }, () => {
                axios(pathname, {
                        headers: {
                            "Cache-Control": "no-cache",
                        },
                        params: {
                            from: self.date.from,
                            to: self.date.to,
                        }

                    })
                    .catch(function(err) {
                        /* error in getting data */
                        console.log(err);
                    })
                    .then(function(res) {
                        /* parse the data when it is received */
                        return res.data;
                    })
                    .catch(function(err) {
                        /* error in parsing */
                        self.ctubanhangLst = null;
                        console.log(err);
                    })
                    .then(function(res) {
                        self.ctubanhangLst = self.updateDanhSach((() => {
                            if (id) {
                                self.date.from = self.helper.formatDate(res.data.ngay_ct);
                                return [res.data];
                            }
                            return res.data;
                        })());
                        self.loading = false;
                    })
                    .catch(function(err) {
                        /* error in parsing */
                        self.ctubanhangLst = null;
                        self.loading = false;
                        console.log(err);
                    });
            });
        },
        updateDanhSach(ctubanhangLst) {
            let self = this;
            ctubanhangLst = ctubanhangLst.map((ctubanhang) => {
                ctubanhang.selected = (ctubanhang.stt_rec === self.ctubanhangid);
                ctubanhang.t_tt = Number(ctubanhang.t_tt);
                ctubanhang.t_so_luong = Number(ctubanhang.t_so_luong);
                return ctubanhang;
            });
            if (ctubanhangLst.length == 0) {
                return null;
            }
            return ctubanhangLst;
        },
        formatNumber(number) {
            return this.helper.formatNumber(number);
        },
        formatDate(date) {
            return this.helper.formatDate(date);
        }
    },
    computed: {
        ctubanhangid() {
            return this.$route.params.id;
        }
    },
    watch: {
        date: {
            handler(newDate, oldDate) {
                this.date.forEach((_date, key) => {
                    _date = _date.replace(/[^0-9\/]/g, '');
                    return _date;
                });
            },
            deep: true
        },
        ctubanhangid() {
            let self = this;
            self.ctubanhangLst = self.ctubanhangLst.map((ctubanhang) => {
                ctubanhang.selected = (ctubanhang.stt_rec === self.ctubanhangid);
                return ctubanhang;
            });
        }
    },
};

</script>
