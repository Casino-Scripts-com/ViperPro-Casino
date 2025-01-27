<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>{{ $t('Loading your bets') }}</span>
            </div>
        </LoadingComponent>

        <div class="p-4">
            <div class="bets-header font-bold">
                <div class="flex text-3xl items-center">
                    <i class="fa-light fa-book "></i>
                    <h1 class="ml-2 ">{{ $t('My bets') }}</h1>
                </div>
            </div>

            <!-- Navegação e filtro -->
<!--            <div class="flex justify-between items-center scrollable-container">-->
<!--                <div class="bets-options flex gap-4 mt-5 scrollable-content">-->
<!--                    <button class="bg-green-500 rounded-full px-4 py-2 font-bold text-white">-->
<!--                        Todas-->
<!--                    </button>-->

<!--                    <button class="bg-gray-200 dark:bg-gray-700/20 rounded-full px-4 py-2 font-bold text-gray-500 dark:text-white">-->
<!--                        Pendentes-->
<!--                    </button>-->

<!--                    <button class="bg-gray-200 dark:bg-gray-700/20 rounded-full px-4 py-2 font-bold text-gray-500 dark:text-white">-->
<!--                        Vitorias-->
<!--                    </button>-->

<!--                    <button class="bg-gray-200 dark:bg-gray-700/20 rounded-full px-4 py-2 font-bold text-gray-500 dark:text-white">-->
<!--                        Perdas-->
<!--                    </button>-->

<!--                    <button class="bg-gray-200 dark:bg-gray-700/20 rounded-full px-4 py-2 font-bold text-gray-500 dark:text-white">-->
<!--                        Cash Out-->
<!--                    </button>-->

<!--                    <button class="bg-gray-200 dark:bg-gray-700/20 rounded-full px-4 py-2 font-bold text-gray-500 dark:text-white">-->
<!--                        Canceladas-->
<!--                    </button>-->
<!--                </div>-->
<!--                <div class="">-->
<!--                    <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox" class="text-white bg-gray-700 hover:bg-gray-700/20 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" type="button">-->
<!--                        Filtro-->
<!--                        <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">-->
<!--                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>-->
<!--                        </svg>-->
<!--                    </button>-->

<!--                    &lt;!&ndash; Dropdown menu &ndash;&gt;-->
<!--                    <div id="dropdownDefaultCheckbox" class="z-10 hidden w-96 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-600">-->
<!--                        <ul class="p-4 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">-->
<!--                            <li class="grid grid-cols-2 gap-2">-->
<!--                                <button class="bg-gray-200 dark:bg-gray-700/20 rounded-full px-4 py-2 font-bold text-gray-500 dark:text-white">-->
<!--                                    Hoje-->
<!--                                </button>-->
<!--                                <button class="bg-gray-200 dark:bg-gray-700/20 rounded-full px-4 py-2 font-bold text-gray-500 dark:text-white">-->
<!--                                    Última semana-->
<!--                                </button>-->
<!--                            </li>-->
<!--                            <li class="grid grid-cols-2 gap-2">-->
<!--                                <button class="bg-gray-200 dark:bg-gray-700/20 rounded-full px-4 py-2 font-bold text-gray-500 dark:text-white">-->
<!--                                    Último mês-->
<!--                                </button>-->
<!--                                <button class="bg-gray-200 dark:bg-gray-700/20 rounded-full px-4 py-2 font-bold text-gray-500 dark:text-white">-->
<!--                                    Última Apostas-->
<!--                                </button>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div date-rangepicker class="flex items-center">-->
<!--                                    <div class="relative">-->
<!--                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">-->
<!--                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">-->
<!--                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>-->
<!--                                            </svg>-->
<!--                                        </div>-->
<!--                                        <input id="datepickerStart" name="start"-->
<!--                                               type="text"-->
<!--                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"-->
<!--                                               placeholder="Select date start">-->
<!--                                    </div>-->
<!--                                    <span class="mx-4 text-gray-500">to</span>-->
<!--                                    <div class="relative">-->
<!--                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">-->
<!--                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">-->
<!--                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>-->
<!--                                            </svg>-->
<!--                                        </div>-->
<!--                                        <input id="datepickerEnd" name="end"-->
<!--                                               type="text"-->
<!--                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"-->
<!--                                               placeholder="Select date end">-->
<!--                                    </div>-->
<!--                                </div>-->

<!--                            </li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <div class="mybets-container mt-5 mb-16">
                <div v-if="bets" class="relative overflow-x-auto">
                    <div v-for="(bets, inx) in bets.data" :key="inx" class="mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div v-for="(bet, index) in bets.sport_bets_odds" :key="index" class="w-full shadow bg-gray-200 dark:bg-gray-600/20">
                                <div class="header flex w-full border-l-4 border-green-500 p-4" >
                                    <h4>{{ bet.team_home_name }}  x {{ bet.team_away_name }}</h4>
                                </div>

                                <div class="body p-4">
                                    <ul>
                                        <li class="flex justify-between">
                                            <strong>{{ $t('Odd Name:') }}</strong>
                                            <span>{{ bet.odds_name }}</span>
                                        </li>
                                        <li class="flex justify-between">
                                            <strong>{{ $t('Odd Value:') }}</strong>
                                            <span>{{ bet.odds_value }}</span>
                                        </li>
                                        <li class="flex justify-between">
                                            <strong>{{ $t('Odd Multiplier:') }}</strong>
                                            <span>{{ bet.odds_odd }}</span>
                                        </li>
                                    </ul>
                                    <div class="flex justify-between mt-6">
                                        <div>
                                            <p><strong>{{ $t('Status') }}</strong></p>
                                            {{ bet.status_long }}
                                        </div>
                                        <div>
                                            <p><strong>{{ $t('Date') }}</strong></p>
                                            {{ state.formatDate(bet.date)  }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <CustomPagination :data="bets" @pagination-change-page="getBets"/>
                    </div>
                </div>

                <div v-else class="text-center flex flex-col justify-center items-center">
                    <svg width="152" height="156" data-editor-id="emptyBetsIcon"><g fill="#43B309" fill-rule="evenodd"><path d="M18.78 39.62a2 2 0 013.198 2.402 69.863 69.863 0 00-9.385 16.984 2 2 0 01-3.736-1.429 73.862 73.862 0 019.922-17.956zm-8.943 73.234a2 2 0 113.683-1.56 69.89 69.89 0 007.742 13.712 2 2 0 01-3.24 2.346 73.89 73.89 0 01-8.185-14.498zm128.226 14.38a2 2 0 11-3.245-2.339C143.342 113.075 148 98.891 148 84c0-14.736-4.562-28.782-12.922-40.533a2 2 0 113.26-2.319C147.174 53.571 152 68.426 152 84c0 15.737-4.927 30.738-13.937 43.235zM105.268 15.187a2 2 0 01-1.475 3.719C95.657 15.678 86.946 14 78 14c-6.724 0-13.32.948-19.647 2.794a2 2 0 11-1.121-3.84A74.026 74.026 0 0178 10c9.453 0 18.664 1.774 27.268 5.186z" opacity="0.7"></path><path d="M12 7.96h5.46a2 2 0 110 4H12v5.461a2 2 0 11-4 0v-5.46H2.54a2 2 0 110-4H8V2.5a2 2 0 114 0v5.46z" opacity="0.3"></path><path d="M126 97.96h5.46a2 2 0 010 4H126v5.461a2 2 0 11-4 0v-5.46h-5.46a2 2 0 110-4H122V92.5a2 2 0 014 0v5.46z" opacity="0.4"></path><path d="M145.5 16.48h2.23a1.5 1.5 0 010 3h-2.23v2.23a1.5 1.5 0 01-3 0v-2.23h-2.23a1.5 1.5 0 010-3h2.23v-2.23a1.5 1.5 0 013 0v2.23z" opacity="0.2"></path><g fill="rgba(255,255,255,0.4)"><path fill-rule="nonzero" d="M41.95 59H124a4 4 0 004-4V28a4 4 0 00-4-4H42m.037-2H124a6 6 0 016 6v27a6 6 0 01-6 6H42.01"></path><path d="M32 22h10v39H32a6 6 0 01-6-6V28a6 6 0 016-6zm16.5 5a2.5 2.5 0 110 5 2.5 2.5 0 010-5zm8 1h34a1.5 1.5 0 010 3h-34a1.5 1.5 0 010-3zM48 35h59a1 1 0 010 2H48a1 1 0 010-2zm0 5h30a1 1 0 010 2H48a1 1 0 010-2zm1.5 10h5a2.5 2.5 0 110 5h-5a2.5 2.5 0 110-5z"></path></g><g fill="rgba(255,255,255,0.4)"><path fill-rule="nonzero" d="M15.95 104H98a4 4 0 004-4V73a4 4 0 00-4-4H16m.037-2H98a6 6 0 016 6v27a6 6 0 01-6 6H16.01"></path><path d="M6 67h10v39H6a6 6 0 01-6-6V73a6 6 0 016-6zm16.5 5a2.5 2.5 0 110 5 2.5 2.5 0 010-5zm8 1h34a1.5 1.5 0 010 3h-34a1.5 1.5 0 010-3zM22 80h59a1 1 0 010 2H22a1 1 0 010-2zm0 5h30a1 1 0 010 2H22a1 1 0 010-2zm1.5 10h5a2.5 2.5 0 110 5h-5a2.5 2.5 0 110-5z"></path></g><g fill="rgba(255,255,255,0.4)"><path fill-rule="nonzero" d="M41.95 153H124a4 4 0 004-4v-27a4 4 0 00-4-4H42m.037-2H124a6 6 0 016 6v27a6 6 0 01-6 6H42.01"></path><path d="M32 116h10v39H32a6 6 0 01-6-6v-27a6 6 0 016-6zm16.5 5a2.5 2.5 0 110 5 2.5 2.5 0 010-5zm8 1h34a1.5 1.5 0 010 3h-34a1.5 1.5 0 010-3zm-8.5 7h59a1 1 0 010 2H48a1 1 0 010-2zm0 5h30a1 1 0 010 2H48a1 1 0 010-2zm1.5 10h5a2.5 2.5 0 110 5h-5a2.5 2.5 0 110-5z"></path></g></g></svg>

                    <div class="mt-5">
                        <p class="text-2xl">
                            {{ $t('You have no bets available') }}
                        </p>

                        <p class="text-2xl">
                            {{ $t('Choose different dates') }}
                        </p>
                    </div>

                    <RouterLink :to="{ name: 'home' }" class="uppercase mt-5 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" active-class="top-menu-active" >
                        {{ $t('Go to main page') }}
                    </RouterLink>

                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";
import Datepicker from 'flowbite-datepicker/Datepicker';
import { RouterLink } from "vue-router";
import {useToast} from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import CustomPagination from "@/Components/UI/CustomPagination.vue";

export default {
    props: [],
    components: {CustomPagination, LoadingComponent, BaseLayout, RouterLink },
    data() {
        return {
            isLoading: false,
            bets: null
        }
    },
    setup(props) {


        return {};
    },
    computed: {

    },
    mounted() {
        // const datepickerStart = document.getElementById('datepickerStart');
        // const datepickerEnd = document.getElementById('datepickerEnd');
        //
        // new Datepicker(datepickerStart, {
        //     // options
        // });
        //
        // new Datepicker(datepickerEnd, {
        //     // options
        // });
    },
    methods: {
        getBets: function() {
            const _this = this;
            _this.isLoading = true;

            HttpApi.get('sports/football/bets')
                .then(response => {
                    _this.bets = response.data.bets;
                    _this.isLoading = false;
                })
                .catch(error => {

                    _this.isLoading = false;
                });
        },
    },
    created() {
        this.getBets();
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
