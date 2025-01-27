<template>
    <div v-if="isLoading" class="">

    </div>
    <div v-else class="w-full flex flex-col">
        <MissionCard v-if="isAuthenticated" v-for="(m, idx) in missions" :mission="m" :index="idx" @updateMission="refreshData" />
        <div v-else class="flex flex-col text-center items-center justify-center w-full p-4 min-h-[250px]">
            <h1 class="text-2xl">{{ $t('Log in to view') }}</h1>
        </div>
    </div>
</template>


<script>

import HttpApi from "@/Services/HttpApi.js";
import MissionCard from "@/Pages/Home/Components/MissionCard.vue";
import {useAuthStore} from "@/Stores/Auth.js";

export default {
    props: [],
    components: {MissionCard},
    data() {
        return {
            isLoading: false,
            missions: null,
        }
    },
    setup(props) {


        return {};
    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    mounted() {

    },
    methods: {
        refreshData: function() {
            this.getMissions();
        },
        getMissions: function() {
            const _this = this;
            _this.isLoading = true;

            HttpApi.get('missions?period=daily')
                .then(response => {
                    _this.missions = response.data.missions;
                    _this.isLoading = false;
                })
                .catch(error => {
                    _this.isLoading = false;
                });
        },
    },
    created() {
        if(this.isAuthenticated) {
            this.getMissions();
        }
    },
    watch: {
        isAuthenticated(newVal, oldVal) {
            this.getMissions();
        }
    },
};
</script>

<style scoped>

</style>
