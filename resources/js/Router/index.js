import {createWebHistory, createRouter} from "vue-router";
import HomePage from "@/Pages/Home/HomePage.vue";
import SportPage from "@/Pages/Sport/SportPage.vue";
import {useAuthStore} from "@/Stores/Auth.js";
import AffiliatePage from "@/Pages/Profile/AffiliatePage.vue";
import CassinoListPage from "@/Pages/Cassino/CassinoListPage.vue";
import CassinoSearch from "@/Pages/Cassino/CassinoSearch.vue";
import LoginPage from "@/Pages/Auth/LoginPage.vue";
import RegisterPage from "@/Pages/Auth/RegisterPage.vue";
import WalletPage from "@/Pages/Profile/WalletPage.vue";
import DepositPage from "@/Pages/Profile/DepositPage.vue";
import WithdrawPage from "@/Pages/Profile/WithdrawPage.vue";
import TransactionPage from "@/Pages/Profile/TransactionPage.vue";
import ConditionsReference from "@/Pages/Terms/ConditionsReference.vue";
import ServiceTerms from "@/Pages/Terms/ServiceTerms.vue";
import PrivacyPolicy from "@/Pages/Terms/PrivacyPolicy.vue";
import BonusTerms from "@/Pages/Terms/BonusTerms.vue";
import WelcomeBonus from "@/Pages/Terms/WelcomeBonus.vue";
import SupportPage from "@/Pages/Home/SupportPage.vue";
import PromotionPage from "@/Pages/Home/PromotionPage.vue";
import SupportCenterPage from "@/Pages/Home/SupportCenterPage.vue";
import DataPage from "@/Pages/ApiData/DataPage.vue";
import StripeSuccess from "@/Pages/Gateway/StripeSuccess.vue";
import StripeCancel from "@/Pages/Gateway/StripeCancel.vue";
import FavoritePage from "@/Pages/Profile/FavoritePage.vue";
import RecordPage from "@/Pages/Profile/RecordPage.vue";
import BonusPage from "@/Pages/Home/BonusPage.vue";
import VipPage from "@/Pages/Home/VipPage.vue";
import RecentsPage from "@/Pages/Profile/RecentsPage.vue";
import AwardsPage from "@/Pages/Home/AwardsPage.vue";
import EventsPage from "@/Pages/Home/EventsPage.vue";
import LandingPage from "@/Pages/Landing/LandingPage.vue";
import CasinoPlayPage from "@/Pages/Cassino/CasinoPlayPage.vue";
import ForgotPassword from "@/Pages/Auth/ForgotPassword.vue";
import ResetPassword from "@/Pages/Auth/ResetPassword.vue";

export const routes = [
    {
        name: 'home',
        path: '/:action?',
        component: HomePage
    },
    {
        name: 'login',
        path: '/login',
        component: LoginPage
    },
    {
        name: 'forgotPassword',
        path: '/forgot-password',
        component: ForgotPassword
    },
    {
        name: 'resetPassword',
        path: '/reset-password/:token',
        component: ResetPassword
    },
    {
        name: 'stripeSuccess',
        path: '/stripe/success',
        component: StripeSuccess
    },
    {
        name: 'stripeCancel',
        path: '/stripe/cancel',
        component: StripeCancel
    },
    {
        name: 'support',
        path: '/support',
        component: SupportPage
    },
    {
        name: 'promotion',
        path: '/promotion',
        component: PromotionPage
    },
    {
        name: 'sportPage',
        path: '/sports',
        component: SportPage
    },
    {
        name: 'supportCenter',
        path: '/support-center',
        component: SupportCenterPage
    },
    {
        name: 'register',
        path: '/register/:code?',
        component: RegisterPage
    },
    {
        path: '/sports',
        component: {
            template: `<router-view></router-view>`,
        },
        children: [
            {
                name: 'sports',
                path: '', // Rota vazia para exibir a página de esportes
                component: SportPage
            }
        ]
    },
    {
        name: 'profileAffiliate',
        path: '/profile/affiliate',
        component: AffiliatePage,
        meta: {
            auth: true
        }
    },
    {
        name: 'favoritePage',
        path: '/profile/favorite',
        component: FavoritePage,
        meta: {
            auth: true
        }
    },
    {
        name: 'casinos',
        path: '/casinos',
        component: HomePage
    },
    {
        name: 'casinoPlayPage',
        path: '/games/play/:id/:slug',
        component: CasinoPlayPage,
    },
    {
        name: 'casinosAll',
        path: '/casino/provider/:provider?/category/:category?',
        component: CassinoListPage
    },
    {
        name: 'casinoSearch',
        path: '/casino/search',
        component: CassinoSearch
    },
    {
        name: 'profileWallet',
        path: '/profile/wallet',
        component: WalletPage,
        meta: {
            auth: true
        }
    },
    {
        name: 'recentsPage',
        path: '/profile/recents',
        component: RecentsPage,
        meta: {
            auth: true
        }
    },
    {
        name: 'profileDeposit',
        path: '/profile/deposit',
        component: DepositPage,
        meta: {
            auth: true
        }
    },
    {
        name: 'profileWithdraw',
        path: '/profile/withdraw',
        component: WithdrawPage,
        meta: {
            auth: true
        }
    },
    {
        name: 'profileTransactions',
        path: '/profile/transactions',
        component: TransactionPage,
        meta: {
            auth: true
        }
    },
    {
        name: 'termsConditionsReference',
        path: '/terms/conditions-reference',
        component: ConditionsReference
    },
    {
        name: 'serviceTerms',
        path: '/terms/service',
        component: ServiceTerms
    },
    {
        name: 'privacyPolicy',
        path: '/terms/privacy-policy',
        component: PrivacyPolicy
    },
    {
        name: 'bonusTerms',
        path: '/terms/bonus',
        component: BonusTerms
    },
    {
        name: 'welcomeBonus',
        path: '/terms/bonus-welcome',
        component: WelcomeBonus
    },
    {
        name: 'dataPage',
        path: '/datapage',
        component: DataPage
    },
    {
        name: 'recordPage',
        path: '/records',
        component: RecordPage,
    },
    {
        name: 'eventsPage',
        path: '/events',
        component: EventsPage,
    },
    {
        name: 'vipPage',
        path: '/vip',
        component: VipPage,
    },
    {
        name: 'bonusPage',
        path: '/bonus',
        component: BonusPage,
    },
    {
        name: 'awardsPage',
        path: '/awards',
        component: AwardsPage,
    },
    {
        name: 'landingPage',
        path: '/landing/spin',
        component: LandingPage
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_BASE_URL || '/'),
    routes: routes,
});

router.beforeEach(async (to, from, next) => {
    if(to.meta?.auth) {
        const auth = useAuthStore();
        auth.isAuth ? next() : next({ name: 'home' });
    }else{
        next();
    }
});

export default router;
