import { defineStore } from 'pinia';

export const missionStore = defineStore('missionstore', {
    state() {
        return {
            missionStatus: false,
        }
    },

    actions: {
        setMissionToogle() {
            this.missionStatus = !this.missionStatus;
        },
    },

    getters: {
        getMissionStatus() {
            return this.missionStatus
        },
    },

})
