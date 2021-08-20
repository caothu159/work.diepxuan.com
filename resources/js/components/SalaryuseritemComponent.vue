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

            <a :href="thang + '-' + nam + '/' + salary.ten" class="salary-name">
                <b class="salary-name">{{ salary.ten }}</b>
            </a>

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
                type="text"
                class="form-control form-control-sm"
                placeholder="công tháng"
                v-model="salary.congthang"
            />
            <input
                type="text"
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
                :value="Math.round(salary.heso * 10000)"
                @input="
                    (e) => (salary.heso = Math.round(e.target.value) * 0.0001)
                "
            />
            <input
                class="form-control form-control-sm"
                placeholder="tile"
                :value="Math.round(salary.tile * 100)"
                @input="
                    (e) => (salary.tile = Math.round(e.target.value) * 0.01)
                "
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
        // if (this.salaryuser.ten == "hai") console.log(this.salaryuser.tile);
        return {
            componentKey: 0,
            salary: new Form({
                isJsonResponse: true,
                isNew: this.salaryuser.new ? this.salaryuser.new : false,

                thang: this.thang,
                nam: this.nam,
                ten: this.salaryuser.ten,
                luongcoban: this.salaryuser.luongcoban,
                congthang: this.salaryuser.congthang,
                baohiem: this.salaryuser.baohiem,
                chitieu: this.salaryuser.chitieu,
                heso: this.salaryuser.heso,
                tile: this.salaryuser.tile,
            }),
            isChanged: false,
        };
    },
    created: function () {},
    watch: {},
    methods: {
        update() {
            let self = this;
            this.salary.post(this.router).then((response) => {
                this.isChanged = false;
                let salaryResponse = response.data.user;

                this.salary.thang = salaryResponse.thang;
                this.salary.nam = salaryResponse.nam;
                this.salary.ten = salaryResponse.ten;
                this.salary.luongcoban = salaryResponse.luongcoban;
                this.salary.congthang = salaryResponse.congthang;
                this.salary.baohiem = salaryResponse.baohiem;
                this.salary.chitieu = salaryResponse.chitieu;
                this.salary.heso = salaryResponse.heso;
                this.salary.tile = salaryResponse.tile;
                // self.$emit("updateUser", this.salary);
            });
        },
        change() {
            this.isChanged = true;
        },
    },
    props: {
        salaryuser: {
            type: Object,
            default: function () {
                return {
                    ten: null,
                    luongcoban: null,
                    baohiem: null,
                    chitieu: null,
                    heso: null,
                    tile: null,
                    new: true,
                };
            },
        },
        router: String,
        thang: Number,
        nam: Number,
    },
};
</script>

<style>
.salary-item .salary-name {
    color: black;
    display: inline-block;
    font-size: 1.1em;
    text-indent: 10px;
    text-decoration: none;
}
</style>
