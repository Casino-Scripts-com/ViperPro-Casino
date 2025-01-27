<template>
    <BaseLayout>
        <div class="md:w-4/6 2xl:w-4/6 mx-auto p-4 mt-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="col-span-1 hidden md:block">
                    <WalletSideMenu/>
                </div>
                <div class="col-span-2 relative">
                    <div v-if="isLoading === false && wallet" class="flex flex-col w-full bg-gray-200 hover:bg-gray-300/20 dark:bg-gray-700 p-4 rounded">
                        <div class="header flex w-full mb-3">
                            <i class="fa-light fa-money-bill-transfer text-5xl mr-3"></i>
                            <div class="flex flex-col">
                                <h1 class="text-2xl font-bold">{{ $t('Withdrawal List') }}</h1>
                                <p class="text-gray-400 text-sm">{{ $t('Below is the list of all requested withdrawals') }}</p>
                            </div>
                        </div>

                        <div v-if="withdraws && wallet" class="mt-3">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400  border dark:border-gray-600">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Proof') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Type') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Value') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Status') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Date') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(withdraw, index) in withdraws.data" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-6 py-4">
                                                <a v-if="withdraw.proof" href="" class="flex">
                                                    <i class="fa-regular fa-file-export mr-2"></i>
                                                    {{ $t('Click here') }}
                                                </a>
                                                <span v-else>{{ $t('Processing') }}</span>
                                            </td>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <span class="uppercase">{{ withdraw.type }}</span>
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ state.currencyFormat(parseFloat(withdraw.amount), withdraw.currency) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span v-if="withdraw.status === 1" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $t('Concluded') }}</span>
                                                <span v-if="withdraw.status === 0" class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">{{ $t('Pending') }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ withdraw.dateHumanReadable }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="header flex w-full mb-3 mt-5">
                            <i class="fa-light fa-money-bill-transfer text-5xl mr-3"></i>
                            <div class="flex flex-col">
                                <h1 class="text-2xl font-bold">{{ $t('Deposits List') }}</h1>
                                <p class="text-gray-400 text-sm">{{ $t('List of deposits made') }}</p>
                            </div>
                        </div>

                        <div v-if="deposits && wallet" class="mt-3">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400  border dark:border-gray-600">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Type') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Value') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Status') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ $t('Date') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(deposit, index) in deposits.data" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <span class="uppercase">{{ deposit.type }}</span>
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ state.currencyFormat(parseFloat(deposit.amount), deposit.currency) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span v-if="deposit.status === 1" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $t('Concluded') }}</span>
                                                <span v-if="deposit.status === 0" class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">{{ $t('Pending') }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ deposit.dateHumanReadable }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div v-if="isLoading" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                        <span class="sr-only">{{ $t('Loading') }}...</span>
                    </div>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import {RouterLink} from "vue-router";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import WalletSideMenu from "@/Pages/Profile/Components/WalletSideMenu.vue";
import {useToast} from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import CustomPagination from "@/Components/UI/CustomPagination.vue";
import {useAuthStore} from "@/Stores/Auth.js";

export default {
    props: [],
    components: {CustomPagination, WalletSideMenu, BaseLayout, RouterLink},
    data() {
        return {
            isLoading: false,
            wallet: {},
            withdraws: null,
            deposits: null,
        }
    },
    setup(props) {


        return {};
    },
    computed: {
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        },
    },
    mounted() {

    },
    methods: {
        getWallet: function() {
            const _this = this;
            const _toast = useToast();

            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                });
        },
        getWithdraws: function() {
            const _this = this;
            _this.isLoading = true;

            HttpApi.get('wallet/withdraw')
                .then(response => {
                    _this.withdraws = response.data.withdraws;
                    _this.isLoading = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        console.log(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
        getDeposits: function() {
            const _this = this;
            _this.isLoading = true;

            HttpApi.get('wallet/deposit')
                .then(response => {
                    _this.deposits = response.data.deposits;
                    _this.isLoading = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        console.log(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
    },
    created() {
        this.getWallet();
        this.getWithdraws();
        this.getDeposits();
    },
    watch: {},
};
</script>

<style scoped>

</style>
