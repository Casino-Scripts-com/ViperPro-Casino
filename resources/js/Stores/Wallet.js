import { defineStore } from 'pinia'

export const useWalletStore = defineStore('walletStore', {
    state() {
        return {
            wallet: {},
        }
    },

    actions: {
        setWallet(status) {
            this.wallet = status
        },
    },

    getters: {
        getWallet() {
            return this.wallet
        },
    },

})
