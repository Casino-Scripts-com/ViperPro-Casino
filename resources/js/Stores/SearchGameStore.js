import { defineStore } from 'pinia'

export const searchGameStore = defineStore('seachgames', {
    state() {
        return {
            searchgameStatus: false,
        }
    },

    actions: {
        setSearchGameToogle() {
            this.searchgameStatus = !this.searchgameStatus;
        },
    },

    getters: {
        getSearchGameStatus() {
            return this.searchgameStatus
        },
    },

})
