<!-- SalaryItemComponent.vue -->
<template>
    <div class="salary-item text-left">
        <form
            action="#"
            class="form"
            @submit.prevent="update"
            v-on:change="change"
        >
            <input type="hidden" v-model="thang" />
            <input type="hidden" v-model="nam" />
            <input type="hidden" v-model="salary.ten" />
            <b class="salary-name">{{ salary.ten }}</b>
            <button
                type="submit"
                class="btn btn-sm btn-primary"
                v-if="isChanged"
            >
                update
            </button>
            <input
                type="text"
                class="form-control form-control-sm"
                placeholder="tên"
                v-if="salary.isNew"
                v-model="salary.ten"
            />
            <input
                type="text"
                class="form-control form-control-sm"
                placeholder="lương cơ bản"
                v-model="salary.luongcoban"
            />
            <input
                type="number"
                class="form-control form-control-sm"
                placeholder="bảo hiểm"
                v-model="salary.baohiem"
            />
            <input
                type="number"
                class="form-control form-control-sm"
                placeholder="chỉ tiêu"
                v-model="salary.chitieu"
            />
            <input
                type="number"
                class="form-control form-control-sm"
                placeholder="hệ số"
                :value="salary.heso * 100"
                @input="e => (salary.heso = e.target.value * 0.01)"
            />
            <input
                class="form-control form-control-sm"
                placeholder="tile"
                :value="salary.tile * 100"
                @input="e => (salary.tile = e.target.value * 0.01)"
            />
        </form>
    </div>
</template>

<script>
export default {
    mounted() {
        try {
            let self = this;
        } catch (e) {}
    },
    /**
     * Defines the data used by the component
     * @return {[type]} [description]
     */
    data() {
        return {
            componentKey: 0,
            salary: new Form({
                isJsonResponse: true,
                isNew: this.salaryuser.new ? this.salaryuser.new : false,
                thang: this.thang,
                nam: this.nam,
                ten: this.salaryuser.ten,
                luongcoban: this.salaryuser.luongcoban,
                baohiem: this.salaryuser.baohiem,
                chitieu: this.salaryuser.chitieu,
                heso: this.salaryuser.heso,
                tile: this.salaryuser.tile
            }),
            isChanged: false
        };
    },
    created: function() {},
    watch: {},
    methods: {
        update() {
            this.salary.post(this.router).then(response => {
                this.isChanged = false;
                let salaryResponse = response.data.user;
                this.salary.ngay = salaryResponse.ngay;
                this.salary.thang = salaryResponse.thang;
                this.salary.nam = salaryResponse.nam;
                this.salary.ten = salaryResponse.ten;
                this.salary.chamcong = salaryResponse.chamcong;
                this.salary.diadiem = salaryResponse.diadiem;
                this.salary.doanhso = salaryResponse.doanhso;
                this.salary.chono = salaryResponse.chono;
                this.salary.thuno = salaryResponse.thuno;
                this.salary.tile = salaryResponse.tile;
            });
        },
        change() {
            this.isChanged = true;
        }
    },
    props: {
        salaryuser: {
            type: Object,
            default: function() {
                return {
                    ten: null,
                    luongcoban: null,
                    baohiem: null,
                    chitieu: null,
                    heso: null,
                    tile: null,
                    new: true
                };
            }
        },
        router: String,
        thang: Number,
        nam: Number
    }
};
</script>

<style>
.salary-item .salary-name {
    text-indent: 10px;
    display: inline-block;
}
</style>
