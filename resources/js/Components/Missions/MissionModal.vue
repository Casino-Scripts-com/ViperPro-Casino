<template>
    <!-- Mission  -->
    <div id="modalMissionEl" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-green-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex flex-col">
                        {{ $t('Mission Center') }}
                    </h3>
                    <button @click.prevent="toggleMissionModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:bg-gray-600 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-800 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Mission Modal body -->
                <div class="p-4 md:p-5 space-y-4 top-custom">
                    <div class="flex justify-between">
                        <div class="">
                            <p>Recompensas acumuladas:</p>
                            <h4 class="text-2xl font-extrabold italic">R$ 0,00</h4>
                        </div>
                        <div class="">
                            <h2 class="text-2xl text-gray-400">{{ $t(getDayOfWeek()) }}</h2>
                        </div>
                    </div>

                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex justify-between -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400" id="tabs-mission" role="tablist">
                            <li class="me-2 w-full" role="presentation">
                                <button
                                    class="w-full inline-block rounded-t-lg border-b-2 border-transparent p-4 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                                    id="daily-mission-tab"
                                    type="button"
                                    role="tab"
                                    aria-controls="daily-mission"
                                    aria-selected="false"
                                >
                                    {{ $t('Daily Missions') }}
                                </button>
                            </li>
                            <li class="me-2 w-full" role="presentation">
                                <button
                                    class="w-full inline-block rounded-t-lg border-b-2 border-transparent p-4 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                                    id="weekly-tasks-tab"
                                    type="button"
                                    role="tab"
                                    aria-controls="weekly-tasks"
                                    aria-selected="false"
                                >
                                    {{ $t('Weekly Tasks') }}
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div id="tabContentExample">
                        <div
                            class="hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-800"
                            id="daily-mission"
                            role="tabpanel"
                            aria-labelledby="daily-mission-tab">
                            <MissionDaily/>
                        </div>
                        <div
                            class="hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-800"
                            id="weekly-tasks"
                            role="tabpanel"
                            aria-labelledby="weekly-tasks-tab">
                            <MissionWeekly />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import { initFlowbite, Tabs, Modal } from 'flowbite';
import { onMounted } from "vue";

import { useAuthStore } from "@/Stores/Auth.js";
import { missionStore } from "@/Stores/MissionStore.js";
import MissionDaily from "@/Pages/Home/Components/MissionDaily.vue";
import MissionWeekly from "@/Pages/Home/Components/MissionWeekly.vue";

export default {
    props: [],
    components: {
        MissionWeekly,
        MissionDaily,
    },
    data() {
        return {
            tabsMission: null,
            modalMission: null,
        }
    },
    setup(props) {

        onMounted(() => {
            initFlowbite();
        });

        return {

        };
    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
        missionModal() {
            const mission = missionStore()
            return mission.getMissionStatus;
        },
    },
    mounted() {

        /// MISSION MODAL
        const $targetEl = document.getElementById('modalMissionEl');
        const options = {
            placement: 'bottom-right',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {

            },
            onShow: () => {

            },
            onToggle: () => {

            },
        };

        const instanceOptions = {
            id: 'modalMissionEl',
            override: true
        };

        this.modalMission = new Modal($targetEl, options, instanceOptions);


        /// MISSION TAB
        const tabsElement = document.getElementById('tabs-mission');
        const tabElements = [
            {
                id: 'profile',
                triggerEl: document.querySelector('#daily-mission-tab'),
                targetEl: document.querySelector('#daily-mission'),
            },
            {
                id: 'dashboard',
                triggerEl: document.querySelector('#weekly-tasks-tab'),
                targetEl: document.querySelector('#weekly-tasks'),
            },
        ];
        const optionsTab = {
            defaultTabId: 'settings',
            activeClasses: 'active-tab text-green-600 hover:text-blue-600 dark:text-green-500 dark:hover:text-green-400 border-green-600 dark:border-green-500',
            inactiveClasses: 'text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300',
            onShow: () => {

            },
        };
        const instanceTabOptions = {
            id: 'tabs-mission',
            override: true
        };

        this.tabsMission = new Tabs(tabsElement, tabElements, optionsTab, instanceTabOptions);
    },
    methods: {
        toggleMissionModal: function() {
            this.modalMission.toggle();
        },
        getDayOfWeek() {
            const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const currentDate = new Date();
            const dayOfWeek = daysOfWeek[currentDate.getDay()];
            return dayOfWeek;
        },
    },
    watch: {
        missionModal(newValue, oldValue) {
            this.modalMission.toggle();
        }
    },
};
</script>
