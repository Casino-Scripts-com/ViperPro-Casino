import { defineStore } from 'pinia'

export const sidebarStore = defineStore('sidebar', {
    state() {
        return {
            sidebarStatus: false,
        }
    },

    actions: {
        setSidebarToogle() {
            this.sidebarStatus = !this.sidebarStatus;
        },
        setSidebarStatus(status) {
            this.sidebarStatus = status
        },
    },

    getters: {
        getSidebarStatus() {
            return this.sidebarStatus
        },
    },

})
