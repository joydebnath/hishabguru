import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import QuotationRoutes from './quotations'
import OrderRoutes from './orders'
import InvoiceRoutes from './invoices'
import PurchaseRoutes from './purchases'
import BillsRoutes from './bills'
import OtherExpenseRoutes from './other-expenses'
import EmployeesRoutes from './employees'
import ClientsRoutes from './clients'
import SuppliersRoutes from './supplier'
import InventoriesRoutes from './inventories'

const DashboardComponent = () => import(/* webpackChunkName: "js/profile-settings" */  "../pages/dashboard/DashboardComponent");
const MarketplaceComponent = () => import(/* webpackChunkName: "js/marketplace" */  "../components/marketplace/MarketplaceComponent");
const PromoCodesComponent = () => import(/* webpackChunkName: "js/promo-codes" */  "../components/promo-codes/PromocodesComponent");
const BusinessSettingComponent = () => import(/* webpackChunkName: "js/business-settings" */  "../pages/business-settings/BusinessSettingComponent");
const ProfileSettingsComponent = () => import(/* webpackChunkName: "js/profile-settings" */  "../pages/profile-settings/ProfileSettingsComponent");
// const ExampleComponent = () => import(/* webpackChunkName: "js/examples" */  "../components/ExampleComponent");

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/@/dashboard',
            name: 'dashboard',
            component: DashboardComponent,
            meta: {type: 'dashboard'}
        },
        ...InventoriesRoutes,
        ...QuotationRoutes,
        ...OrderRoutes,
        ...PurchaseRoutes,
        {
            path: '/@/marketplace',
            name: 'marketplace',
            meta: {type: 'business'},
            component: MarketplaceComponent,
        },
        {
            path: '/@/promo-codes',
            name: 'promo codes',
            meta: {type: 'business'},
            component: PromoCodesComponent,
        },
        ...InvoiceRoutes,
        ...BillsRoutes,
        ...OtherExpenseRoutes,
        ...ClientsRoutes,
        ...SuppliersRoutes,
        ...EmployeesRoutes,
        {
            path: '/@/business-settings',
            name: 'business settings',
            meta: {type: 'business'},
            component: BusinessSettingComponent,
        },
        {
            path: '/@/profile',
            name: 'profile settings',
            meta: {type: 'profile'},
            component: ProfileSettingsComponent,
        },
    ],
});

export default router
