<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                Carregando as partidas
            </div>
        </LoadingComponent>

        <div v-if="!isLoading" class="p-4 pt-5">
            <div id="accordion-example">
                <h2 id="accordion-example-heading-1">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 dark:text-gray-400 " aria-expanded="true" aria-controls="accordion-example-body-1">
                        <span class="text-3xl text-gray-500 dark:text-white font-bold">Brasileirão Série A</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-example-body-1" class="hidden" aria-labelledby="accordion-example-heading-1">
                    <SportCardList v-for="(v, index) in 10" :index="index" />
                </div>

                <h2 id="accordion-example-heading-2">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 dark:text-gray-400" aria-expanded="false" aria-controls="accordion-example-body-2">
                        <span class="text-3xl text-gray-500 dark:text-white font-bold">Vencedor Brasil</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </h2>
                <div id="accordion-example-body-2" class="hidden" aria-labelledby="accordion-example-heading-2">
                    <div class="p-5">

                    </div>
                </div>
            </div>

        </div>
    </BaseLayout>
</template>


<script>
import {useRoute, useRouter} from 'vue-router';
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";

import BaseLayout from "@/Layouts/BaseLayout.vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import SportCardList from "@/Pages/Sport/Components/SportCardList.vue";


/// firebase
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.5.2/firebase-app.js";
import { ref as dbRef, getDatabase, orderByChild, equalTo, onValue } from "https://www.gstatic.com/firebasejs/10.5.2/firebase-database.js";

export default {
    props: [],
    components: {SportCardList, LoadingComponent, BaseLayout},
    data() {
        return {
            isLoading: true,
            accordion: null,
        }
    },
    setup(props) {
        const router = useRouter();
        onMounted(() => {
            initFlowbite();
        })

        return {
            router,
            database
        };
    },
    computed: {

    },
    mounted() {
        const id = this.router.params.id;

        setTimeout(() => {
            this.isLoading = false
        }, 3000)

        setTimeout(() => {
            if(document.getElementById('accordion-example') != undefined) {
                const accordionItems = [
                    {
                        id: 'accordion-example-heading-1',
                        triggerEl: document.querySelector('#accordion-example-heading-1'),
                        targetEl: document.querySelector('#accordion-example-body-1'),
                        active: true
                    },
                    {
                        id: 'accordion-example-heading-2',
                        triggerEl: document.querySelector('#accordion-example-heading-2'),
                        targetEl: document.querySelector('#accordion-example-body-2'),
                        active: false
                    }
                ];

                const options = {
                    alwaysOpen: true,
                    activeClasses: 'text-gray-900 dark:text-white',
                    inactiveClasses: 'text-gray-500 dark:text-gray-400',
                    onOpen: (item) => {

                    },
                    onClose: (item) => {

                    },
                    onToggle: (item) => {

                    },
                };

                this.accordion = new Accordion(document.getElementById('accordion-example'), accordionItems, options);
            }
        }, 3100)

    },
    methods: {
        getSportDetail: function()
        {
            const _this = this;

            const id = this.router.params.id;
            const date = this.router.params.date;

            const databaseRef = dbRef(this.database, 'fixtures-' + date +'/' + id);

            onValue(databaseRef, (snapshot) => {
                if (snapshot.exists()) {
                    const data = snapshot.val();


                    _this.event = data;
                    _this.isLoading = false;
                } else {
                    this.event = null;
                    _this.isLoading = false;
                }
            }, {
                onlyOnce: false
            });
        }
    },
    created() {
        this.getSportDetail();
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
