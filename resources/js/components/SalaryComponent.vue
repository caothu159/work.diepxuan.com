<template>
    <div class="col-12">
        <h3 v-if="!renderComponent">Loading...</h3>
        <table
            class="table table-hover table-condensed table-sm text-center"
            v-if="renderComponent"
        >
            <tr>
                <td>{{ month }}/{{ year }}</td>
                <td v-for="user in users" v-if="renderComponent">
                    <salaryuser
                        :salaryuser="user"
                        :router="routeruser"
                        :thang="month"
                        :nam="year"
                        @updateUser="updateUser"
                    />
                </td>
                <td v-if="renderComponent">
                    <salaryuser
                        :router="routeruser"
                        :thang="month"
                        :nam="year"
                        @updateUser="updateUser"
                    />
                </td>
            </tr>
            <tr v-for="index in days" :key="index" v-if="renderComponent">
                <td>{{ index }}/{{ month }}/{{ year }}</td>
                <td v-for="user in users" v-if="renderComponent">
                    <salaryitem
                        :salaryitem="getSalary(index, user.ten)"
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
        let self = this;
        try {
            self.renderComponent = false;
            axios(
                "/salaryuser/" + self.month + "-" + self.year,
                {
                    // responseType: "arraybuffer",
                    headers: {
                        "Cache-Control": "no-cache"
                    }
                },
                {
                    onDownloadProgress: function(progressEvent) {
                        self.renderComponent = false;
                    },
                    onUploadProgress: function(evt) {
                        self.renderComponent = false;
                    }
                }
            )
                .catch(function(err) {
                    /* error in getting data */
                    console.log(err);
                    self.forceRerender();
                })
                .then(function(res) {
                    /* parse the data when it is received */
                    let salaryusers = res.data.users;
                    self.forceRerender();
                    return salaryusers;
                })
                .catch(function(err) {
                    /* error in parsing */
                    console.log(err);
                    self.forceRerender();
                })
                .then(function(salaryusers) {
                    self.users.forEach((user, index) => {
                        let salaryuser = salaryusers.filter(function(elem) {
                            if (elem.ten == user.ten) return elem;
                        })[0];
                        self.users[index] = salaryuser || user;
                        self.forceRerender();
                    });
                    self.forceRerender();
                })
                .catch(function(err) {
                    /* error in parsing */
                    console.log(err);
                    self.forceRerender();
                });
        } catch (e) {
            console.log(e);
            self.forceRerender();
        }
    },
    /**
     * Defines the data used by the component
     * @return {[type]} [description]
     */
    data() {
        return {
            renderComponent: true,
            componentKey: 0,
            salaries: JSON.parse(this.salariesdata),
            users: JSON.parse(this.usersdata),
            days: parseInt(this.daysdata),
            month: parseInt(this.monthdata),
            year: parseInt(this.yeardata)
        };
    },
    watch: {},
    methods: {
        getSalary: function(ngay, ten) {
            let $return = {
                ten: ten,
                ngay: ngay,
                thang: this.month,
                nam: this.year,
                diadiem: null,
                chamcong: 0,
                doanhso: null,
                thuno: null,
                chono: null
            };
            try {
                let $_return = this.salaries.filter(elem => {
                    if (elem.ten == ten && elem.ngay == ngay) return elem;
                })[0];
                return $_return ? $_return : $return;
            } catch (e) {
                return $return;
            }
            return $return;
        },
        getUser: function(ten) {
            let $return = {
                ten: ten,
                ngay: ngay,
                thang: this.month,
                nam: this.year,
                diadiem: null,
                chamcong: 0,
                doanhso: null,
                thuno: null,
                chono: null
            };
            try {
                let $_return = this.salaries.filter(function(elem) {
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
            this.renderComponent = false;

            this.$nextTick(() => {
                // Add the component back in
                this.renderComponent = true;
            });

            this.componentKey += 1;
        },
        updateUser(user) {
            let self = this;
            let foundIndex = self.users.findIndex(x => x.ten == user.ten);
            if (foundIndex == -1) {
                self.users.push(user);
                this.forceRerender();
            }
        },
        updateItem($_salaryA) {
            let self = this;
            let foundIndexA = self.salaries.findIndex(
                elem => elem.ten == $_salaryA.ten && elem.ngay == $_salaryA.ngay
            );
            self.salaries[foundIndexA] = $_salaryA;

            console.log($_salaryA);

            let foundIndexB = self.salaries.findIndex(
                elem =>
                    elem.diadiem == $_salaryA.diadiem &&
                    elem.ngay == $_salaryA.ngay &&
                    elem.ten !== $_salaryA.ten
            );

            if (foundIndexB !== -1) {
                self.salaries[foundIndexB].chamcong = $_salaryA.chamcong;
                self.salaries[foundIndexB].diadiem = $_salaryA.diadiem;
                self.salaries[foundIndexB].doanhso = $_salaryA.doanhso;
                self.salaries[foundIndexB].chono = $_salaryA.chono;
                self.salaries[foundIndexB].thuno = $_salaryA.thuno;
                self.salaries[foundIndexB].tile = $_salaryA.tile;
            }
        }
    },
    props: {
        usersdata: String,
        salariesdata: String,
        daysdata: [String, Number],
        monthdata: [String, Number],
        yeardata: [String, Number],
        routersalary: String,
        routeruser: String
    }
};
</script>
