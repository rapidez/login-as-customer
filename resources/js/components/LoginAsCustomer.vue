<script>
import { token } from 'Vendor/rapidez/core/resources/js/stores/useUser'
import { fetchCustomerCart } from 'Vendor/rapidez/core/resources/js/stores/useCart'
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
                let adminResponse = await window.magentoAPI('post', 'integration/admin/token', {
                    username: this.username,
                    password: this.password,
                })

                let tokenResponse = await window.magentoGraphQL(
                    'mutation token($customer: String!) { generateCustomerTokenAsAdmin( input: { customer_email: $customer }) { customer_token } }',
                    { customer: this.customer },
                    { headers: { Authorization: 'Bearer ' + adminResponse} }
                )

                if (tokenResponse.errors) {
                    Notify(tokenResponse.errors[0].message, 'error')
                    return
                }

                token.value = tokenResponse.data.generateCustomerTokenAsAdmin.customer_token

                await this.refreshUser(false)
                this.setCheckoutCredentialsFromDefaultUserAddresses()
                await window.app.$emit('logged-in')
                await fetchCustomerCart()

                Turbo.visit(window.url('/account'))
            } catch (error) {
                Notify(error.message, 'error')
            }
        },

        inputChange(e) {
            this[e.target.id] = e.target.value
        },
    },
}
</script>
