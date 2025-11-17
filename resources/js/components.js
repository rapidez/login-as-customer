import { defineAsyncComponent } from 'vue'

document.addEventListener('vue:loaded', function (event) {
    event.detail.vue.component('login-as-customer', defineAsyncComponent(() => import('./components/LoginAsCustomer.vue')))
    event.detail.vue.component('login-as-customer-by-token', defineAsyncComponent(() => import('./components/LoginAsCustomerByToken.vue')))
})
