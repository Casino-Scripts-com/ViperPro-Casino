<template>
    <div class="bg-gray-50 shadow dark:bg-gray-700 p-4 rounded">

        <!-- titulo -->
        <div class="flex justify-between bet-card-header mb-3">
            <div class="bet-card-title text-gray-400">
                <RouterLink active-class="sport-detail-active" :to="{ name: 'sportSingle', params: { date: state.dateFormatServer(event.date), id: event.id }}" class="hover:dark:text-white transition duration-700 flex justify-center items-center">
                    <i class="fa-duotone fa-earth-africa"></i>
                    <span class="ml-3 flex">
                        <strong>{{ event.league_country }}</strong>
                        <span class=""> - {{ event.league_name }}</span>
                    </span>
                </RouterLink>
            </div>
            <div class="bet-card-statistic text-gray-500">
                <i class="fa-solid fa-chart-simple"></i>
            </div>
        </div>

        <!-- exibição -->
        <div v-if="event.status_long" class="flex justify-between">
            <div>
                <p>{{ $t(event.status_long) }} <span v-if="event.status_long === 'Not Started'"> - {{ state.formatDate(event.date) }}</span></p>
            </div>
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
        <div v-else>
            <p>{{ state.formatDate(event.date) }}</p>
        </div>

        <RouterLink :to="{ name: 'sportSingle', params: { date: state.dateFormatServer(event.date), id: event.id }}">
            <!-- time a -->
            <div class="flex justify-between mt-3">
                <div class="flex items-center">
                    <img :src="`/storage/football/fixtures/`+state.generateSlug(event.team_home_name)+`.png`" alt="" width="32">
                    <span class="ml-2">{{ event.team_home_name }}</span>
                </div>
                <div class="flex items-center">
                    <span class="bg-gray-200 text-gray-800 text-sm font-medium px-2.5 py-0.5 h-6 w-6 flex justify-center items-center text-center rounded dark:bg-gray-800 border border-gray-300 dark:border-gray-800 dark:text-gray-300">
                        {{ event?.goals_home }}
                    </span>
                </div>
            </div>

            <!-- time b -->
            <div class="flex justify-between mt-3">
                <div class="flex items-center">
                    <img :src="`/storage/football/fixtures/`+state.generateSlug(event.team_away_name)+`.png`" alt="" width="32">
                    <span class="ml-2">{{ event.team_away_name }}</span>
                </div>
                <div class="flex items-center">
                     <span class="bg-gray-200 text-gray-800 text-sm font-medium px-2.5 py-0.5 h-6 w-6 flex justify-center items-center text-center rounded dark:bg-gray-800 border border-gray-300 dark:border-gray-800 dark:text-gray-300">
                       {{ event?.goals_away }}
                    </span>
                </div>
            </div>
        </RouterLink>

        <!-- buttons -->
        <div v-if="event.odds_home != null" class="flex justify-between gap-4 mt-5">
            <button class="hover:bg-gray-200 hover:dark:bg-gray-600/10 hover:dark:text-gray-500 transition duration-700 flex justify-between w-full bg-gray-300/20 hover:bg-gray-400/20 dark:bg-gray-800/20 px-3 py-2 rounded odds"
                    :class="{selected: (event?.bets[0].values[0]?.selected?? false)}" @click="setBet(event, 0, 0)">
                <span class="text-gray-500 dark:text-gray-400">1</span>
                <span class="text-gray-500 dark:text-white font-bold">
                    {{ event.odds_home }}
                </span>
            </button>
            <button class="hover:bg-gray-200 hover:dark:bg-gray-600/10 hover:dark:text-gray-500 transition duration-700 flex justify-between w-full bg-gray-300/20 hover:bg-gray-400/20 dark:bg-gray-800/20 px-3 py-2 rounded odds"
                    :class="{selected: (event?.bets[0].values[1]?.selected?? false)}" @click="setBet(event, 0, 1)">
                <span class="text-gray-500 dark:text-gray-400">{{ $t('draw') }}</span>
                <span class="text-gray-500 dark:text-white font-bold">
                    {{ event.odds_draw }}
                </span>
            </button>
            <button class="hover:bg-gray-200 hover:dark:bg-gray-600/10 hover:dark:text-gray-500 transition duration-700 flex justify-between w-full bg-gray-300/20 hover:bg-gray-400/20 dark:bg-gray-800/20 px-3 py-2 rounded odds"
                    :class="{selected: (event?.bets[0].values[2]?.selected?? false)}" @click="setBet(event, 0, 2)">
                <span class="text-gray-500 dark:text-gray-400">2</span>
                <span class="text-gray-500 dark:text-white font-bold">
                    {{ event.odds_away }}
                </span>
            </button>
            <button @click.prevent="toggleDetail" class="flex justify-between items-center bg-gray-300/20 hover:bg-gray-400/20 dark:bg-gray-800/20 px-3 py-2 rounded text-gray-400">
                <i class="fa-solid fa-chevron-down">

                </i>
            </button>
        </div>
        <div v-else class="flex justify-between gap-4 mt-5">
            <button @click.prevent="toggleDetail" class="w-full flex justify-between items-center bg-gray-300/20 hover:bg-gray-400/20 dark:bg-gray-800/20 px-3 py-2 rounded text-gray-400">
                <i class="fa-solid fa-chevron-down"></i>
                {{ $t('Details') }}
            </button>
        </div>
    </div>

    <!-- Detalhes da partida -->
    <div :id="`sport-card-`+index" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full">
        <div class="relative h-full w-full lg:w-1/2 max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <button @click.prevent="toggleDetail" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">{{ $t('Close') }}</span>
                </button>

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
                                :class="{'selected': (valueOdd.selected ?? false)}">
                                <span class="text-gray-500 dark:text-gray-400">{{ valueOdd?.value }}</span>
                                <span class="text-gray-500 dark:text-white font-bold">{{ valueOdd?.odd }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { initFlowbite, Modal } from 'flowbite';
import {onMounted} from "vue";
import { RouterLink } from "vue-router";
import {useSportBetStore} from "@/Stores/SportBet.js";

export default {
    props: ['index', 'event'],
    components: { Modal, RouterLink },
    data() {
        return {
            isLoading: false,
            modal: null,
            oddsStart: null
        }
    },
    setup(props) {
        onMounted(() => {
            initFlowbite();
        });

        return {};
    },
    computed: {

    },
    mounted() {

        const options = {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
            closable: false,
            onHide: () => {
            },
            onShow: () => {
            },
            onToggle: () => {
            }
        };

       this.modal = new Modal(document.getElementById(`sport-card-`+this.index), options);

    },
    methods: {
        setBet(event, odds, idx) {
            const sportStore = useSportBetStore();
            sportStore.setBet(event, odds, idx);
        },
        toggleDetail() {
            this.modal.toggle();
        }
    },
    created() {


    },
    watch: {

    },
};
</script>

<style scoped>

</style>
