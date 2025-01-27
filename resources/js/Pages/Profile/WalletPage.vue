<template>
    <BaseLayout>
        <div class="md:w-4/6 2xl:w-4/6 mx-auto mt-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="col-span-1 hidden md:block">
                    <WalletSideMenu />
                </div>
                <div class="relative col-span-2">
                    <div v-if="!isLoadingWallet" class="flex flex-col w-full bg-gray-200 hover:bg-gray-300/20 dark:bg-gray-800/50 p-4 rounded hover:dark:bg-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 w-full">
                            <div class="flex w-full">
                                <div class="rounded-full ring-2 ring-gray-200 px-4 py-2 text-center flex justify-center items-center">
                                    <i class="fa-sharp fa-regular fa-dollar-sign text-2xl"></i>
                                </div>
                                <div class="leading-4 ml-3">
                                    <span>{{ $t('Total Balance') }}</span>
                                    <h1 class="text-lg font-bold text-yellow-400">{{ state.currencyFormat(parseFloat(wallet.total_balance), wallet.currency) }}</h1>
                                </div>
                            </div>
                            <div class="flex w-full">
                                <div class="rounded-full ring-2 ring-gray-200 px-4 py-2 text-center flex justify-center items-center">
                                    <i class="fa-sharp fa-regular fa-dollar-sign text-2xl"></i>
                                </div>
                                <div class="leading-4 ml-3">
                                    <span>{{ $t('Withdrawal Balance') }}</span>
                                    <h1 class="text-lg font-bold text-yellow-400">{{ state.currencyFormat(parseFloat(wallet.balance_withdrawal), wallet.currency) }}</h1>
                                </div>
                            </div>
                            <div class="flex w-full">
                                <div class="rounded-full ring-2 ring-gray-200 px-4 py-2 text-center flex justify-center items-center">
                                    <i class="fa-sharp fa-regular fa-dollar-sign text-2xl"></i>
                                </div>
                                <div class="leading-4 ml-3">
                                    <span>{{ $t('Balance Rollover') }}</span>
                                    <h1 class="text-lg font-bold text-yellow-400">{{ state.currencyFormat(parseFloat(wallet.balance), wallet.currency) }}</h1>
                                </div>
                            </div>
                            <div class="flex w-full">
                                <div class="rounded-full ring-2 ring-gray-200 px-4 py-2 text-center flex justify-center items-center">
                                    <i class="fa-sharp fa-regular fa-dollar-sign text-2xl"></i>
                                </div>
                                <div class="leading-4 ml-3">
                                    <span>{{ $t('Balance Bonus') }}</span>
                                    <h1 class="text-lg font-bold text-yellow-400">{{ state.currencyFormat(parseFloat(wallet.balance_bonus), wallet.currency) }}</h1>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                            <a @click.prevent="$router.push('/profile/deposit')" href="" class="flex bg-white dark:bg-gray-900 p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                                <div class="text-5xl mr-3">
                                    <i class="fa-light fa-money-simple-from-bracket"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h1 class="text-lg">{{ $t('Deposit') }}</h1>
                                    <p class="text-sm dark:text-gray-500">{{ $t('Click here to deposit') }}</p>
                                </div>
                            </a>
                            <a @click.prevent="$router.push('/profile/withdraw')" href="" class="flex bg-white dark:bg-gray-900 p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                                <div class="text-5xl mr-3">
                                    <i class="fa-sharp fa-light fa-money-bill-transfer"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h1 class="text-lg">{{ $t('Withdraw') }}</h1>
                                    <p class="text-sm dark:text-gray-500">{{ $t('Click here to withdraw') }}</p>
                                </div>
                            </a>
                        </div>

                        <div class="mt-5 flex flex-col">
                            <h1 class="mb-3 text-2xl">{{ $t('My Wallets') }}</h1>
                            <div class="w-48 text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white w-full">
                                <button v-for="(wallet, index) in mywallets" :key="index" @click.prevent="setWallet(wallet.id)" type="button" class="relative inline-flex justify-between items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                                   <div class="flex items-center">
                                       <i class="fa-light fa-wallet text-3xl mr-2"></i>
                                       <div class="flex flex-col items-start">
                                           <p>{{ wallet.symbol }} {{ wallet.total_balance }}</p>
                                           <p class="text-[12px] dark:text-gray-500">{{ wallet.symbol }} {{ wallet.balance_bonus }}</p>
                                       </div>
                                   </div>

                                    <span v-if="wallet.active === 1" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Ativo</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-if="isLoadingWallet" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                        <span class="sr-only">{{ $t('Loading') }}...</span>
                    </div>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import { RouterLink } from "vue-router";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import WalletSideMenu from "@/Pages/Profile/Components/WalletSideMenu.vue";
import {useToast} from "vue-toastification";
import {useAuthStore} from "@/Stores/Auth.js";
import HttpApi from "@/Services/HttpApi.js";

export default {
    props: [],
    components: {WalletSideMenu, BaseLayout, RouterLink },
    data() {
        return {
            isLoading: false,
            isLoadingWallet: true,
            wallet: null,
            mywallets: null
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
        setWallet: function(id) {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;

            HttpApi.post('profile/mywallet/'+ id, {})
                .then(response => {
                   _this.getMyWallet();
                    _this.isLoadingWallet = false;
                    window.location.reload();

                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingWallet = false;
                });
        },
        getWallet: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;

            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;
                    _this.isLoadingWallet = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingWallet = false;
                });
        },
        getMyWallet: function() {
            const _this = this;
            const _toast = useToast();

            HttpApi.get('profile/mywallet')
                .then(response => {
                    _this.mywallets = response.data.wallets;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                });
        },
    },
    created() {
        this.getWallet();
        this.getMyWallet();
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
