import { defineStore } from "pinia";
import { ref } from "vue";
import axios from 'axios';
import router from '../Router';
import HttpApi from "@/Services/HttpApi.js";

export const useSettingStore = defineStore("settingData", () => {
    const setting = ref(JSON.parse(localStorage.getItem('setting')));
    /**
     * Set Setting
     * @param settingValue
     */
    function setSetting(settingValue) {
        if(settingValue != null && settingValue.setting) {
            localStorage.setItem('setting', JSON.stringify(settingValue.setting));
            setting.value = settingValue.setting;
        }
    }

    function getSettingData()
    {
        return setting.value;
    }


    /**
     * Check Token
     * @returns {Promise<undefined>}
     */
    async function getSetting() {
        try {
            const { data } = await HttpApi.get('/settings/data');
            return data;
        } catch (error) {
            console.log(error.response);
        }
    }

    return {
        setting,
        setSetting,
        getSetting,
        getSettingData
    };
});
