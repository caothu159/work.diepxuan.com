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

            <input
                class="form-check-input"
                type="checkbox"
                v-model="salary.chamcong"
                v-on:change="update"
            />
            <a
                class="salary-name"
                :href="salary.thang + '-' + salary.nam + '/' + salary.ten"
            >
                <b class="salary-name">{{ salary.ten }}</b>
            </a>

            <div class="check" v-on:click="update" v-if="isChanged"></div>
            <button type="submit" class="btn btn-sm btn-primary d-none">
                update
            </button>
            <select
                class="form-control form-control-sm"
                v-model="salary.chamcong"
            >
                <option value="0">nghỉ</option>
                <option value="0.5">1/2 ngày</option>
                <option value="1">1 ngày</option>
                <option value="1.5">về muộn</option>
                <option value="2">công đêm</option>
            </select>
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
                tile: this.salaryitem.tile,
            }),
            isChanged: false,
        };
    },
    created() {},
    watch: {},
    methods: {
        update() {
            let self = this;
            if (self.salary.chamcong === true) {
                self.salary.chamcong = 1;
            }
            this.salary.post(this.router).then((response) => {
                self.isChanged = false;
                let salaryResponse = response.data.salary;
                self.salary.ngay = salaryResponse.ngay;
                self.salary.thang = salaryResponse.thang;
                self.salary.nam = salaryResponse.nam;
                self.salary.ten = salaryResponse.ten;
                self.salary.chamcong = salaryResponse.chamcong;
                self.salary.diadiem = salaryResponse.diadiem;
                self.salary.doanhso = salaryResponse.doanhso;
                self.salary.chono = salaryResponse.chono;
                self.salary.thuno = salaryResponse.thuno;
                self.salary.tile = salaryResponse.tile;
                // self.$emit("updateItem", this.salary);
            });
        },
        change() {
            let self = this;
            self.isChanged = true;
            if (
                !self.salary.chamcong &&
                self.salary.diadiem &&
                self.salary.doanhso
            ) {
                self.salary.chamcong = 1;
            }
            // self.$emit("updateItem", this.salary);
        },
        // getAutocompleteArray() {
        //     console.log(salaries);
        //     return [];
        // }
        // autocomplete(inp) {
        //     let arr = this.getAutocompleteArray();
        //     /*the autocomplete function takes two arguments, the text field element and an array of possible autocompleted values:*/
        //     var currentFocus;
        //     /*execute a function when someone writes in the text field:*/
        //     inp.addEventListener("input", function(e) {
        //         var a,
        //             b,
        //             i,
        //             val = this.value;
        //         /*close any already open lists of autocompleted values*/
        //         closeAllLists();
        //         if (!val) {
        //             return false;
        //         }
        //         currentFocus = -1;
        //         /*create a DIV element that will contain the items (values):*/
        //         a = document.createElement("DIV");
        //         a.setAttribute("id", this.id + "autocomplete-list");
        //         a.setAttribute("class", "autocomplete-items");
        //         /*append the DIV element as a child of the autocomplete container:*/
        //         this.parentNode.appendChild(a);
        //         /*for each item in the array...*/
        //         for (i = 0; i < arr.length; i++) {
        //             /*check if the item starts with the same letters as the text field value:*/
        //             if (
        //                 arr[i].substr(0, val.length).toUpperCase() ==
        //                 val.toUpperCase()
        //             ) {
        //                 /*create a DIV element for each matching element:*/
        //                 b = document.createElement("DIV");
        //                 /*make the matching letters bold:*/
        //                 b.innerHTML =
        //                     "<strong>" +
        //                     arr[i].substr(0, val.length) +
        //                     "</strong>";
        //                 b.innerHTML += arr[i].substr(val.length);
        //                 /*insert a input field that will hold the current array item's value:*/
        //                 b.innerHTML +=
        //                     "<input type='hidden' value='" + arr[i] + "'>";
        //                 /*execute a function when someone clicks on the item value (DIV element):*/
        //                 b.addEventListener("click", function(e) {
        //                     /*insert the value for the autocomplete text field:*/
        //                     inp.value = this.getElementsByTagName(
        //                         "input"
        //                     )[0].value;
        //                     /*close the list of autocompleted values, (or any other open lists of autocompleted values:*/
        //                     closeAllLists();
        //                 });
        //                 a.appendChild(b);
        //             }
        //         }
        //     });
        //     /*execute a function presses a key on the keyboard:*/
        //     inp.addEventListener("keydown", function(e) {
        //         var x = document.getElementById(this.id + "autocomplete-list");
        //         if (x) x = x.getElementsByTagName("div");
        //         if (e.keyCode == 40) {
        //             /*If the arrow DOWN key is pressed, increase the currentFocus variable:*/
        //             currentFocus++;
        //             /*and and make the current item more visible:*/
        //             addActive(x);
        //         } else if (e.keyCode == 38) {
        //             //up
        //             /*If the arrow UP key is pressed, decrease the currentFocus variable:*/
        //             currentFocus--;
        //             /*and and make the current item more visible:*/
        //             addActive(x);
        //         } else if (e.keyCode == 13) {
        //             /*If the ENTER key is pressed, prevent the form from being submitted,*/
        //             e.preventDefault();
        //             if (currentFocus > -1) {
        //                 /*and simulate a click on the "active" item:*/
        //                 if (x) x[currentFocus].click();
        //             }
        //         }
        //     });
        //     function addActive(x) {
        //         /*a function to classify an item as "active":*/
        //         if (!x) return false;
        //         /*start by removing the "active" class on all items:*/
        //         removeActive(x);
        //         if (currentFocus >= x.length) currentFocus = 0;
        //         if (currentFocus < 0) currentFocus = x.length - 1;
        //         /*add class "autocomplete-active":*/
        //         x[currentFocus].classList.add("autocomplete-active");
        //     }
        //     function removeActive(x) {
        //         /* a function to remove the "active" class from all autocomplete items: */
        //         for (var i = 0; i < x.length; i++) {
        //             x[i].classList.remove("autocomplete-active");
        //         }
        //     }
        //     function closeAllLists(elmnt) {
        //         /* close all autocomplete lists in the document, except the one passed as an argument: */
        //         var x = document.getElementsByClassName("autocomplete-items");
        //         for (var i = 0; i < x.length; i++) {
        //             if (elmnt != x[i] && elmnt != inp) {
        //                 x[i].parentNode.removeChild(x[i]);
        //             }
        //         }
        //     }
        //     document.addEventListener("click", function(e) {
        //         closeAllLists(e.target);
        //     });
        // }
    },
    props: {
        salaryitem: Object,
        router: String,
    },
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

.salary-item input[type="radio"],
.salary-item input[type="checkbox"] {
    box-sizing: border-box;
    padding: 0;
    display: inline;
    float: left;
    margin-left: 0;
    margin-top: 0.4rem;
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

.autocomplete-items {
    position: absolute;
    border: 1px solid #d4d4d4;
    border-bottom: none;
    border-top: none;
    z-index: 99;
    /*position the autocomplete items to be the same width as the container:*/
    top: 100%;
    left: 0;
    right: 0;
}
.autocomplete-items div {
    padding: 10px;
    cursor: pointer;
    background-color: #fff;
    border-bottom: 1px solid #d4d4d4;
}
.autocomplete-items div:hover {
    /*when hovering an item:*/
    background-color: #e9e9e9;
}
.autocomplete-active {
    /*when navigating through the items using the arrow keys:*/
    background-color: DodgerBlue !important;
    color: #ffffff;
}
</style>
