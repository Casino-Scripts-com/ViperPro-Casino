<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                {{ $t('Loading the Match Calendar') }}
            </div>
        </LoadingComponent>

        <div v-if="!isLoading" class="p-4">
            <div class="bets-header font-bold">
                <div class="flex items-center text-3xl">
                    <i class="fa-duotone fa-calendar-days"></i>
                    <h1 class="ml-2 ">{{ $t('Calendar') }}</h1>
                </div>
            </div>

            <HeaderOptions />

            <div class="mt-5">
                <SportCardList v-for="(event, index) in events.data" :event="event" :index="index"/>
            </div>


            <CustomPagination :data="events" @pagination-change-page="getFixtures"/>
        </div>
    </BaseLayout>
</template>


<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";
import SportCardList from "@/Pages/Sport/Components/SportCardList.vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import HeaderOptions from "@/Pages/Sport/Components/HeaderOptions.vue";
import {useToast} from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import CustomPagination from "@/Components/UI/CustomPagination.vue";


export default {
    props: [],
    components: {CustomPagination, HeaderOptions, LoadingComponent, SportCardList, BaseLayout},
    data() {
        return {
            isLoading: true,
            events: null,
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
        getFixtures: function(page = 1) {
            const _this = this;

            HttpApi.get('sports/football/fullevents?page='+page)
                .then(response => {
                    _this.events = response.data.events;

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
