//Vue Filter to make first letter Capital
Vue.filter("strToUpper", function(text) {

    return text.charAt(0).toUpperCase() + text.slice(1);

});

//Vue moment js to show human readable date
import moment from "moment"; //Import Moment

Vue.filter("formatDate", function(date) {

    return moment(date).format('MMMM Do YYYY');

});
Vue.filter('currencyDisplay', {
    // model -> view
    // formats the value when updating the input element.
    read: function(val) {
        return '₽' + val.toFixed(2)
    },
    // view -> model
    // formats the value when updating the data.
    write: function(val, oldVal) {
        var number = +val.replace(/[^\d.]/g, '')
        return isNaN(number) ? 0 : number
    }
})