<template>
    <div id="modalSPin" class="modal fade" :class="{ show: showModal }" tabindex="-1" role="dialog" aria-labelledby="modalSPinLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
						<span aria-hidden="true">×</span>
					</button>
                    <div class="modal-body s11yeso3">
						<div class="bg bg-a"></div>
						<div class="bg bg-b"></div>
						<div class="bg bg-c"></div>
                        <ComponentSpiner
                            :showWinList="showWinList"
                            :winners="winnerList"
                            @prized="PrizedHandle"
                            @hide-win-list="HideWinList"
                            @close-modal="closeModal()"
                            @loaded="HandleLoaded"
                        ></ComponentSpiner>
                    </div>
					<div class="modal-footer spin-footer" id="spin-footer">
						<div class="left-cont">
							<div class="tit">Bônus total</div>
							<div class="amount">{{ totalBonus }}</div>
						</div>
						<div class="right-cont" @click="OpenWinList()">
							<div id="r-c-container">
								<ComponentLastWinner
                                    v-for="(w, i) in lastWinners"
                                    :winner="w"
                                    :key="i"
                                />
								<svg class="s1ff97qc icon">
                                    <use :xlink:href="'/assets/images/spin/spin-symbol-defs.svg#icon_Arrow'"></use>
                                </svg>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
		<ComponentCongrats :prize="prize" v-if="prize"></ComponentCongrats>
</template>
<script>
    import ComponentLastWinner from './LastWinner.vue';
    import ComponentSpiner from './Spinner.vue';
    import ComponentCongrats from './Congrats.vue';
    import HttpApi from "@/Services/HttpApi.js";

    export default {
        emits: ['close', 'open-win-list', 'loaded'],
        props: [
            'title',
            'content',
            'showButtons',
            'showModal',
            'winners',
        ],
        components: {
            ComponentCongrats,
            ComponentLastWinner,
            ComponentSpiner
        },
        data() {
            return {
                showWinList: false,
                prize: null,
                total_bonus: window.totalBonus,
                lastWinner: {
                    avatar: '/assets/images/spin/avatar.png',
                    name: '',
                    prize: 0,
                    currency: ''
                },
                lastWinners: [],
                winnerList: [],
                totalBonus: 0,
                interation: 0
            }
        },
        setup(props) {
            return {
    //
            };
        },
        computed: {},
        mounted() {
            (async()=>{
                await this.GetWinners();
            })();
        },
        methods: {
            closeModal() {
                this.$emit('close');
            },
            PrizedHandle(v) {
                this.prize = v;
            },
            OpenWinList() {
                this.showWinList = true;
                this.$emit('open-win-list', this.showWinList);
            },
            HideWinList() {
                this.showWinList = false;
            },
            async GetWinners() {
                const vm = this;
                await HttpApi.get('spin/winners?sessionId=2', {
                    action: 'get-winners'
                }).then(resp => {
                    vm.winnerList = resp.data[0].map(w => {
                        w.prize = Number(w.prize).toFixed(2).replace('.', ',');
                        return w;
                    });
                    vm.totalBonus = resp.data[1];

                    vm.loopWinner();
                });
            },
            loopWinner() {
                const interation = this.interation;

                const lastWinner = this.winnerList[interation];

                this.lastWinners.push(lastWinner);

                const vm = this;

                this.interation++;
                if (this.interation === this.lastWinners.length) {
                    this.interation = [0];
                }

                if (this.lastWinners.length > 1) {
                    setTimeout(() => {
                        const allEl = document.querySelectorAll('#r-c-container > div');
                        const first = allEl[0];
                        const secound = allEl[1];

                        const interval = setInterval(() => {
                            const fX = Number(first.style.top.split('px')[0]);
                            const sX = Number(secound.style.top.split('px')[0]);
                            const tilt = -fX * 0.5;

                            first.style.transform = `perspective(100px) rotateX(${tilt}deg)`;
                            secound.style.transform = `perspective(100px) rotateX(${-(tilt / 12)}deg)`;

                            first.style.top = ''.concat(fX - 5, 'px');
                            secound.style.top = ''.concat(sX - 5, 'px');

                            if (sX < -92) {
                                first.remove();
                                clearInterval(interval);
                                secound.style.transform = `perspective(100px) rotateX(0deg) rotateY(0deg)`;
                                secound.style.top = '0px';
                                setTimeout(() => {
                                    vm.loopWinner();
                                }, 1000);
                            }
                        }, 50);
                    }, 1000);
                } else {
                    setTimeout(() => {
                        vm.loopWinner();
                    }, 3000);
                }
            },
            HandleLoaded() {
                this.$emit('loaded');
            }
        }
    };
</script>

<style scoped>
    #spin-footer {
        position: absolute!important;
        bottom: 0px!important;
        border: solid thin transparent;
        height: 80px!important;
        padding: 2px;
    }
    #spin-footer > .left-cont, #spin-footer > .right-cont {
        position: absolute;
        top: 0px;
    }
    .modal {
        --bs-modal-zindex: 1055;
        --bs-modal-width: 500px;
        --bs-modal-padding: 1rem;
        --bs-modal-margin: 0.5rem;
        --bs-modal-color: ;
        --bs-modal-bg: #fff;
        --bs-modal-border-color: var(--bs-border-color-translucent);
        --bs-modal-border-width: 1px;
        --bs-modal-border-radius: 0.5rem;
        --bs-modal-box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        --bs-modal-inner-border-radius: calc(0.5rem - 1px);
        --bs-modal-header-padding-x: 1rem;
        --bs-modal-header-padding-y: 1rem;
        --bs-modal-header-padding: 1rem 1rem;
        --bs-modal-header-border-color: var(--bs-border-color);
        --bs-modal-header-border-width: 1px;
        --bs-modal-title-line-height: 1.5;
        --bs-modal-footer-gap: 0.5rem;
        --bs-modal-footer-bg: ;
        --bs-modal-footer-border-color: var(--bs-border-color);
        --bs-modal-footer-border-width: 1px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: var(--bs-modal-zindex);
        display: none;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
        outline: 0;
        display: none;
    }
    @media (prefers-reduced-motion: reduce) {
        .fade {
            transition: none;
        }
    }
    .modal-dialog{position:relative;width:auto;margin:var(--bs-modal-margin);pointer-events:none;}
    .modal.fade .modal-dialog{transition:transform .3s ease-out;transform:translate(0,-50px);}
    @media (prefers-reduced-motion:reduce){
    .modal.fade .modal-dialog{transition:none;}
    }
    .modal.show .modal-dialog{transform:none;}
    .modal-content{position:relative;display:flex;flex-direction:column;width:100%;color:var(--bs-modal-color);pointer-events:auto;background-color:var(--bs-modal-bg);background-clip:padding-box;border:var(--bs-modal-border-width) solid var(--bs-modal-border-color);border-radius:var(--bs-modal-border-radius);outline:0;}
    .modal-header{display:flex;flex-shrink:0;align-items:center;justify-content:space-between;padding:var(--bs-modal-header-padding);border-bottom:var(--bs-modal-header-border-width) solid var(--bs-modal-header-border-color);border-top-left-radius:var(--bs-modal-inner-border-radius);border-top-right-radius:var(--bs-modal-inner-border-radius);}
    .modal-header .btn-close{padding:calc(var(--bs-modal-header-padding-y) * .5) calc(var(--bs-modal-header-padding-x) * .5);margin:calc(-.5 * var(--bs-modal-header-padding-y)) calc(-.5 * var(--bs-modal-header-padding-x)) calc(-.5 * var(--bs-modal-header-padding-y)) auto;}
    .modal-title{margin-bottom:0;line-height:var(--bs-modal-title-line-height);}
    .modal-body{position:relative;flex:1 1 auto;padding:var(--bs-modal-padding);}
    .modal-footer{display:flex;flex-shrink:0;flex-wrap:wrap;align-items:center;justify-content:flex-end;padding:calc(var(--bs-modal-padding) - var(--bs-modal-footer-gap) * .5);background-color:var(--bs-modal-footer-bg);border-top:var(--bs-modal-footer-border-width) solid var(--bs-modal-footer-border-color);border-bottom-right-radius:var(--bs-modal-inner-border-radius);border-bottom-left-radius:var(--bs-modal-inner-border-radius);}
    .modal-footer>*{margin:calc(var(--bs-modal-footer-gap) * .5);}
    @media (min-width:576px){
    .modal-dialog{max-width:var(--bs-modal-width);margin-right:auto;margin-left:auto;}
    }
    .fade {
        transition: opacity .15s linear;
    }
    .bd-gutter {
        --bs-gutter-x: 3rem;
    }
    .modal.show {
        display: block;
        padding-right: 17px;
    }
    #modalSPin {
        background-color: #00000096;
    }
    #modalSPin .modal-dialog {
        margin: 0px auto;
        height: 100vh;
    }
    #modalSPin .modal-content {
        background-color: #1a132c;
        overflow: hidden;
        flex-wrap: nowrap;
        align-items: center;
    }
    #modalSPin .modal-footer {
        position: fixed;
        bottom: 0px;
        padding: 0;
        margin: 0.5rem;
        background-color: transparent;
        height: 4.375rem;
    }
    #modalSPin button.close {
        position: absolute;
        right: 10px;
    }
    .spin-footer {
        width: 500px;
        padding: 0;
        margin: .5rem;
        background-color: transparent;
        height: 4.375rem;
        border-radius: var(--border-radius);
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -webkit-justify-content: space-between;
        -ms-flex-pack: justify;
        justify-content: space-between;
        color: #767b81;
    }

    .spin-footer .left-cont,
    .spin-footer .right-cont {
        background-color: #261d3e;
    }

    .spin-footer .left-cont {
        width: 186px;
        height: 72px;
        border-radius: var(--border-radius);
        -webkit-align-self: stretch;
        -ms-flex-item-align: stretch;
        align-self: stretch;
        text-align: center;
    }

    .spin-footer .left-cont .tit,
    .spin-footer .right-cont .tit {
        margin-top: 1.25rem;
        color: #fff;
    }

    .spin-footer .left-cont .tit {
        font-size: .75rem;
        line-height: .75rem;
        height: 0.75rem;
    }

    .spin-footer .left-cont .amount {
        color: #e9d317;
        font-size: 1rem;
        line-height: 1.1875rem;
        height: 1.1875rem;
        font-weight: 800;
        margin-top: .3125rem
    }

    .spin-footer .right-cont {
        right: 0px;
        width: 300px;
        height: 72px;
        border-radius: var(--border-radius);
        -webkit-flex: auto;
        -ms-flex: auto;
        flex: auto;
        margin-left: .25rem;
        -webkit-align-self: stretch;
        -ms-flex-item-align: stretch;
        align-self: stretch;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .spin-footer .right-cont .data-cont {
        padding: .625rem 1.5625rem 0 3.75rem;
        width: 100%;
        height: 5.75rem
    }

    .spin-footer .right-cont .data-cont .icon {
        height: 1.25rem;
        position: absolute;
        top: 2.25rem;
        right: .3125rem
    }

    .spin-footer .right-cont .data-cont .cont .name {
        color: #94a3c8;
        font-size: .9375rem
    }

    .spin-footer .right-cont .data-cont .cont .win {
        white-space: nowrap
    }

    .spin-footer .right-cont .data-cont .cont .win .amount {
        color: #45cb1d
    }

    .spin-footer .right-cont .data-cont .cont .win .currency {
        color: #fff
    }

    .spin-footer .right-cont .data-cont .cont .type b {
        color: #f1905c
    }

    @media screen and (max-width: 621px) {
        .spin-footer .left-cont {
            width: 9.375rem
        }
    }

    #r-c-container {
        height: 92px;
        overflow: hidden;
    }
    .s1ff97qc {
        --1nfs066: #9fa5ac;
        width: 1.4em;
        height: 1.4em;
        fill: var(--1nfs066);
    }
    .s1ff97qc.icon {
        position: absolute;
        top: calc(50% - 10px);
        right: 10px;
    }
    @media (min-width: 576px) {
        .modal {
            --bs-modal-margin: 1.75rem;
            --bs-modal-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    }
</style>
