<script>
import { clear, loginByToken } from 'Vendor/rapidez/core/resources/js/stores/useUser'

export default {
    render() {
        return this.$scopedSlots.default(this)
    },

    data: () => ({
        username: '',
        password: '',
        customer: '',
    }),

    methods: {
        async login() {
            try {
                const clearPromise = clear()

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

                await clearPromise
                await loginByToken(tokenResponse.data.generateCustomerTokenAsAdmin.customer_token)

                Turbo.visit(window.url('/account'))
            } catch (error) {
                Notify(error.message, 'error')
            }
        }
    },
}
</script>
