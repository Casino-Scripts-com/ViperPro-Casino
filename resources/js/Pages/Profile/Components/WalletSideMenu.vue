<template>
    <h1 class="text-2xl font-bold mb-3">{{ $t('Wallet') }}</h1>
    <div class="bg-gray-100 dark:bg-gray-700 w-full rounded shadow">
        <ul>
            <li class="w-full mb-3">
                <RouterLink :to="{ name: 'profileWallet' }"
                            active-class="wallet-active"
                            class="flex w-full bg-gray-200 hover:bg-gray-300/20 dark:bg-gray-800/50 px-4 py-3 rounded hover:dark:bg-gray-900 transition duration-700">
                    <span class="w-8"><i class="fa-light fa-wallet"></i></span>
                    <span>{{ $t('Balance') }}</span>
                </RouterLink>
            </li>

            <li class="w-full mb-3">
                <RouterLink :to="{ name: 'profileDeposit' }"
                            active-class="wallet-active"
                            class="flex w-full bg-gray-200 hover:bg-gray-300/20 dark:bg-gray-800/50 px-4 py-3 rounded hover:dark:bg-gray-900 transition duration-700">
                    <span class="w-8"><i class="fa-sharp fa-light fa-piggy-bank"></i></span>
                    <span>{{ $t('Deposit') }}</span>
                </RouterLink>
            </li>

            <li class="w-full mb-3">
                <RouterLink :to="{ name: 'profileWithdraw' }"
                            active-class="wallet-active"
                            class="flex w-full bg-gray-200 hover:bg-gray-300/20 dark:bg-gray-800/50 px-4 py-3 rounded hover:dark:bg-gray-900 transition duration-700">
                    <span class="w-8"><i class="fa-light fa-money-simple-from-bracket"></i></span>
                    <span>{{ $t('Withdraw') }}</span>
                </RouterLink>
            </li>

            <li class="w-full ">
                <RouterLink :to="{ name: 'profileTransactions' }"
                            active-class="wallet-active"
                            class="flex w-full bg-gray-200 hover:bg-gray-300/20 dark:bg-gray-800/50 px-4 py-3 rounded hover:dark:bg-gray-900 transition duration-700">
                    <span class="w-8"><i class="fa-solid fa-chart-mixed"></i></span>
                    <span>{{ $t('Transactions') }}</span>
                </RouterLink>
            </li>
        </ul>

    </div>
</template>

<script>

export default {
    props: [],
    components: {},
    data() {
        return {
            isLoading: false,
        }
    },
    setup(props) {


        return {};
    },
    computed: {

    },
    mounted() {

    },
    methods: {

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
