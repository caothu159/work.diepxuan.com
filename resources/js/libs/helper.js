'use strict';

const helper = {
    formatNumber: (num) => {
        return new Intl.NumberFormat('vi-VN', { style: 'decimal' }).format(num);
    },
    timeout: (condition, callback, max = 0) => {
        let _condition = condition;
        if (typeof condition == "function") {
            _condition = condition.call();
        }

        if (_condition) {
            if (typeof callback !== "function") {
                return callback;
            } else {
                return callback.call();
            }
        } else {
            setTimeout(() => {
                helper.timeout(condition, callback, max);
            }, 1000);
        }
    },
    formatDate: (date = Date.now()) => {
        date = date || Date.now();
        return new Intl.DateTimeFormat('vi-VN', {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
        }).format(new Date(date));
    },
    fetchData: () => {}
}

export default helper
