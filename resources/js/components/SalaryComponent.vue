<template>
    <div class="col-12">
        <div v-if="!renderComponent || renderComponent !== 1" id="loader"></div>
        <table
            class="table table-hover table-condensed table-sm text-center"
            v-if="renderComponent == 1"
        >
            <tr>
                <td>{{ month }}/{{ year }}</td>
                <td v-for="user in users" v-if="renderComponent == 1">
                    <salaryuser
                        :salaryuser="user"
                        :router="routeruser"
                        :thang="month"
                        :nam="year"
                        @updateUser="updateUser"
                    />
                </td>
                <td v-if="renderComponent == 1">
                    <salaryuser
                        :router="routeruser"
                        :thang="month"
                        :nam="year"
                        @updateUser="updateUser"
                    />
                </td>
            </tr>
            <tr v-for="ngay in days" :key="ngay" v-if="renderComponent == 1">
                <td>{{ ngay }}/{{ month }}/{{ year }}</td>
                <td v-for="user in users" v-if="renderComponent == 1">
                    <salaryitem
                        :salaryitem="
                            salaries[ngay + user.ten]
                                ? salaries[ngay + user.ten]
                                : getSalary(ngay, user.ten)
                        "
                        :router="routersalary"
                        @updateItem="updateItem"
                    />
                </td>
            </tr>
        </table>
    </div>
</template>
<script>
export default {
    mounted() {
        this.loadUsers(false);
        this.loadSalaries();
    },
    /**
     * Defines the data used by the component
     * @return {[type]} [description]
     */
    data() {
        let self = this;
        return {
            renderComponent: 1,
            componentKey: 0,
            days: parseInt(self.daysdata),
            month: parseInt(self.monthdata),
            year: parseInt(self.yeardata),
            salaries: [],
            users: [],
        };
    },
    watch: {},
    methods: {
        getSalary: function (ngay, ten) {
            let $return = {
                ten: ten,
                ngay: ngay,
                thang: this.month,
                nam: this.year,
                diadiem: null,
                chamcong: 0,
                doanhso: null,
                thuno: null,
                chono: null,
            };
            try {
                let $_return = this.salaries.filter((elem) => {
                    if (elem.ten == ten && elem.ngay == ngay) return elem;
                })[0];
                return $_return ? $_return : $return;
            } catch (e) {
                return $return;
            }
            return $return;
        },
        loadUsers: function (update = false) {
            let self = this;
            try {
                self.renderComponent += 1;
                axios(
                    update
                        ? self.routeruser
                        : self.routeruser + "/" + self.month + "-" + self.year,
                    {
                        headers: {
                            "Cache-Control": "no-cache",
                        },
                    },
                    {
                        onDownloadProgress: function (progressEvent) {
                            // self.renderComponent += 1;
                        },
                        onUploadProgress: function (evt) {
                            // self.renderComponent += 1;
                        },
                    }
                )
                    .catch(function (err) {
                        /* error in getting data */
                        console.log(err);
                        self.forceRerender();
                    })
                    .then(function (res) {
                        /* parse the data when it is received */
                        let salaryusers = res.data.users;
                        self.forceRerender();
                        self.renderComponent -= 1;
                        return salaryusers;
                    })
                    .catch(function (err) {
                        /* error in parsing */
                        console.log(err);
                        self.forceRerender();
                        self.renderComponent -= 1;
                    })
                    .then(function (salaryusers) {
                        if (!update) {
                            self.users = salaryusers;
                            self.forceRerender();

                            return self.loadUsers(true);
                        }

                        self.users.forEach((user, index) => {
                            let salaryuser = salaryusers.filter(function (
                                elem
                            ) {
                                if (elem.ten == user.ten) return elem;
                            })[0];
                            // self.users[index] = salaryuser;

                            user.luongcoban =
                                user.luongcoban || salaryuser.luongcoban;
                            user.congthang =
                                user.congthang || salaryuser.congthang;
                            user.baohiem = user.baohiem || salaryuser.baohiem;
                            user.chitieu = user.chitieu || salaryuser.chitieu;
                            user.heso = user.heso || salaryuser.heso;
                            user.tile = user.tile || salaryuser.tile;

                            self.users[index] = user;
                            self.forceRerender();
                        });
                    })
                    .catch(function (err) {
                        /* error in parsing */
                        console.log(err);
                        self.forceRerender();
                    });
            } catch (e) {
                console.log(e);
                self.forceRerender();
            }
        },
        loadSalaries: function () {
            let self = this;
            try {
                self.renderComponent += 1;
                axios(
                    self.routersalary + "/" + self.month + "-" + self.year,
                    {
                        headers: {
                            "Cache-Control": "no-cache",
                        },
                    },
                    {
                        onDownloadProgress: function (progressEvent) {
                            // self.renderComponent = false;
                        },
                        onUploadProgress: function (evt) {
                            // self.renderComponent = false;
                        },
                    }
                )
                    .catch(function (err) {
                        /* error in getting data */
                        console.log(err);
                        self.forceRerender();
                    })
                    .then(function (res) {
                        /* parse the data when it is received */
                        let salaries = res.data.salaries;
                        self.forceRerender();
                        self.renderComponent -= 1;
                        return salaries;
                    })
                    .catch(function (err) {
                        /* error in parsing */
                        console.log(err);
                        self.forceRerender();
                        self.renderComponent -= 1;
                    })
                    .then(function (salaries) {
                        salaries.forEach((salary, index) => {
                            self.salaries[salary.ngay + salary.ten] = salary;
                            self.forceRerender();
                        });
                        console.log(self.salaries);
                        self.forceRerender();
                    })
                    .catch(function (err) {
                        /* error in parsing */
                        console.log(err);
                        self.forceRerender();
                    });
            } catch (e) {
                console.log(e);
                self.forceRerender();
            }
        },
        getUser: function (ten) {
            let $return = {
                ten: ten,
                ngay: ngay,
                thang: this.month,
                nam: this.year,
                diadiem: null,
                chamcong: 0,
                doanhso: null,
                thuno: null,
                chono: null,
            };
            try {
                let $_return = this.salaries.filter(function (elem) {
                    if (elem.ten == ten) return elem;
                })[0];
                return $_return ? $_return : $return;
            } catch (e) {
                return $return;
            }
            return $return;
        },
        forceRerender() {
            // Remove my-component from the DOM
            this.renderComponent += 1;

            this.$nextTick(() => {
                // Add the component back in
                this.renderComponent -= 1;
            });

            this.componentKey += 1;
        },
        updateUser(user) {
            let self = this;
            let foundIndex = self.users.findIndex((x) => x.ten == user.ten);
            if (foundIndex == -1) {
                self.users.push(user);
                this.forceRerender();
            }
        },
        updateItem($_salaryA) {
            // let self = this;
            // let foundIndexA = self.salaries.findIndex(
            //     (elem) =>
            //         elem.ten == $_salaryA.ten && elem.ngay == $_salaryA.ngay
            // );
            // self.salaries[foundIndexA] = $_salaryA;
            // console.log($_salaryA);
            //
            //
            // let foundIndexB = self.salaries.findIndex(
            //     (elem) =>
            //         elem.diadiem == $_salaryA.diadiem &&
            //         elem.ngay == $_salaryA.ngay &&
            //         elem.ten !== $_salaryA.ten
            // );
            // if (foundIndexB !== -1) {
            //     self.salaries[foundIndexB].chamcong = $_salaryA.chamcong;
            //     self.salaries[foundIndexB].diadiem = $_salaryA.diadiem;
            //     self.salaries[foundIndexB].doanhso = $_salaryA.doanhso;
            //     self.salaries[foundIndexB].chono = $_salaryA.chono;
            //     self.salaries[foundIndexB].thuno = $_salaryA.thuno;
            //     self.salaries[foundIndexB].tile = $_salaryA.tile;
            // }
        },
    },
    props: {
        // salariesdata: String,
        daysdata: [String, Number],
        monthdata: [String, Number],
        yeardata: [String, Number],
        routersalary: String,
        routeruser: String,
    },
};
</script>
