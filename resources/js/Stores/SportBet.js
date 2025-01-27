import { defineStore } from 'pinia'

function formatID(b, oid, id) {
    return `${b.id}-${oid}-${id}`;
}

export const useSportBetStore = defineStore('sportBetStore', {
    state() {
        return {
            bets: [],
        }
    },

    actions: {
        setBet(bet, oid, idx) {
            bet.bets[oid].values[idx].selected = true;
            function BetFactory(b, oid, idx) {
                const {
                    fixture_id,
                    referee,
                    date,
                    goals_home,
                    goals_away,
                    league_name,
                    league_season,
                    league_round,
                    team_home_name,
                    team_away_name,
                    status_long,
                    finished
                } = b;

                return {
                    id: fixture_id,
                    bet_id: formatID(b, oid, idx),
                    referee,
                    date,
                    goals_home,
                    goals_away,
                    league_name,
                    league_season,
                    league_round,
                    team_home_name,
                    team_away_name,
                    status_long,
                    finished,
                    bet_amount: 10,
                    bets: b.bets[oid],
                    oddsSelected: b.bets[oid].values[idx]
                };
            }
            let index = this.bets.findIndex(b => b.bet_id === formatID(bet, oid, idx));

            if(index !== -1) {
                if(this.bets[index].bet_value !== bet.bet_value) {
                    this.bets.splice(index, 1);
                    this.bets.unshift(BetFactory(bet, oid, idx));
                }else{
                    bet.bets[oid].values[idx].selected = false;
                    this.bets.splice(index, 1);
                }
            }else{
                this.bets.unshift(BetFactory(bet, oid, idx));
            }
        },
        updateAllAmountBet(amount) {
            this.bets.forEach((bet) => {
                bet.bet_amount = amount;
            });
        },
        updateAmountBet(bet, amount) {
            const index = this.bets.findIndex(item => item.id === bet.id);
            if (index !== -1) {
                this.bets[index].bet_amount = amount;
            }
        },
        removeBet(bet) {
            const index = this.bets.findIndex(item => item.bet_id === bet.bet_id);

            if (index !== -1) {
                bet.oddsSelected.selected = false;
                this.bets.splice(index, 1);
            }
        },
        clearAllBets() {
            this.bets.forEach(bet => {
                bet.oddsSelected.selected = false;
            });
            this.bets = []; // Limpa a lista de apostas
        },
        updateOdds({ bets }, { betIndex, valueIndex, newOdd }) {
            const previousOdd = bets[betIndex].values[valueIndex].odd;
            bets[betIndex].values[valueIndex].odd = newOdd;

            if (parseFloat(newOdd) > parseFloat(previousOdd)) {
                bets[betIndex].values[valueIndex].direction = 'up';
            } else if (parseFloat(newOdd) < parseFloat(previousOdd)) {
                bets[betIndex].values[valueIndex].direction = 'down';
            } else {
                bets[betIndex].values[valueIndex].direction = null;
            }

            setTimeout(() => {
                bets[betIndex].values[valueIndex].direction = null;
            }, 2000);
        },
    },

    getters: {
        countBets(){
            return this.bets.length;
        },
        getBets(){
            return this.bets;
        },

    },

})
