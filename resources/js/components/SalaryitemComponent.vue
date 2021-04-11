<!-- SalaryItemComponent.vue -->
<template>
    <div class="salary-item text-left">
        <form
            action="#"
            class="form"
            @submit.prevent="update"
            v-on:change="change"
        >
            <input type="hidden" v-model="salary.ngay" />
            <input type="hidden" v-model="salary.thang" />
            <input type="hidden" v-model="salary.nam" />
            <input type="hidden" v-model="salary.ten" />
            <b class="salary-name">{{ salary.ten }}</b>
            <div class="check" v-on:click="update" v-if="isChanged"></div>
            <button type="submit" class="btn btn-sm btn-primary d-none">
                update
            </button>
            <label>
                <select class="form-control" v-model="salary.chamcong">
                    <option value="0">nghỉ</option>
                    <option value="0.5">1/2 ngày</option>
                    <option value="1">1 ngày</option>
                    <option value="1.5">về muộn</option>
                    <option value="2">công đêm</option>
                </select>
            </label>
            <input
                type="text"
                class="form-control form-control-sm"
                placeholder="địa điểm"
                v-model="salary.diadiem"
            />
            <input
                type="number"
                class="form-control form-control-sm"
                placeholder="doanh số"
                v-model="salary.doanhso"
            />
            <input
                type="number"
                class="form-control form-control-sm"
                placeholder="cho nợ"
                v-model="salary.chono"
            />
            <input
                type="number"
                class="form-control form-control-sm"
                placeholder="thu nợ"
                v-model="salary.thuno"
            />
            <input
                type="number"
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
                ngay: this.salaryitem.ngay,
                thang: this.salaryitem.thang,
                nam: this.salaryitem.nam,
                ten: this.salaryitem.ten,
                chamcong: this.salaryitem.chamcong,
                diadiem: this.salaryitem.diadiem,
                doanhso: this.salaryitem.doanhso,
                chono: this.salaryitem.chono,
                thuno: this.salaryitem.thuno,
                tile: this.salaryitem.tile
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
                let salaryResponse = response.data.salary;
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
        salaryitem: Object,
        router: String
    }
};
</script>

<style>
.salary-item .salary-name {
    text-indent: 10px;
    display: inline-block;
}

.salary-item label {
    text-indent: 10px;
}

.salary-item input:placeholder-shown {
}

.check {
    display: inline-block;
    transform: rotate(45deg);
    height: 22px;
    width: 10px;
    border-bottom: 4px solid #78b13f;
    border-right: 4px solid #78b13f;
    margin-left: 15px;
}
</style>
