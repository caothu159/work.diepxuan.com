<template>
    <div class="row ctubanhangvt-container" v-if="ctubanhangid">
        <div class="col-12">
            <div class="text-center m-3" v-if="loading">
                <div class="spinner-border text-success spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <table class="table table-hover table-condensed table-sm text-monospace" v-if="!loading">
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Kho</th>
                    <th>Đơn vị tính</th>
                    <th>Số lượng</th>
                    <th class="text-right">Đơn giá</th>
                    <th class="text-right">Thành tiền</th>
                    <th class="text-right">Chiết khấu</th>
                    <th class="text-right">Tổng tiền</th>
                    <th>Mã nhân viên kinh doanh</th>
                    <th>Mã bộ phận</th>
                </tr>
                <tr v-for="ctubanhangvt in ctubanhangvtLst">
                    <td>{{ ctubanhangvt.ma_vt }}</td>
                    <td>{{ ctubanhangvt.ten_vt }}</td>
                    <td>{{ ctubanhangvt.ma_kho }}</td>
                    <td>{{ ctubanhangvt.dvt }}</td>
                    <td>{{ formatNumber(ctubanhangvt.so_luong) }}</td>
                    <td class="text-right">{{ formatNumber(ctubanhangvt.gia2) }}</td>
                    <td class="text-right">{{ formatNumber(ctubanhangvt.tien2) }}</td>
                    <td class="text-right">{{ formatNumber(ctubanhangvt.ck_ds) }}</td>
                    <td class="text-right">{{ formatNumber(ctubanhangvt.tt) }}</td>
                    <td>{{ ctubanhangvt.ma_nvkd }}</td>
                    <td>{{ ctubanhangvt.ma_bp }}</td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Chungtubanhangvt',
    data() {
        return {
            helper: window.Helper,
            ctubanhangvtLst: null,
            loading: true,
        };
    },

    mounted() {
        this.initDanhSach();
    },
    methods: {
        formatNumber(number) {
            return this.helper.formatNumber(number);
        },
        formatDate(date) {
            return this.helper.formatDate(date);
        },
        initDanhSach() {
            let self = this;
            self.helper.timeout(() => {
                if (!isAuthenticated)
                    return false;
                if (typeof axios.defaults.headers.common['Authorization'] !== 'undefined' &&
                    axios.defaults.headers.common['Authorization'] !== undefined) {
                    return true;
                }
                return false;
            }, () => {
                axios("/api/v1/hdbhvt/" + self.ctubanhangid, {
                        headers: {
                            "Cache-Control": "no-cache",
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
                        console.log(err);
                    })
                    .then(function(res) {
                        self.ctubanhangvtLst = self.updateDanhSach((() => {
                            return res.data;
                        })());
                        self.loading = false;
                    })
                    .catch(function(err) {
                        /* error in parsing */
                        self.loading = false;
                        console.log(err);
                    });
            });
        },
        updateDanhSach(ctubanhangvtLst) {
            let self = this;
            new Promise((resolve, reject) => {
                resolve(ctubanhangvtLst);
            }).then((ctbhvtLst) => {
                ctubanhangvtLst = ctbhvtLst.map((ctubanhangvt) => {
                    return ctubanhangvt;
                });
            });
            if (ctubanhangvtLst.length == 0) {
                return null;
            }
            return ctubanhangvtLst;
        }
    },
    computed: {
        ctubanhangid() {
            return this.$route.params.id;
        }
    },

    watch: {
        // ctubanhangLst() {},
    },
    props: {},
};

</script>
