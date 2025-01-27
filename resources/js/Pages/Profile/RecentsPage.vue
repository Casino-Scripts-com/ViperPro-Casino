<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>{{ $t('Loading recents games') }}</span>
            </div>
        </LoadingComponent>

        <div v-if="!isLoading" class="md:w-4/6 2xl:w-4/6 mx-auto my-16 p-4">
            <HeaderComponent>
                <template #header>
                    {{ $t('List of') }} <span class=" bg-blue-100 text-blue-800 text-2xl font-semibold me-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ms-2">{{ $t('Recents') }}</span>
                </template>

                <p class="text-2xl flex items-center justify-center">{{ $t('Total') }} <strong>({{ games?.length ?? 0 }})</strong></p>
            </HeaderComponent>

            <div v-if="games?.length > 0" class="mt-5">
                <div class="relative w-full">
                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-5">
                        <CassinoGameCard
                            v-for="(game, index) in games"
                            :index="index"
                            :title="game.game_name"
                            :cover="game.cover"
                            :gamecode="game.game_code"
                            :type="game.distribution"
                            :game="game"
                        />
                    </div>
                </div>
            </div>
            <div v-else class="empty-data flex flex-col justify-center items-center text-center my-36">
                <img :src="`/assets/images/no-results.png`" alt="" class="w-auto h-auto max-h-[300px]">
                <h3>{{ $t('No data to show') }}</h3>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import HeaderComponent from "@/Components/UI/HeaderComponent.vue";
import HttpApi from "@/Services/HttpApi.js";
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";

export default {
    props: [],
    components: {CassinoGameCard, HeaderComponent, LoadingComponent, BaseLayout },
    data() {
        return {
            isLoading: true,
            games: null,
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
        getFavoriteGame: async function (page = 1) {
            const _this = this;
            await HttpApi.get(`/profile/recents`)
                .then(response => {
                    _this.games = response.data.games;
                    _this.isLoading = false;
                })
                .catch(error => {
                    _this.isLoading = false;
                });
        },
    },
    async created() {
        await this.getFavoriteGame();
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
