<template>
    <div class="p-4 bg-gray-50 dark:bg-gray-700/20 rounded-lg shadow mb-4">
        <div class="grid grid-cols-2 gap-4">
            <!-- coluna esquerda -->
            <div class="col-span-2 lg:col-span-1 flex flex-col justify-start">
                <div class="flex justify-between mb-3">
                    <RouterLink active-class="sport-detail-active" :to="{ name: 'sportSingle', params: { date: state.dateFormatServer(event.date), id: event.id } }">
                        <div class="flex items-center gap-2">
                            <svg class="bt705 bt686" data-cy="sport-soccer" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="fill: currentcolor; color: inherit; width: auto; height: 16px;">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.04 21.3793C12.368 22.0323 13.8288 22.393 15.3425 22.4261L17.8734 19.5272C17.9026 17.8165 17.5076 16.1267 16.7246 14.6139L11.7195 13.4485C10.675 14.4949 9.86495 15.7551 9.35078 17.1439L11.04 21.3793ZM10.7764 22.204L9.08458 23.6141C10.9111 25.274 13.3374 26.2857 16 26.2857C16.511 26.2857 17.0133 26.2485 17.5043 26.1765L15.3359 23.2833C13.7356 23.25 12.1884 22.8783 10.7764 22.204ZM5.7343 16.6469H8.62297C9.20019 15.1755 10.086 13.8441 11.2164 12.7406V9.62205C10.2129 9.37945 9.1786 9.29054 8.14698 9.35692C6.6294 11.1491 5.71429 13.4677 5.71429 16C5.71429 16.2173 5.72102 16.433 5.7343 16.6469ZM22.9116 19.3483C23.8049 18.4384 24.5225 17.3714 25.0254 16.2017L23.6597 11.542C22.5016 10.9523 21.2395 10.587 19.9272 10.4698L17.6048 14.4567C18.3 15.8824 18.6825 17.4437 18.7275 19.033L22.9116 19.3483ZM23.4088 20.0636V23.1348C25.0358 21.4457 26.0906 19.2017 26.2613 16.7145L25.7741 16.6293C25.2096 17.9111 24.4065 19.0765 23.4088 20.0636ZM23.9985 9.53268C22.4866 7.66509 20.3338 6.33759 17.8747 5.88473C17.5281 6.28981 17.2149 6.71981 16.9371 7.17124L19.7454 9.596C21.1338 9.68779 22.4749 10.0354 23.7142 10.6149L23.9985 9.53268ZM16.0845 6.92604C16.3235 6.51838 16.5885 6.12608 16.8785 5.75128C16.5889 5.72678 16.2959 5.71429 16 5.71429C13.2876 5.71429 10.8204 6.76421 8.98261 8.47983C9.78915 8.49238 10.5923 8.59246 11.3784 8.77945C11.4114 8.75319 11.4487 8.73155 11.4894 8.71569L16.0845 6.92604ZM16 28C9.37258 28 4 22.6274 4 16C4 9.37258 9.37258 4 16 4C22.6274 4 28 9.37258 28 16C28 22.6274 22.6274 28 16 28Z"></path>
                            </svg>
                            <span>{{ $t(event.league_country) }}</span>
                            <div>
                                <svg class="bt707" data-cy="ic-rounded-arrow" width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="fill: currentcolor; color: inherit; width: auto; height: 8px;">
                                    <path d="M8.7542 11.1529C8.35634 11.6157 7.64366 11.6157 7.2458 11.1529L4.24545 7.66298C3.68586 7.01207 4.14485 6 4.99964 6L11.0004 6C11.8551 6 12.3141 7.01207 11.7546 7.66298L8.7542 11.1529Z"></path>
                                </svg>
                            </div>
                            <span>{{ $t(event.league_name) }}</span>
                        </div>
                    </RouterLink>
                    <div class="text-gray-500 font-bold">
                        <p>{{ state.formatDate(event.date) }}</p>
                    </div>
                </div>
                <div class="flex justify-between">
                    <RouterLink :to="{ name: 'sportSingle', params: { date: state.dateFormatServer(event.date), id: event.id } }">
                        <div class="flex flex-col gap-2 text-white hover:text-gray-300 transition duration-700">
                            <h2 class="flex">
                                <img :src="`/storage/football/fixtures/`+state.generateSlug(event.team_home_name)+`.png`" class="mr-2" width="20" alt="">
                                {{ event.team_home_name }}
                            </h2>
                            <h2 class="flex">
                                <img :src="`/storage/football/fixtures/`+state.generateSlug(event.team_away_name)+`.png`" class="mr-2" width="20" alt="">
                                {{ event.team_away_name }}
                            </h2>
                        </div>
                    </RouterLink>
                    <div class="flex">
                        <div class="divider mt-2"></div>
                        <div class="flex flex-col p-3">
                            <a href="" class="text-gray-500 hover:text-white transition duration-700"><i class="fa-solid fa-chart-simple"></i></a>
                            <a href="" class="text-gray-500 hover:text-white transition duration-700"><i class="fa-solid fa-star"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- coluna direita -->
            <div :class="`col-span-2 lg:col-span-1 scrollable-container scrollable-container-`+index">
                <div :class="`flex gap-4 w-full scrollable-content scrollable-content-`+index">
                    <div v-for="(bet, inx) in event.bets" :key="inx" class="flex-col text-center">
                        <p class="font-bold mb-4">{{ bet.name }}</p>
                        <div class="flex justify-evenly gap-3 ">
                            <button v-if="bet.values.length > 0"
                                    v-for="(valueOdd, oddsIdx) in bet.values"
                                    :key="oddsIdx"
                                    @click="setBet(event, inx, oddsIdx)"
                                    :class="{'selected': (valueOdd.selected ?? false)}"
                                    class="flex-col items-center text-center bg-gray-200 dark:bg-gray-700/20 min-w-[80px] px-3 py-2 odds">
                                <span class="mb-2">{{ valueOdd?.value }}</span>
                                <p class="font-bold text-sm text-gray-500 dark:text-white">{{ valueOdd?.odd }}</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted } from "vue";
import { RouterLink } from "vue-router";
import {useSportBetStore} from "@/Stores/SportBet.js";

export default {
    props: ['index', 'event'],
    components: { RouterLink },
    data() {
        return {
            isLoading: false,
        }
    },
    setup(props) {
        onMounted(() => {

        });

        return {};
    },
    computed: {

    },
    mounted() {
        var container = document.querySelector(".scrollable-container-"+this.index);
        var content = document.querySelector(".scrollable-content-"+this.index);

        var isDragging = false;
        var startX;
        var scrollLeft;

        container.addEventListener("mousedown", function (e) {
            isDragging = true;
            startX = e.pageX;
            scrollLeft = container.scrollLeft;
            container.style.cursor = "grabbing"; // Mude o cursor para indicar que está arrastando
        });

        document.addEventListener("mousemove", function (e) {
            if (!isDragging) return;
            var x = e.pageX - startX;
            container.scrollLeft = scrollLeft - x;
        });

        document.addEventListener("mouseup", function () {
            isDragging = false;
            container.style.cursor = "grab"; // Restaure o cursor padrão
        });

    },
    methods: {
        setBet(event, odds, idx) {
            const sportStore = useSportBetStore();
            sportStore.setBet(event, odds, idx);
        },
    },
    created() {

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
