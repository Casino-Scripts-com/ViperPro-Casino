import { defineStore } from 'pinia'

export const useSpinStoreData = defineStore('SpinStoreData', {
    state() {
        return {
            spin_data: {},
        }
    },

    actions: {
        set(status) {
            this.spin_data = window.btoa(JSON.stringify(status));
        },
    },

    getters: {
        get() {
            return this.spin_data;
        },
        getDecoded() {
            return JSON.parse(window.atob(this.spin_data));
        }
    },

})
