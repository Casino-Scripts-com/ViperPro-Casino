<template>
    <div>
        {{ apiData }}
    </div>
</template>


<script>
import { ref, onMounted } from 'vue';
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.5.2/firebase-app.js';
import { getDatabase, ref as databaseRef, set } from 'https://www.gstatic.com/firebasejs/10.5.2/firebase-database.js';

const currentDate = new Date();
const year = currentDate.getFullYear();
const month = String(currentDate.getMonth() + 1).padStart(2, '0');
const day = String(currentDate.getDate()).padStart(2, '0');
const formattedDate = `${year}-${month}-${day}`;


export default {
    props: [],
    components: {  },
    data() {
        return {
            isLoading: false,
            apiKey: '5db4063b29f77a538a6963b367995c16',
            date: formattedDate,
            apiUrl: `https://v3.football.api-sports.io/fixtures?status=NS&date=${formattedDate}&season=${year}`,
            uriPath: 'https://v3.football.api-sports.io/',
            loading: true,
            apiData: null,

        }
    },
    setup(props) {
        const firebaseConfig = {
            apiKey: "AIzaSyDuZxERSC12JRHv_CxfamTi8yhzXDqQ-zQ",
            authDomain: "magnata-f9cda.firebaseapp.com",
            databaseURL: "https://magnata-f9cda-default-rtdb.firebaseio.com",
            projectId: "magnata-f9cda",
            storageBucket: "magnata-f9cda.appspot.com",
            messagingSenderId: "644210333241",
            appId: "1:644210333241:web:53c3b7c5abf6ee30ad5fe8",
            measurementId: "G-RRPRXPQ3K7"
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
        getLeagues: function() {
            /// Atualizados 1 vez por semana
            const headers = {
                'x-apisports-key': this.apiKey,
                'Accept': 'application/json'
            };

            fetch(`https://v3.football.api-sports.io/leagues?season=${year}&current=true`, {
                method: 'GET',
                headers: headers
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('The network response was not correct');
                }
                return response.json();
            })
            .then(data => {
                const fixturesRef = databaseRef(this.database, 'leagues');
                return set(fixturesRef, data);
            })
            .then((data) => {
                this.apiData = data;
                this.loading = false;
                console.log('API data successfully registered in Firebase database.');
            })
            .catch(error => {
                console.error('Error:', error);
                this.loading = false;
            });
        },
        getFixturesLive: function() {
            /// Atualizados 15 segundos
            const headers = {
                'x-apisports-key': this.apiKey,
                'Accept': 'application/json'
            };

            fetch(this.uriPath+`fixtures/live`, {
                method: 'GET',
                headers: headers
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('The network response was not correct');
                    }
                    return response.json();
                })
                .then(data => {
                    const fixturesRef = databaseRef(this.database, 'fixtures-live');
                    return set(fixturesRef, data);
                })
                .then((data) => {
                    this.apiData = data;
                    this.loading = false;
                    console.log('API data successfully registered in Firebase database.');
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.loading = false;
                });
        },
        getFixtureById: async function(id) {
            const headers = {
                'x-apisports-key': this.apiKey,
                'Accept': 'application/json',
            };
            const response = await fetch(this.uriPath+`fixtures?id=${id}`, {
                method: 'GET',
                headers: headers
            });
            return await response.json();
        },
        getOdds: function() {
            const headers = {
                'x-apisports-key': this.apiKey,
                'Accept': 'application/json'
            };

            fetch(this.uriPath+`odds/live`, {
                method: 'GET',
                headers: headers
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('The network response was not correct');
                }
                return response.json();
            })
            .then(async data => {
                const promises = data.response.map(async odd => {
                    const result = await this.getFixtureById(odd.fixture.id);
                    odd.fixture = result.response[0];

                    return odd;
                });

                // Espera por todas as chamadas assíncronas concluírem
                const updatedOdds = await Promise.all(promises);

                const saveData = { ...data, response: updatedOdds };
                const fixturesRef = databaseRef(this.database, 'fixtures-live-' + formattedDate);
                return set(fixturesRef, saveData);
            })
            .then((data) => {
                this.loading = false;
                console.log('API data successfully registered in Firebase database.');
            })
            .catch(error => {
                console.error('Error:', error);
                this.loading = false;
            });
        },
        getFixtures: function() {
            const headers = {
                'x-apisports-key': this.apiKey,
                'Accept': 'application/json'
            };

            fetch(this.apiUrl, {
                method: 'GET',
                headers: headers
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('The network response was not correct');
                }
                return response.json();
            })
            .then(data => {
                console.log(formattedDate);
                const fixturesRef = databaseRef(this.database, 'fixtures-'+formattedDate);
                return set(fixturesRef, data);
            })
            .then((data) => {
                this.apiData = data;
                this.loading = false;
                console.log('API data successfully registered in Firebase database.');
            })
            .catch(error => {
                console.error('Error:', error);
                this.loading = false;
            });
        }

    },
    async created() {
        ///this.getLeagues();
       this.getOdds();


    },
    watch: {},
};
</script>

<style scoped>

</style>
