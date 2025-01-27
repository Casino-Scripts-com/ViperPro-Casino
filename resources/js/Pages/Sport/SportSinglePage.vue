<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                Carregando detalhes da partida
            </div>
        </LoadingComponent>

        <div v-if="!isLoading" class="">
            <HeaderNav />

            <!-- painel de informações -->
            <div class="p-4">
                <div class="bg-gray-50 dark:bg-gray-600/20 p-4 rounded-lg">

                    <!-- header -->
                    <div class="flex justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="bt705 bt686" data-cy="sport-soccer" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="fill: currentcolor; color: inherit; width: auto; height: 16px;">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.04 21.3793C12.368 22.0323 13.8288 22.393 15.3425 22.4261L17.8734 19.5272C17.9026 17.8165 17.5076 16.1267 16.7246 14.6139L11.7195 13.4485C10.675 14.4949 9.86495 15.7551 9.35078 17.1439L11.04 21.3793ZM10.7764 22.204L9.08458 23.6141C10.9111 25.274 13.3374 26.2857 16 26.2857C16.511 26.2857 17.0133 26.2485 17.5043 26.1765L15.3359 23.2833C13.7356 23.25 12.1884 22.8783 10.7764 22.204ZM5.7343 16.6469H8.62297C9.20019 15.1755 10.086 13.8441 11.2164 12.7406V9.62205C10.2129 9.37945 9.1786 9.29054 8.14698 9.35692C6.6294 11.1491 5.71429 13.4677 5.71429 16C5.71429 16.2173 5.72102 16.433 5.7343 16.6469ZM22.9116 19.3483C23.8049 18.4384 24.5225 17.3714 25.0254 16.2017L23.6597 11.542C22.5016 10.9523 21.2395 10.587 19.9272 10.4698L17.6048 14.4567C18.3 15.8824 18.6825 17.4437 18.7275 19.033L22.9116 19.3483ZM23.4088 20.0636V23.1348C25.0358 21.4457 26.0906 19.2017 26.2613 16.7145L25.7741 16.6293C25.2096 17.9111 24.4065 19.0765 23.4088 20.0636ZM23.9985 9.53268C22.4866 7.66509 20.3338 6.33759 17.8747 5.88473C17.5281 6.28981 17.2149 6.71981 16.9371 7.17124L19.7454 9.596C21.1338 9.68779 22.4749 10.0354 23.7142 10.6149L23.9985 9.53268ZM16.0845 6.92604C16.3235 6.51838 16.5885 6.12608 16.8785 5.75128C16.5889 5.72678 16.2959 5.71429 16 5.71429C13.2876 5.71429 10.8204 6.76421 8.98261 8.47983C9.78915 8.49238 10.5923 8.59246 11.3784 8.77945C11.4114 8.75319 11.4487 8.73155 11.4894 8.71569L16.0845 6.92604ZM16 28C9.37258 28 4 22.6274 4 16C4 9.37258 9.37258 4 16 4C22.6274 4 28 9.37258 28 16C28 22.6274 22.6274 28 16 28Z"></path>
                            </svg>
                            <span>{{ event.league_country }}</span>
                            <div>
                                <svg class="bt707" data-cy="ic-rounded-arrow" width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="fill: currentcolor; color: inherit; width: auto; height: 8px;">
                                    <path d="M8.7542 11.1529C8.35634 11.6157 7.64366 11.6157 7.2458 11.1529L4.24545 7.66298C3.68586 7.01207 4.14485 6 4.99964 6L11.0004 6C11.8551 6 12.3141 7.01207 11.7546 7.66298L8.7542 11.1529Z"></path>
                                </svg>
                            </div>
                            <span>{{ event.league_name }}</span>
                        </div>
                        <div>
                            <a href="" class="text-gray-500"><i class="fa-solid fa-chart-simple"></i></a>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <div>
                            <img :src="`/storage/football/fixtures/`+state.generateSlug(event.team_home_name)+`.png`" alt="" width="56" class="mb-3">
                            <span class="font-bold">{{ event.team_home_name }}</span>
                        </div>
                        <div>
                            <div class="flex">
                                <div class="text-red-500 mr-2">
                                    <div v-if="event.status_long === 'First Half'
                                        || event.status_long === 'Kick Off'
                                        || event.status_long === 'Halftime'
                                        || event.status_long === 'Extra Time'
                                        || event.status_long === 'Break Time'
                                        || event.status_long === 'Penalty In Progress'
                                        || event.status_long === 'Penalty In Progress'
                                        || event.status_long === 'Match Suspended'
                                        || event.status_long === 'Match Interrupted'
                                        || event.status_long === 'In Progress'
                                        || event.status_long === 'Second Half'" class="text-red-500">
                                        <i class="fa-solid fa-signal-stream animate-pulse"></i>
                                    </div>
                                </div>
                                <span class="text-green-500"><p>{{ event.status_long }} <span v-if="event.status_long === 'Not Started'">- {{ state.formatDate(event.date) }}</span></p></span>
                            </div>
                            <div class="flex items-center justify-center mt-4">
                                <div class="flex items-center mr-3">
                                    <span class="bg-gray-100 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 shadow border border-gray-300 dark:border-gray-700 dark:text-gray-300">0</span>
                                </div>
                                <span>:</span>
                                <div class="flex items-center ml-3">
                                    <span class="bg-gray-100 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 shadow border border-gray-300 dark:border-gray-700 dark:text-gray-300">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <img :src="`/storage/football/fixtures/`+state.generateSlug(event.team_away_name)+`.png`" alt="" width="56" class="mb-3">
                            <span class="font-bold">{{ event.team_away_name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="col-span-2 md:col-span-2">
                    <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                            {{ $t('Match Details') }}
                        </h3>
                    </div>

                    <div class="p-6">
                        <div v-for="(bet, inx) in event.bets" :key="inx" class="mb-3">
                            <h3 class="font-bold text-gray-400 mb-3">{{ bet.name }}</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                                <button
                                    v-if="bet.values.length > 0"
                                    v-for="(valueOdd, oddsIdx) in bet.values"
                                    :key="oddsIdx"
                                    type="button"
                                    class="hover:bg-gray-300 hover:dark:bg-gray-600/10 hover:dark:text-gray-500 transition duration-700 flex justify-between w-full bg-gray-500/20 dark:bg-gray-600/20 px-3 py-2 rounded odds"
                                    @click="setBet(event, inx, oddsIdx)"
                                    :class="{'selected': (valueOdd.selected ?? false)}"
                                >
                                    <span class="text-gray-500 dark:text-gray-400">{{ valueOdd?.value }}</span>
                                    <span class="text-gray-500 dark:text-white font-bold">{{ valueOdd?.odd }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <FootballGameWidget :game-id="id" />
                </div>
            </div>
        </div>

        <BettingBulletinComponent v-once />
    </BaseLayout>
</template>


<script>
import {useRouter} from 'vue-router';
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";

import BaseLayout from "@/Layouts/BaseLayout.vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import HeaderNav from "@/Pages/Sport/Components/HeaderNav.vue";
import CounterComponent from "@/Components/UI/CounterComponent.vue";

/// firebase
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.5.2/firebase-app.js";
import { ref as dbRef, getDatabase, orderByChild, equalTo, onValue } from "https://www.gstatic.com/firebasejs/10.5.2/firebase-database.js";
import BettingBulletinComponent from "@/Components/UI/BettingBulletinComponent.vue";
import {useSportBetStore} from "@/Stores/SportBet.js";
import FootballGameWidget from "@/Components/Widgets/FootballGameWidget.vue";
import HttpApi from "@/Services/HttpApi.js";

export default {
    props: {
        date: String, // Tipo de dados para date
        id: String // Tipo de dados para id
    },
    components: {FootballGameWidget, BettingBulletinComponent, CounterComponent, HeaderNav, LoadingComponent, BaseLayout},
    data() {
        return {
            isLoading: true,
            event: null,
        }
    },
    setup(props) {
        onMounted(() => {
            initFlowbite();
        })

    },
    computed: {

    },
    mounted() {


    },
    methods: {
        loadFootballWidget() {
            this.$nextTick(() => {
                const script = document.createElement('script');
                script.type = 'module';
                script.src = 'https://widgets.api-sports.io/2.0.3/widgets.js';
                script.setAttribute('data-host', 'v3.football.api-sports.io');
                script.setAttribute('data-key', '5db4063b29f77a538a6963b367995c16');
                script.setAttribute('data-id', this.id);
                script.setAttribute('data-theme', 'dark');
                script.setAttribute('data-refresh', '15');
                script.setAttribute('data-show-errors', 'true');
                script.setAttribute('data-show-logos', 'true');

                if (this.$refs.footballGame) {
                    this.$refs.footballGame.appendChild(script);
                }
            });
        },
        setBet(event, odds, idx) {
            const sportStore = useSportBetStore();
            sportStore.setBet(event, odds, idx);
        },
        getSportDetail: function()
        {
            const _this = this;
            HttpApi.get('sports/football/events/'+this.id)
                .then(response => {
                    _this.event = response.data.event;
                    _this.isLoading = false;
                })
                .catch(error => {
                    console.log(error);
                    _this.isLoading = false;
                });
        }
    },
    created() {
        this.getSportDetail();

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
