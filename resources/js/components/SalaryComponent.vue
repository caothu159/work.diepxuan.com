<template>
    <div class="col-12">
        <h3 v-if="!renderComponent">Loading...</h3>
        <table
            class="table table-hover table-condensed table-sm text-center"
            v-if="renderComponent"
        >
            <tr>
                <td>{{ data.month }}/{{ data.year }}</td>
                <td v-for="user in data.users" v-if="renderComponent">
                    <salaryuser
                        :salaryuser="user"
                        :router="routeruser"
                        :thang="data.month"
                        :nam="data.year"
                    />
                </td>
                <td v-if="renderComponent">
                    <salaryuser
                        :router="routeruser"
                        :thang="data.month"
                        :nam="data.year"
                    />
                </td>
            </tr>
            <tr v-for="index in data.days" :key="index" v-if="renderComponent">
                <td>{{ index }}/{{ data.month }}/{{ data.year }}</td>
                <td v-for="user in data.users" v-if="renderComponent">
                    <salaryitem
                        :salaryitem="getSalary(index, user.ten)"
                        :router="routersalary"
                    />
                </td>
            </tr>
        </table>
    </div>
</template>
<script>
export default {
    mounted() {
        try {
            let self = this;
            self.renderComponent = false;
            axios(
                "/salaryuser/" + self.data.month + "-" + self.data.year,
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
                })
                .then(function(res) {
                    /* parse the data when it is received */
                    let salaryusers = res.data.users;
                    return salaryusers;
                })
                .catch(function(err) {
                    /* error in parsing */
                    console.log(err);
                })
                .then(function(salaryusers) {
                    self.data.users.forEach((user, index) => {
                        let salaryuser = salaryusers.filter(function(elem) {
                            if (elem.ten == user.ten) return elem;
                        })[0];
                        self.data.users[index] = salaryuser || user;
                        self.forceRerender();
                    });
                })
                .catch(function(err) {
                    /* error in parsing */
                    console.log(err);
                });
        } catch (e) {
            console.log(e);
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
            data: {
                salaries: JSON.parse(this.salaries),
                users: JSON.parse(this.users),
                days: parseInt(this.days),
                month: parseInt(this.month),
                year: parseInt(this.year)
            }
        };
    },
    watch: {
        data: function(newData, oldData) {
            this.forceRerender();
        }
    },
    methods: {
        getSalary: function(ngay, ten) {
            let $return = {
                ten: ten,
                ngay: ngay,
                thang: this.data.month,
                nam: this.data.year,
                diadiem: null,
                chamcong: 0,
                doanhso: null,
                thuno: null,
                chono: null
            };
            try {
                let $_return = this.data.salaries.filter(elem => {
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
                thang: this.data.month,
                nam: this.data.year,
                diadiem: null,
                chamcong: 0,
                doanhso: null,
                thuno: null,
                chono: null
            };
            try {
                let $_return = this.data.salaries.filter(function(elem) {
                    if (elem.ten == ten && elem.ngay == ngay) return elem;
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
        }
    },
    props: {
        users: String,
        salaries: String,
        days: [String, Number],
        month: [String, Number],
        year: [String, Number],
        routersalary: String,
        routeruser: String
    }
};
</script>
