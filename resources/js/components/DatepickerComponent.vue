<script>
import datepicker from 'vuejs-datepicker';

datepicker.methods.stringToDate = function (date) {
    return moment(date, "DD-MM-YYYY").toDate();
}
export default {
    mixins: [datepicker],
    methods: {
        stringToDate: function (date) {
            return moment(date, "DD-MM-YYYY").toDate();
        }
    }
}
</script>
