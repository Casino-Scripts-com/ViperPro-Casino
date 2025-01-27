<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                {{ $t('Loading live matches') }}
            </div>
        </LoadingComponent>

        <div v-if="!isLoading" class="p-4">
            <div class="bets-header font-bold">
                <div class="flex items-center text-3xl">
                    <i class="fa-solid fa-signal-stream animate-pulse"></i>
                    <h1 class="ml-2 ">{{ $t('Live Matches') }}</h1>
                </div>
            </div>

            <HeaderOptions />

            <div class="mt-5">
                <SportCardList v-for="(event, index) in liveevents" :event="event" :index="index"/>
            </div>
        </div>

        <BettingBulletinComponent v-once />
    </BaseLayout>
</template>


<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";
import SportCardList from "@/Pages/Sport/Components/SportCardList.vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import HeaderOptions from "@/Pages/Sport/Components/HeaderOptions.vue";
import HttpApi from "@/Services/HttpApi.js";
import BettingBulletinComponent from "@/Components/UI/BettingBulletinComponent.vue";


export default {
    props: [],
    components: {BettingBulletinComponent, HeaderOptions, LoadingComponent, SportCardList, BaseLayout},
    data() {
        return {
            isLoading: true,
            liveevents: null,
        }
    },
    setup(props) {

        return {

        };
    },
    computed: {

    },
    mounted() {

    },
    methods: {
        getFixtures: function() {
            const _this = this;

            HttpApi.get('sports/football/liveevents')
                .then(response => {
                    _this.liveevents = response.data.liveevents;
                    _this.isLoading = false;
                })
                .catch(error => {
                    _this.isLoading = false;
                });
        },
    },
    created() {
        this.getFixtures();
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
