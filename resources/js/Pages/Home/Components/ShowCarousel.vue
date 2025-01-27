<template>
    <div :key="index" class="game-list flex flex-col mt-5 relative">
        <div class="w-full flex justify-between">
            <h2 class="text-xl font-bold">{{ $t(category.name) }}</h2>
            <div class="flex">
                <RouterLink
                    :to="{ name: 'casinosAll', params: { provider: 'slotegrator', game: category.slug } }"
                    class="hover:bg-gray-500/20 bg-gray-400/20 dark:bg-gray-800 hover:dark:bg-gray-700 px-3 py-2 mr-2 rounded">
                    {{ $t('See all') }}
                </RouterLink>
                <button @click.prevent="ckCarousel.prev()" class="hover:bg-gray-500/20 bg-gray-400/20 dark:bg-gray-800 hover:dark:bg-gray-700 px-3 py-2 rounded">
                    <i class="fa-solid fa-angle-left"></i>
                </button>
                <button @click.prevent="ckCarousel.next()" class="hover:bg-gray-500/20 bg-gray-400/20 dark:bg-gray-800 hover:dark:bg-gray-700 px-3 py-2 rounded">
                    <i class="fa-solid fa-angle-right"></i>
                </button>
            </div>
        </div>

        <Carousel ref="ckCarousel"
                  v-bind="settingsGames"
                  :breakpoints="breakpointsGames"
                  @init="onCarouselInit(index)"
                  @slide-start="onSlideStart(index)"
        >
            <Slide v-if="isLoading" v-for="(i, iloading) in 10" :index="iloading">
                <div  role="status" class="w-full flex items-center justify-center h-48 mr-6 max-w-sm bg-gray-300 rounded-lg animate-pulse dark:bg-gray-700 text-4xl">
                    <i class="fa-duotone fa-gamepad-modern"></i>
                </div>
            </Slide>

            <Slide v-if="category.games_slotgrator && !isLoading" v-for="(game, igame) in category.games_slotgrator" :index="igame">
                <CassinoGameCard
                    :index="igame"
                    :title="game.name"
                    :cover="`/storage/`+game.image"
                    :link="game.slug"
                    type="slotegrator"
                />
            </Slide>
        </Carousel>
    </div>
</template>


<script>

import { Carousel, Navigation, Slide } from 'vue3-carousel';
import {onMounted, ref} from "vue";
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";

export default {
    props: ['category', 'index'],
    components: {CassinoGameCard, Carousel, Navigation, Slide },
    data() {
        return {
            isLoading: false,
            settingsGames: {
                itemsToShow: 2.5,
                snapAlign: 'start',
            },
            breakpointsGames: {
                700: {
                    itemsToShow: 3.5,
                    snapAlign: 'center',
                },
                1024: {
                    itemsToShow: 6,
                    snapAlign: 'start',
                },
            },
        }
    },
    setup(props) {
        const ckCarousel = ref(null)

        onMounted(() => {

        });

        return {
            ckCarousel
        };
    },
    computed: {

    },
    mounted() {

    },
    methods: {
        onCarouselInit(index) {

        },
        onSlideStart(index) {

        },
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
