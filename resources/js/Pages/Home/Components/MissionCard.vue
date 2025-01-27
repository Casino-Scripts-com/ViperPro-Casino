<template>
    <div class="flex dark:bg-gray-700 w-full rounded-xl p-4 mb-3 h-[130px]" :key="index">
        <div class="h-auto w-[100px] mr-2">
            <div class="pie" :style="`--percentage: `+mission.myRoundsPercentage ?? 0">{{ mission.myRounds }}</div>
        </div>
        <div class="flex-col w-full">
            <h1 class="text-2xl font-bold">{{ mission.challenge_name }}</h1>
            <div class="text-sm text-gray-400">{{ state.limitCharacters(stripHTML(mission.challenge_description), 80) }}</div>
            <h2 class="text-yellow-400 font-extrabold text-2xl italic">{{ state.currencyFormat(parseFloat(mission.challenge_bonus), mission.challenge_currency) }}</h2>
        </div>
        <div class="flex items-center w-[150px] px-3">
            <button v-if="!mission.haveMission" @click.prevent="acceptMission(mission.id)" class="flex justify-center items-center text-center ui-button-blue mr-3 rounded " style="width: 100px;">
                {{ $t('Accept') }}
            </button>
            <button v-else class="flex justify-center items-center text-center ui-button-black mr-3 rounded" style="width: 100px;">
                {{ $t('Active') }}
            </button>
        </div>
    </div>
</template>


<script>

import HttpApi from "@/Services/HttpApi.js";
import {useToast} from "vue-toastification";

export default {
    props: ['mission', 'index'],
    components: {},
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

    },
    mounted() {

    },
    methods: {
        acceptMission: async function(id) {
            const _this = this;
            const _toast = useToast();

            return await HttpApi.post('missionsusers', { mission_id: id })
                .then(async response =>  {
                    if(response.data.status) {
                        _this.$emit('updateMission');
                        _toast.success(_this.$t('Mission accepted successfully'));
                    }
                })
                .catch(error => {

                });
        },
        stripHTML: function(html) {
            var doc = new DOMParser().parseFromString(html, 'text/html');
            return doc.body.textContent || "";
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
