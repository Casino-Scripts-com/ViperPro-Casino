<template>
    <div id="side-box" class="w-full-mobile md:w-[350px]">
        <div id="side-box-header" class="p-4 flex justify-between" @click.prevent="toggleSideBox">
            <div class="flex items-center">
                <img :src="`/assets/images/icons/document.svg`" alt="" width="38" class="mr-2">
                <div class="text-white leading-6">
                    {{ $t('Betting Bulletin') }} <span v-if="sportStore.bets.length > 0" class="font-bold">({{ sportStore.bets.length }})</span>
                </div>
            </div>
            <div class="mr-4 text-white">
                <i class="fa-solid" :class="{'fa-chevron-down': sideBoxOp, 'fa-chevron-up': !sideBoxOp}"></i>
            </div>
        </div>
        <div id="side-box-body" ref="sideBoxBody" :style="bodyStyle">
            <div id="side-box-body-content" ref="sideBoxContent">
                <div class="mb-2 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400" id="tabs-betting" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                    id="simple-tab-action"
                                    type="button"
                                    role="tab"
                                    aria-controls="simple-tab"
                                    aria-selected="false">
                                {{ $t('Simple') }}
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                    id="multiple-tab-action"
                                    type="button"
                                    role="tab"
                                    aria-controls="multiple-tab"
                                    aria-selected="false">
                                {{ $t('Multiple') }}
                            </button>
                        </li>
                    </ul>
                </div>
                <div id="tabContentExample" class="">

                    <!-- Single -->
                    <div class="hidden p-4 rounded-lg " id="simple-tab" role="tabpanel" aria-labelledby="simple-tab-action">
                        <div v-if="isAuthenticated"  class="list-selection">
                            <div v-if="wallet">
                                <!-- box apostas -->
                                <div v-if="isLoadingSingle === false" class="h-[42vh] overflow-y-auto overflow-x-hidden overflow-hidden-y-scroll pr-3 mb-3">
                                    <div v-for="(bet, index) in sportStore.bets" :key="index" class="relative w-full mb-4">
                                        <button @click.prevent="removeBet(bet, index)" type="button" class="transition duration-700 absolute top-0 left-0 px-4 h-full text-sm font-medium text-gray-400 bg-gray-700 rounded-l-lg border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                            <i class="fa-solid fa-x"></i>
                                        </button>

                                        <div class="block pl-14 p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-l-lg rounded-r-lg border-r-2 border-r-blue-500 dark:border-r-blue-500  focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600/20 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500">
                                            <div>
                                                <p class="mb-3 font-bold">
                                                    <i class="fa-regular fa-globe mr-2"></i>
                                                    <span v-if="bet.referee">{{ bet.referee }}</span>
                                                    <span v-else>{{ $t('No referee') }}</span>
                                                </p>
                                                <p>{{ bet.team_home_name }} vs. {{ bet.team_away_name }}</p>
                                                <p class="mb-2">{{ bet.bets.name }} - {{ bet.oddsSelected.value }}</p>
                                                <div class="flex justify-between items-center">
                                                    <div class="font-bold mr-3">
                                                        {{ bet.oddsSelected.odd }}
                                                    </div>
                                                    <div>
                                                        <input @input="changeAmount($event, bet)" min="1" type="number" :id="bet.id" placeholder="" class="input" v-model="bet.bet_amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="h-[42vh]">
                                    <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                        <span class="sr-only">{{ $t('Loading') }}...</span>
                                    </div>
                                </div>

                                <!-- valores aposta -->
                                <div class="grid grid-cols-4 gap-4">
                                    <button @click.prevent="setAmount(10)" type="button" class="px-3 py-2 bg-gray-50 dark:bg-gray-600/20 rounded-lg shadow">
                                        {{ wallet.symbol }} 10
                                    </button>
                                    <button @click.prevent="setAmount(25)" type="button" class="px-3 py-2 bg-gray-50 dark:bg-gray-600/20 rounded-lg shadow">
                                        {{ wallet.symbol }} 25
                                    </button>
                                    <button @click.prevent="setAmount(50)" type="button" class="px-3 py-2 bg-gray-50 dark:bg-gray-600/20 rounded-lg shadow">
                                        {{ wallet.symbol }} 50
                                    </button>
                                    <button @click.prevent="setAmount(75)" type="button" class="px-3 py-2 bg-gray-50 dark:bg-gray-600/20 rounded-lg shadow">
                                        {{ wallet.symbol }} 75
                                    </button>
                                </div>

                                <div class="bet-gains mt-5 mb-5">
                                    <div class="flex justify-between text-gray-400">
                                        <p>{{ $t('Total Bet') }}</p>
                                        <p>{{ state.currencyFormat(totalBet, wallet.currency) }}</p>
                                    </div>
                                    <div class="flex justify-between text-gray-500 dark:text-white">
                                        <p class="font-bold uppercase">{{ $t('POTENTIAL WIN') }}</p>
                                        <p class="font-bold">{{ state.currencyFormat(totalEarnings, wallet.currency) }}</p>
                                    </div>
                                </div>

                                <div class="mt-5 mb-5">
                                    <button type="button" @click.prevent="submitBets" :disabled="!isSingleBetActive" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        {{ $t('PLACE BET') }}
                                    </button>
                                </div>

                                <div class="mt-5 flex justify-between">
                                    <a @click.prevent="clearSelection" href="" class="text-gray-500">
                                        <i class="fa-solid fa-trash-can mr-2"></i> {{ $t('Clear Betslip') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div v-else class="p-4">
                            <div class="flex w-full">
                                <div class="mr-2"><i class="fa-regular fa-user text-2xl"></i></div>
                                <div>
                                    <p>{{ $t('Log in to place your bets') }}</p>
                                </div>
                            </div>
                            <div class="mt-5 w-full">
                                <button type="button" @click="$router.push('/login')" class="w-full w-button ui-button-blue">{{ $t('Log in') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- Multiple -->
                    <div class="hidden p-4 rounded-lg" id="multiple-tab" role="tabpanel" aria-labelledby="multiple-tab-action">
                        <div v-if="isAuthenticated"  class="list-selection">
                            <div v-if="wallet">
                                <!-- box apostas -->
                                <div v-if="isLoadingMultiple === false" class="h-[42vh] overflow-y-auto overflow-x-hidden overflow-hidden-y-scroll pr-3 mb-3">
                                    <div v-for="(bet, index) in sportStore.bets" :key="index" class="relative w-full mb-4">
                                        <button @click.prevent="removeBet(bet, index)" type="button" class="transition duration-700 absolute top-0 left-0 px-4 h-full text-sm font-medium text-gray-400 bg-gray-700 rounded-l-lg border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                            <i class="fa-solid fa-x"></i>
                                        </button>

                                        <div class="block pl-14 p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-l-lg rounded-r-lg border-r-2 border-r-blue-500 dark:border-r-blue-500  focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600/20 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500">
                                            <div>
                                                <p class="mb-3 font-bold">
                                                    <i class="fa-regular fa-globe mr-2"></i>
                                                    <span v-if="bet.referee">{{ bet.referee }}</span>
                                                    <span v-else>{{ $t('No referee') }}</span>
                                                </p>
                                                <p>{{ bet.team_home_name }} vs. {{ bet.team_away_name }}</p>
                                                <p class="mb-2">{{ bet.bets.name }} - {{ bet.oddsSelected.value }}</p>
                                                <div class="flex justify-between items-center">
                                                    <div class="font-bold mr-3">
                                                        {{ bet.oddsSelected.odd }}
                                                    </div>
                                                    <div>
                                                        <input @input="changeAmount($event, bet)" min="1" type="number" :id="bet.fixture_id" placeholder="" class="input" v-model="bet.bet_amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="h-[42vh]">
                                    <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                        <span class="sr-only">{{ $t('Loading') }}...</span>
                                    </div>
                                </div>

                                <!-- valores aposta -->
                                <div class="grid grid-cols-4 gap-4">
                                    <button @click.prevent="setAmount(10)" type="button" class="px-3 py-2 bg-gray-50 dark:bg-gray-600/20 rounded-lg shadow">
                                        {{ wallet.symbol }} 10
                                    </button>
                                    <button @click.prevent="setAmount(25)" type="button" class="px-3 py-2 bg-gray-50 dark:bg-gray-600/20 rounded-lg shadow">
                                        {{ wallet.symbol }} 25
                                    </button>
                                    <button @click.prevent="setAmount(50)" type="button" class="px-3 py-2 bg-gray-50 dark:bg-gray-600/20 rounded-lg shadow">
                                        {{ wallet.symbol }} 50
                                    </button>
                                    <button @click.prevent="setAmount(75)" type="button" class="px-3 py-2 bg-gray-50 dark:bg-gray-600/20 rounded-lg shadow">
                                        {{ wallet.symbol }} 75
                                    </button>
                                </div>

                                <div class="bet-gains mt-5 mb-5">
                                    <div class="flex justify-between text-gray-400">
                                        <p>{{ $t('Total Bet') }}</p>
                                        <p>{{ state.currencyFormat(totalBet, wallet.currency) }}</p>
                                    </div>
                                    <div class="flex justify-between text-gray-500 dark:text-white">
                                        <p class="font-bold uppercase">{{ $t('POTENTIAL WIN') }}</p>
                                        <p class="font-bold">{{ state.currencyFormat(totalEarnings, wallet.currency) }}</p>
                                    </div>
                                </div>

                                <div class="mt-5 mb-5">
                                    <button @click="submitMultipleBets" :disabled="!isMultipleBetActive" type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        {{ $t('PLACE BET') }}
                                    </button>
                                </div>

                                <div class="mt-5 flex justify-between">
                                    <a @click.prevent="clearSelection" href="" class="text-gray-500">
                                        <i class="fa-solid fa-trash-can mr-2"></i> {{ $t('Clear Betslip') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div v-else class="p-4">
                            <div class="flex w-full">
                                <div class="mr-2"><i class="fa-regular fa-user text-2xl"></i></div>
                                <div>
                                    <p>{{ $t('Log in to place your bets') }}</p>
                                </div>
                            </div>
                            <div class="mt-5 w-full">
                                <button type="button" @click="$router.push('/login')" class="w-full w-button ui-button-blue">{{ $t('Log in') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { watch, ref } from 'vue';
import { Tabs } from 'flowbite';
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import HttpApi from "@/Services/HttpApi.js";

import {useAuthStore} from "@/Stores/Auth.js";
import {useSportBetStore} from "@/Stores/SportBet.js";
import {computed} from "vue";
import {useToast} from "vue-toastification";

export default {
    props: [],
    components: {BaseLayout, LoadingComponent},
    data() {
        return {
            isSingleBetActive: false,
            isMultipleBetActive: false,
            isLoadingSingle: false,
            isLoadingMultiple: false,
            isLoading: false,
            sideBoxOp: false,
            tabs: null,
            sportStore: useSportBetStore(),
            betAmounts: [],
            totalBet: 0,
            totalEarnings: 0,
            wallet: null,
        }
    },
    setup() {
        const authStore = useAuthStore();
        const isAuthenticated = computed(() => authStore.isAuth);

        return {
            isAuthenticated,
        };
    },
    computed: {
        bodyStyle() {
            return {
                height: this.sideBoxOp ? 'auto' : '0px',
            };
        }
    },
    mounted() {
        const tabsElement = document.getElementById('tabs-betting');
        const tabElements = [
            {
                id: 'profile',
                triggerEl: document.querySelector('#simple-tab-action'),
                targetEl: document.querySelector('#simple-tab')
            },
            {
                id: 'dashboard',
                triggerEl: document.querySelector('#multiple-tab-action'),
                targetEl: document.querySelector('#multiple-tab')
            },
        ];
        const options = {
            defaultTabId: 'settings',
            activeClasses: 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-400 border-blue-600 dark:border-blue-500',
            inactiveClasses: 'text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300',
            onShow: () => {

            }
        };

        this.tabs = new Tabs(tabsElement, tabElements, options);
    },
    methods: {
        removeBet: function(bet, index) {

            this.betAmounts.splice(index, 1);
            this.sportStore.removeBet(bet);

            this.updateAmount();
        },
        clearSelection: function() {
            this.sportStore.clearAllBets();
            this.isSingleBetActive = false;
            this.isMultipleBetActive = false;
            this.tabs.show('profile');
        },
        changeAmount: function(event, bet) {
            const newValue = event.target.value;
            //const idValue = event.target.getAttribute('id');
            this.sportStore.updateAmountBet(bet, parseFloat(newValue));
            this.updateAmount();
        },
        updateAmount: function() {
            const _this = this;

            let soma = 0;
            let odds = 0;
            let gains = 0;
            _this.sportStore.bets.forEach((bet) => {
                const odd = parseFloat(bet.oddsSelected.odd);
                odds       = odds + odd;
                soma       = soma + parseFloat(bet.bet_amount);

                let gain   = bet.bet_amount * parseFloat(odd);
                gains      = parseFloat(gains) + parseFloat(gain);
            });

            this.totalBet = parseFloat(soma);
            this.totalEarnings = parseFloat(gains);
        },
        setAmount: function(amount) {
            this.sportStore.updateAllAmountBet(amount);
            this.updateAmount();
        },
        toggleSideBox: function() {
            const _this = this;
            _this.sideBoxOp = !_this.sideBoxOp;
            if (_this.sideBoxOp) {
                _this.$nextTick(() => {
                    const height = _this.$refs.sideBoxContent.clientHeight;
                    _this.$refs.sideBoxBody.style.height = `${height}px`;
                });
            } else {
                _this.$refs.sideBoxBody.style.height = '0px';
            }
        },
        getWallet: function() {
            const _this = this;
            _this.isLoading = true;

            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;
                    _this.isLoading = false;
                })
                .catch(error => {
                    _this.isLoading = false;
                });
        },
        submitBets: function() {
            const _this = this;
            const singleBets = _this.sportStore.bets;
            const _toast = useToast();
            _this.isLoadingSingle = true;

            HttpApi.post('sports/football/events/store-single', {
                total_bets: _this.totalBet,
                total_earnings: _this.totalEarnings,
                bets: singleBets
            })
            .then(response => {
                _toast.success(response.data.message);
                _this.clearSelection();
                _this.isLoadingSingle = false;
            })
            .catch(error => {
                Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                    _toast.error(`${value}`);
                });
                _this.isLoadingSingle = false;
            });
        },
        submitMultipleBets: function() {
            const _this = this;
            const singleBets = _this.sportStore.bets;
            const _toast = useToast();
            _this.isLoadingMultiple = true;

            HttpApi.post('sports/football/events/store-multiple', {
                total_bets: _this.totalBet,
                total_earnings: _this.totalEarnings,
                bets: singleBets
            })
                .then(response => {
                    _toast.success(response.data.message);
                    _this.clearSelection();
                    _this.isLoadingMultiple = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingMultiple = false;
                });
        }
    },
    created() {
        if(this.isAuthenticated) {
            this.getWallet();
        }
    },
    watch: {
        isAuthenticated(newValue, oldValue) {
            this.getWallet();
        },
        'sportStore.bets.length'(newValue, oldValue) {
            const _this = this;
            if (_this.sportStore.bets) {
                _this.updateAmount();

                if(_this.sportStore) {

                    const newBetId = newValue > 0 ? _this.sportStore.bets[0]?.id : null;
                    const oldBetId = oldValue > 0 ? _this.sportStore.bets[oldValue - 1]?.id : null;

                    if(newBetId != null && oldBetId != null) {
                        if (newBetId !== oldBetId) {
                            // Ativar a guia "Multiple"
                            _this.tabs.show('dashboard');
                            _this.isSingleBetActive = false;
                            _this.isMultipleBetActive = true;
                        }else{
                            _this.tabs.show('profile');
                            _this.isSingleBetActive = true;
                            _this.isMultipleBetActive = false;
                        }
                    }
                }

            }
        },
    }
};
</script>

<style scoped>
    #side-box {
        position: fixed;
        right: 0px;
        bottom: 0px;
        padding: 0px;
        max-height: 100vh;
        background-color: #0073D2;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        z-index: 999;
    }
    #side-box-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: nowrap;
        margin: 3px;
        height: 56px;
        cursor: pointer;
    }
    #side-box-body {
        margin: 0px;
        padding: 0px 3px;
        overflow: hidden;
        background-color: #1a242d;
        transition: height 1s;
    }
    #side-box-body-content {

    }
</style>
