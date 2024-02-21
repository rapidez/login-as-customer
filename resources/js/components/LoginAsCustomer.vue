<script>
import { useLocalStorage } from '@vueuse/core'
import { refresh as refreshCart } from 'Vendor/rapidez/resources/js/stores/useCart'
import InteractWithUser from 'Vendor/rapidez/core/resources/js/components/User/mixins/InteractWithUser'

export default {
    mixins: [InteractWithUser],

    render() {
        return this.$scopedSlots.default({
            inputChange: this.inputChange,
            username: this.username,
            password: this.password,
            customer: this.customer,
            login: this.login,
        })
    },

    data: () => ({
        username: '',
        password: '',
        customer: '',
    }),

    methods: {
        async login() {
            try {
                let adminResponse = await magento.post('integration/admin/token', {
                    username: this.username,
                    password: this.password,
                })

                let tokenResponse = await axios.post(config.magento_url + '/graphql', {
                    query: 'mutation token($customer: String!) { generateCustomerTokenAsAdmin( input: { customer_email: $customer }) { customer_token } }',
                    variables: { customer: this.customer },
                }, { headers: {
                    Authorization: 'Bearer ' + adminResponse.data,
                    Store: window.config.store_code,
                }})

                if (tokenResponse.data.errors) {
                    Notify(tokenResponse.data.errors[0].message, 'error')
                    return
                }

                let token = useLocalStorage('token', '');
                token.value = tokenResponse.data.data.generateCustomerTokenAsAdmin.customer_token
                window.magentoUser.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;

                await this.refreshUser(false)
                this.setCheckoutCredentialsFromDefaultUserAddresses()
                await window.app.$emit('logged-in')
                await refreshCart()

                Turbo.visit(window.url('/account'))
            } catch (error) {
                Notify(error.response.data.message, 'error')
            }
        },

        inputChange(e) {
            this[e.target.id] = e.target.value
        },
    },
}
</script>
