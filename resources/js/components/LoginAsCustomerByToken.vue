<script>
import { clear, loginByToken } from 'Vendor/rapidez/core/resources/js/stores/useUser'

export default {
    props: ['token'],

    render() {
        return this.$scopedSlots.default(this)
    },

    data: () => ({
        processing: false,
    }),

    mounted() {
        this.$nextTick(() => {
            if (this.token) {
                this.processing = true
                this.login().finally(
                    () => (this.processing = false),
                )
            }
        })
    },

    methods: {
        async login() {
            try {
                await clear()
                await loginByToken(this.token)

                Turbo.visit(window.url('/account'))
            } catch (error) {
                Notify(error.message, 'error')
            }
        }
    },
}
</script>
