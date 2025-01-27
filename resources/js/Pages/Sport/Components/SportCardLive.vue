<template>
    <div class="bg-gray-50 shadow dark:bg-gray-700 p-4 rounded min-h-[174px]">
        <!-- titulo -->
        <div class="flex justify-between bet-card-header mb-3">
            <div class="text-gray-400 w-[70%] flex justify-start text-[13px] truncate">
                <RouterLink active-class="sport-detail-active" :to="{ name: 'sportSingle', params: { date: state.dateFormatServer(event.date), id: event.id }}" class="hover:dark:text-white transition duration-700 flex justify-center items-center">
                    <i class="fa-duotone fa-earth-africa"></i>
                    <span class="ml-3 flex">
                        <strong>{{ event.league_country }}</strong>
                        <span class=""> - {{ event.league_name }}</span>
                    </span>
                </RouterLink>
            </div>
            <div class="text-gray-500 ">
                <!-- exibição -->
                <div v-if="event.status_long" class="flex justify-center text-[13px]">
                    <div class="">
                        <p>{{ event.status_long }} <span v-if="event.status_long === 'Not Started'"> - {{ state.formatDate(event.date) }}</span></p>
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
                        <i class="fa-solid fa-signal-stream animate-pulse ml-2"></i>
                    </div>
                </div>
                <div v-else>
                    <p>{{ state.formatDate(event.date) }}</p>
                </div>
            </div>
        </div>
        <!--/ titulo /-->

        <!-- time -->
        <RouterLink :to="{ name: 'sportSingle', params: { date: state.dateFormatServer(event.date), id: event.id }}" class="flex justify-between">
            <div>
                <div class="flex flex-col items-center">
                    <img :src="`/storage/football/fixtures/`+state.generateSlug(event.team_home_name)+`.png`" alt="" width="32">
                    <span class="ml-2 text-[12px]">{{ event.team_home_name }}</span>
                </div>
            </div>
            <div class="flex justify-between gap-4">
                <div class="flex items-center">
                    <span class="bg-gray-200 text-gray-800 text-sm font-medium px-2.5 py-0.5 h-8 w-8 flex justify-center items-center text-center rounded dark:bg-gray-800 border border-gray-300 dark:border-gray-800 dark:text-gray-300">
                        {{ event?.goals_home }}
                    </span>
                </div>
                <div class="flex items-center">
                     <span class="bg-gray-200 text-gray-800 text-sm font-medium px-2.5 py-0.5 h-8 w-8 flex justify-center items-center text-center rounded dark:bg-gray-800 border border-gray-300 dark:border-gray-800 dark:text-gray-300">
                       {{ event?.goals_away }}
                    </span>
                </div>
            </div>
            <div>
                <div class="flex flex-col items-center">
                    <img :src="`/storage/football/fixtures/`+state.generateSlug(event.team_away_name)+`.png`" alt="" width="32">
                    <span class="ml-2 text-[12px]">{{ event.team_away_name }}</span>
                </div>
            </div>
        </RouterLink>

        <!-- buttons actions -->
        <div>
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
            </div>
            <div v-else class="flex justify-between gap-4 mt-5">
                <button class="w-full flex justify-between items-center bg-gray-300/20 hover:bg-gray-400/20 dark:bg-gray-800/20 px-3 py-2 rounded text-gray-400">
                    <h1 class="text-lg">{{ $t('Waiting for the odds') }}</h1>
                </button>
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
            modalLive: null,
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


    },
    methods: {
        setBet(event, odds, idx) {
            const sportStore = useSportBetStore();
            sportStore.setBet(event, odds, idx);
        },
        toggleDetail() {

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
