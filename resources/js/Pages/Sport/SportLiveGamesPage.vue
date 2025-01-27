<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                Carregando o Calendário de partidas
            </div>
        </LoadingComponent>

        <div v-if="!isLoading" class="p-4">
            <div class="bets-header font-bold">
                <div class="flex items-center text-3xl">
                    <i class="fa-duotone fa-calendar-days"></i>
                    <h1 class="ml-2 ">{{ $t('Calendar') }}</h1>
                </div>
            </div>

            <div class="mt-5">
                <SportCardList v-for="(event, index) in events" :event="event" :index="index"/>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";
import SportCardList from "@/Pages/Sport/Components/SportCardList.vue";

/// firebase
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.5.2/firebase-app.js";
import { ref as dbRef, getDatabase, orderByChild, equalTo, onValue } from "https://www.gstatic.com/firebasejs/10.5.2/firebase-database.js";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";


const currentDate = new Date();
currentDate.setDate(currentDate.getDate() + 1); // Adicionando um dia à data atual

const year = currentDate.getFullYear();
const month = String(currentDate.getMonth() + 1).padStart(2, '0');
const day = String(currentDate.getDate()).padStart(2, '0');
const formattedDate = `${year}-${month}-${day}`;



export default {
    props: [],
    components: {LoadingComponent, SportCardList, BaseLayout},
    data() {
        return {
            isLoading: true,
            events: null,
        }
    },
    setup(props) {
        const firebaseConfig = {
            apiKey: "AIzaSyAgFeM38rpp2FtyRcniuTSwInt5i_LkrEw",
            authDomain: "footballapi-77676.firebaseapp.com",
            databaseURL: "https://footballapi-77676-default-rtdb.firebaseio.com",
            projectId: "footballapi-77676",
            storageBucket: "footballapi-77676.appspot.com",
            messagingSenderId: "415922178428",
            appId: "1:415922178428:web:fdf7714d8b118df1447cf9",
            measurementId: "G-MV8LR0P2L9"
        };

        const app = initializeApp(firebaseConfig);
        const database = getDatabase(app);

        return {
            database
        };
    },
    computed: {

    },
    mounted() {

    },
    methods: {
        getFixtures: function() {
            const _this = this;
            const databaseRef = dbRef(this.database, 'fixtures-' + formattedDate);

            onValue(databaseRef, (snapshot) => {
                if (snapshot.exists()) {
                    const data = snapshot.val();

                    _this.events = data;
                    _this.isLoading = false;
                } else {
                    this.events = null;
                    _this.isLoading = false;
                }
            }, {
                onlyOnce: false
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
