<template>
    <div id="spin-winlist">
        <button class="close-icon i1gm0mn8" @click="CloseModal()">&times;</button>
        <div class="s2psx6n winlist enter">
            <div class="winlist-wrap">
                <div class="pop-control">
                    <button class="back" @click="Close()">
                        <svg class="s1ff97qc icon">
                            <use :xlink:href="'/assets/images/spin/spin-symbol-defs.svg#icon_Arrow'"></use>
                        </svg>
                    </button>
                </div>
                <div class="header">
                    <img :src="'/assets/images/spin/ccccc.png'" class="crown" alt="">
                    <div class="spin-bonus">
                        <img class="pre-img"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAA8CAMAAADfciMYAAAAOVBMVEUAAABhoxNYnA5YnA5anxFXnA1XnA1XnA1YnA1YnA5anhBanQ9XnA1XnA1XnA1YnQ5YnQ5XnA5Xmw18sITgAAAAEnRSTlMAD1uOHvDN4qh8LTzYwLRNbJuWdev/AAAB2klEQVQ4y32VSaLjIAxEzTzYYKj7H7YFH0KwlX4bL6QIVSGRg0OoS/GBK/SvvgDPZoQR8AD4GpYihUqBuNkMQxFHh9AnHSwORGw1vOAz/CivKc5zgjh/yKyxfRVghJAhyGcVOeV55GJAGPk0gqhUy+BDeWdQjxWwdmRcz1OIdLZGRUXD671TdOyf61oGucWHiI65VU5VcnLtOHx8IpOS8Y1jDZ0iXjcbVfirea2EvZHSRJxdj9HKAU5pxk/61Q3k1tCK7G7hJMHhYNHDLdsuPhalysutNMwCYpf8nrCIifnlxo0HhTdr4VlDw2iB26XVjaNSfWB/ir6O/yI2CSwAWqJMBu7eGwi1hrOvpD6ifV8+RRopekDG4dnerR9+VqDOIeQdNdQqN0BExgP/Xmts1G7PuaV4LHILnQlG7IaGnHxx1IGYo4ubfwrtmsvCGW+6DP1nSvjxnjpxhCmZQVAnam6W7nMTmc24h6YmwLaak1Mlm1T6jLPuJddhOj/GXU6z82rgm6vbhoadF7wniPUuuakibWt1xc8upvWvNC9Wy/HgXs/d0MXn3B+bu5Wp42mL/Ga0oOkZlXX2LmGuqRVMXGHhuYTEvwH80PJNJu7J5NtwJxeevqSsvqb0H0eLMkgpefdsAAAAAElFTkSuQmCC"
                            alt="">
                        <div class="tit">Bônus de giro</div>
                        <img class="suf-img"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAA8CAMAAADfciMYAAAAOVBMVEUAAABhoxNYnA5YnA5anxFXnA1XnA1XnA1YnA1YnA5anhBanQ9XnA1XnA1XnA1YnQ5YnQ5XnA5Xmw18sITgAAAAEnRSTlMAD1uOHvDN4qh8LTzYwLRNbJuWdev/AAAB2klEQVQ4y32VSaLjIAxEzTzYYKj7H7YFH0KwlX4bL6QIVSGRg0OoS/GBK/SvvgDPZoQR8AD4GpYihUqBuNkMQxFHh9AnHSwORGw1vOAz/CivKc5zgjh/yKyxfRVghJAhyGcVOeV55GJAGPk0gqhUy+BDeWdQjxWwdmRcz1OIdLZGRUXD671TdOyf61oGucWHiI65VU5VcnLtOHx8IpOS8Y1jDZ0iXjcbVfirea2EvZHSRJxdj9HKAU5pxk/61Q3k1tCK7G7hJMHhYNHDLdsuPhalysutNMwCYpf8nrCIifnlxo0HhTdr4VlDw2iB26XVjaNSfWB/ir6O/yI2CSwAWqJMBu7eGwi1hrOvpD6ifV8+RRopekDG4dnerR9+VqDOIeQdNdQqN0BExgP/Xmts1G7PuaV4LHILnQlG7IaGnHxx1IGYo4ubfwrtmsvCGW+6DP1nSvjxnjpxhCmZQVAnam6W7nMTmc24h6YmwLaak1Mlm1T6jLPuJddhOj/GXU6z82rgm6vbhoadF7wniPUuuakibWt1xc8upvWvNC9Wy/HgXs/d0MXn3B+bu5Wp42mL/Ga0oOkZlXX2LmGuqRVMXGHhuYTEvwH80PJNJu7J5NtwJxeevqSsvqb0H0eLMkgpefdsAAAAAElFTkSuQmCC"
                            alt="">
                    </div>
                </div>
                <div class="win-list">
                    <div class="table-header td">
                        <div class="p">Nome de usuário</div>
                        <div class="p">Nível</div>
                        <div class="p">Prêmio</div>
                    </div>
                    <div class="swiper mySwiper">
						<div class="c1mxe6k6 vertical winlist-swiper swiper-no-swiping swiper-wrapper">
							<div style="pointer-events: auto; flex-direction: column; user-select: none; touch-action: pan-x;" draggable="false" class="motion-container swiper-slide">
								<div class="swiper-slide" draggable="false" style="margin-bottom: 0px;" v-for="(w, i) in winners" :key="i">
									<div class="td" draggable="false">
										<div class="p name" draggable="false">{{ w.name }}</div>
										<div class="p" draggable="false">
											<span draggable="false" style="color: rgb(255, 255, 255);">{{ w.nivel }}</span>
										</div>
										<div class="p" draggable="false">
											<div class="cq8kbks coin notranslate has-sign" draggable="false">
												<div class="amount amount-str" draggable="false">{{ w.prize }}</div>
												<img class="coin-icon" :src="'/assets/images/spin/spin-icon-'.concat(w.currency, '.png')" draggable="false">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { onMounted } from 'vue';
    import { TweenMax, ScrollToPlugin } from "gsap/all";

    const emits = defineEmits(['close', 'close-modal']);
    const props = defineProps({
        winners: Array
    })

    let direction = 1;

    function Close() {
        emits('close');
    }
    function CloseModal() {
        emits('close-modal');
    }
    function ScrollWinnersList() {
        const element = document.querySelector('.vertical');
        if (element) {
            const listHeight = element.scrollHeight;

            const currentScrollPosition = element.scrollTop;

            let newScrollPosition = currentScrollPosition + (40 * direction);

            if ((newScrollPosition + element.clientHeight) >= listHeight) {
                direction = -1;
            } else if (newScrollPosition <= 0) {
                direction = 1;
            }

            TweenMax.to(
                element,
                0.5, {
                    scrollTo: {
                        y: newScrollPosition,
                        offsetY: 0
                    },
                    onComplete: () => {
                        ScrollWinnersList();
                    }
                }, "-=.5"
            );
        }
    }

    onMounted(() => {
        const plugins = [ScrollToPlugin];
        ScrollWinnersList();
    });
</script>

<style scoped>
    #spin-winlist {
        position: absolute;
        top: 0px;
        bottom: 0px;
        left: -1.75rem;
        right: 0px;
        width: calc(calc(100% + 1.75rem) + 1.75rem);
    }
    #spin-winlist>button.close-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        color: white;
        z-index: 9999999999999999999;
    }
    .s1ff97qc {
        --1nfs066: #9fa5ac;
        width: 1.4em;
        height: 1.4em;
        fill: var(--1nfs066);
    }
    .darken .s1ff97qc {
        --1nfs066: #67707b;
    }
    .c1mxe6k6 {
        position: relative;
        overflow: hidden;
    }
    .c1mxe6k6 .motion-container {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }
    .cq8kbks {
        display: -webkit-inline-box;
        display: -webkit-inline-flex;
        display: -ms-inline-flexbox;
        display: inline-flex;
        vertical-align: middle;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        white-space: nowrap;
    }
    .cq8kbks .coin-icon {
        width: 1.4em;
        height: 1.4em;
        margin-left: 0.2em;
    }
    .cq8kbks .amount-str {
        max-width: 10em;
        text-align: right;
    }
    .cq8kbks.has-sign {
        -webkit-box-pack: end;
        -webkit-justify-content: flex-end;
        -ms-flex-pack: end;
        justify-content: flex-end;
    }
    .s2psx6n {
        text-align: center;
        position: absolute;
        z-index: 10;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        border-radius: var(--border-radius);
        padding: 0.625rem;
        background-image: linear-gradient(to bottom, #17181b, #17181b);
        -webkit-transform: translate3d(50%, 0, 0);
        -ms-transform: translate3d(50%, 0, 0);
        transform: translate3d(50%, 0, 0);
        -webkit-transition: all 0.2s;
        transition: all 0.2s;
        opacity: 0;
    }
    .s2psx6n.enter {
        -webkit-transition: all 0.2s;
        transition: all 0.2s;
        -webkit-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
        transform: translateZ(0);
        opacity: 1;
    }
    .s2psx6n .winlist-wrap {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        width: 100%;
        height: 100%;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }
    .s2psx6n .win-list {
        margin-top: 1rem;
        margin-bottom: 0.125rem;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
        border-radius: var(--border-radius);
        background-color: #1e2024;
        overflow: hidden;
    }
    .s2psx6n .win-list .td {
        width: 100%;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }
    .s2psx6n .win-list .td .p {
        width: 30%;
        padding: 0.875rem 0.75rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
    }
    .s2psx6n .win-list .td .p:first-of-type {
        text-align: left;
    }
    .s2psx6n .win-list .td .p:last-of-type {
        width: 40%;
        text-align: right;
    }
    .s2psx6n .pop-control {
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
    }
    .winlist-wrap .header {
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        align-items: center;
    }
    .s2psx6n .pop-control .back {
        -webkit-transform: scaleX(-1);
        -ms-transform: scaleX(-1);
        transform: scaleX(-1);
        margin: 0.375rem;
    }
    .s2psx6n .crown {
        width: 2.9375rem;
    }
    .s2psx6n .spin-bonus {
        height: 1.375rem;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        font-size: 1.125rem;
        font-weight: 800;
        color: #fff;
    }
    .s2psx6n .spin-bonus .tit {
        margin: 0 0.3125rem;
    }
    .s2psx6n .spin-bonus img {
        height: 100%;
    }
    .s2psx6n .spin-bonus img.suf-img {
        -webkit-transform: scaleX(-1);
        -ms-transform: scaleX(-1);
        transform: scaleX(-1);
    }
    .s2psx6n .table-header {
        width: 100%;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }
    .s2psx6n .winlist-swiper {
        width: 100%;
        height: 100vh;
    }
    .s2psx6n .winlist-swiper .swiper-slide {
        height: 2.125rem;
    }
    .s2psx6n .winlist-swiper .swiper-slide .name {
        color: #fff;
        font-weight: 800;
    }
    .s2psx6n .winlist-swiper .swiper-slide .amount {
        color: var(--primary-color);
    }
    .s2psx6n .winlist-swiper .swiper-slide .big .amount {
        color: #f7b807;
        font-weight: 600;
    }
</style>
