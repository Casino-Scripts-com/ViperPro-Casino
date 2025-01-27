<template>
    <div class="congrats" :class="{'show':prize}">
		<div class="congrats-backdrop"></div>
		<div id="congrats-content">
			<img class="img-bg rotate" :src="'/assets/images/spin/4fea7639.webp'" alt="">
			<div class="bg-wrap">
				<img class="img_glod" :src="'/assets/images/spin/7f96d3f0.webp'" alt="">
				<div class="cont">
					<div class="tit ttu">{{ $t('Congratulations') }}!</div>
					<div class="desc">{{ $t('You’ve got free money to bet on our games') }}!</div>
					<div class="scoll-num amount sxm7p3g"><span v-if="prize.currency == 'BRL'">R$&nbsp;</span>{{ (animatedNumber).toFixed(2).replace('.',',') }} <span v-if="prize.currency != 'BRL'">{{ prize.currency }}</span></div>
					<button class="ui-button button-normal s-conic" @click="ClaimReawards()">
						<div class="button-inner">{{  $t('Claim Rewards') }}</div>
					</button>
				</div>
			</div>
		</div>
	</div>
</template>


<script setup>
    import { computed, onMounted, ref } from 'vue';
    import { useSpinStoreData } from '@/Stores/SpinStoreData';

    const spinStoreData = useSpinStoreData();

    const props = defineProps({
        prize: Object
    });

    const animatedNumber = ref(0);
    const animationDuration = 2000;
    const animationInterval = 16;

    function formatNumber(num, size, separator) {
        if (!size) {
            size = 6;
        }
        num = num.toString();
        if (num.length > size && num.indexOf('.') < 0 || (num.length + 1) > size && num.indexOf('.') >= 0) {
            const arr = num.split('.');
            size = size - arr[0].length;
            num = Number(num).toFixed(size);
        } else {
            const arr = num.split('.');
            size = size - arr[0].length;
            num = Number(num).toFixed(size);
        }
        if (!separator) {
            separator = '.';
        }
        if (separator != '.') {
            num = num.replace('.', separator);
        }
        return num;
    }

    function startAnimation() {
        const startValue = animatedNumber.value;
        const targetValue = targetNumber.value;
        const duration = animationDuration;
        const interval = animationInterval;
        const steps = duration / interval;
        const stepValue = (targetValue - startValue) / steps;

        let step = 0;

        const updateNumber = () => {
            animatedNumber.value += stepValue;

            if (++step < steps) {
                requestAnimationFrame(updateNumber);
            } else {
                animatedNumber.value = targetValue;
            }
        };

        requestAnimationFrame(updateNumber);
    }
    function ClaimReawards() {
        location.href = '/register'.concat('/', spinStoreData.spin_data);
    }

    const targetNumber = computed(() => {
        if (props.prize && props.prize.value) {
            return props.prize.value;
        }
        return 0;
    });

    onMounted(() => {
        startAnimation();
    });
</script>

<style scoped>
    button {
        border: none;
        padding: 0;
        -webkit-user-select: none;
        user-select: none;
        cursor: pointer;
        font-size: 0.875rem;
        background-color: transparent;
    }
    button {
        font-weight: 400;
        font-family: Inter, -apple-system, Framedcn, Helvetica Neue, Condensed,
            DisplayRegular, Helvetica, Arial, PingFang SC, Hiragino Sans GB,
            WenQuanYi Micro Hei, Microsoft Yahei, sans-serif;
    }
    button {
        color: var(--text-color);
    }
    .ttu {
        text-transform: uppercase;
    }
    @media screen and (min-width: 621px) {
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
            background-color: transparent;
            border-radius: var(--border-radius);
        }	::-webkit-scrollbar-thumb {
            background-color: var(--placeholder-color);
            transition: all 0.5s;
            border-radius: var(--border-radius);
        }	::-webkit-scrollbar-button {
            display: none;
        }	* {
            scrollbar-color: var(--shadow-color) transparent;
            scrollbar-width: thin;
            scrollbar-width: none;
        }
    }
    .ui-button {
        --3xr1hu: rgba(107, 113, 128, 0.8);
        display: block;
        width: 100%;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: var(--border-radius);
        height: 3rem;
        font-weight: 700;
        cursor: pointer;
        -webkit-transition: -webkit-transform 0.2s cubic-bezier(0.36, 0.66, 0.04, 1);
        -webkit-transition: transform 0.2s cubic-bezier(0.36, 0.66, 0.04, 1);
        transition: transform 0.2s cubic-bezier(0.36, 0.66, 0.04, 1);
    }
    .darken .ui-button {
        --3xr1hu: #6b7180;
    }
    .ui-button>.button-inner {
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
        width: 100%;
        height: 100%;
    }
    .ui-button:active.ui-button:not(:disabled) {
        -webkit-transform: scale(0.95);
        -ms-transform: scale(0.95);
        transform: scale(0.95);
    }
    .ui-button:disabled.ui-button:not(.is-loading) {
        opacity: 0.5;
        cursor: default;
    }
    .ui-button.s-conic {
        color: #fff;
        background-color: #1d803ab3;
        background-image: conic-gradient(from 1turn,
                rgba(88, 175, 16, 1),
                rgba(29, 128, 58, 1));
    }
    .ui-button.s-conic:hover {
        background-image: conic-gradient(from 1turn,
                rgba(88, 175, 16, 0.7),
                rgba(29, 128, 58, 0.7));
    }
    .pfrl3ez>* {
        position: absolute;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        left: 50%;
        top: 50%;
    }
    .sxm7p3g {
        font-weight: 900;
        background-image: linear-gradient(to bottom,
                #ffb03b,
                #fcee21,
                #ffff89,
                #fddb3e,
                #ffdb49,
                #ffeb7d,
                #fda60a);
        -webkit-filter: drop-shadow(2px 2px 0 #c55b1a);
        filter: drop-shadow(2px 2px 0 #c55b1a);
        -webkit-background-clip: text;
        color: transparent;
        line-height: 3.125rem;
        font-size: 3rem;
        font-style: italic;
        -webkit-flex: auto;
        -ms-flex: auto;
        flex: auto;
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
    }
    .congrats {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        border-radius: 0.5rem;
        z-index: 9999;
        opacity: 0;
    }
    .congrats.show {
        opacity: 1;
        transition: opacity 1s ease-in-out;
    }
    .congrats .congrats-backdrop {
        position: absolute;
        top: 0px;
        left: 0px;
        background-color: #000000e8;
        width: 100vw;
        height: 100vh;
    }
    #congrats-content {
        position: absolute;
        top: calc(50% - 175px);
        left: calc(50% - 194px);
    }
    .congrats .bg-wrap {
        width: 388px;
        height: 350px;
        background-image: radial-gradient(rgba(242, 187, 47, 0.2), #191a1b 80%);
        background-size: 100% 90%;
        background-position: center -8.125rem;
        background-repeat: no-repeat;
        background-color: #191a1b;
        position: relative;
        z-index: 1;
    }
    .congrats .img-bg {
        position: absolute;
        width: 31.25rem;
        height: 31.25rem;
        left: -3.5rem;
        top: -5.3125rem;
        -webkit-animation: fade-in2-congrats 1s linear both;
        animation: fade-in2-congrats 1s linear both;
    }
    .congrats .img-bg.rotate {
        -webkit-animation: rotate-congrats 5s linear infinite;
        animation: rotate-congrats 5s linear infinite;
    }
    .congrats .img_glod {
        position: absolute;
        width: 26.875rem;
        height: 26.25rem;
        left: -1.3125rem;
        top: -3.75rem;
        opacity: 0;
        z-index: 2;
        -webkit-animation: fade-in-congrats 0.8s ease-in-out both;
        animation: fade-in-congrats 0.8s ease-in-out both;
    }
    .congrats .cont {
        position: relative;
        z-index: 3;
        height: 100%;
        padding: 2.75rem 0.75rem;
        text-align: center;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }
    .congrats .cont .tit {
        color: #fff;
        font-weight: 700;
        font-size: 1.5rem;
        line-height: 1.625rem;
    }
    .congrats .cont .desc {
        font-size: 1rem;
        width: 70%;
        margin: 0.75rem auto 0;
        color: #98a7b5;
    }
    .congrats .ui-button {
        margin: 0 auto;
        width: 80%;
    }/*! CSS Used keyframes */
    @-webkit-keyframes fade-in2-congrats {
        0% {
            opacity: 0;
        }	to {
            opacity: 1;
        }
    }@keyframes fade-in2-congrats {
        0% {
            opacity: 0;
        }	to {
            opacity: 1;
        }
    }@-webkit-keyframes rotate-congrats {
        0% {
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            transform: rotate(0);
        }	to {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }@keyframes rotate-congrats {
        0% {
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            transform: rotate(0);
        }	to {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }@-webkit-keyframes fade-in-congrats {
        0% {
            opacity: 0;
            -webkit-transform: scale(0);
            -ms-transform: scale(0);
            transform: scale(0);
        }	80% {
            opacity: 0.8;
            -webkit-transform: scale(1.2);
            -ms-transform: scale(1.2);
            transform: scale(1.2);
        }	to {
            opacity: 1;
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
        }
    }@keyframes fade-in-congrats {
        0% {
            opacity: 0;
            -webkit-transform: scale(0);
            -ms-transform: scale(0);
            transform: scale(0);
        }	80% {
            opacity: 0.8;
            -webkit-transform: scale(1.2);
            -ms-transform: scale(1.2);
            transform: scale(1.2);
        }	to {
            opacity: 1;
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
        }
    }

</style>
