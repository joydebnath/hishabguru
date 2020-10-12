import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const ProductsComponent = () => import(/* webpackChunkName: "js/products" */  "../pages/products/ProductsComponent");
const ProductCategoriesComponent = () => import(/* webpackChunkName: "js/product-categories" */  "../pages/product-categories/ProductsComponent");
const MarketplaceComponent = () => import(/* webpackChunkName: "js/marketplace" */  "../components/marketplace/MarketplaceComponent");
const ExampleComponent = () => import(/* webpackChunkName: "js/examples" */  "../components/ExampleComponent");


import QuotationRoutes from './quotations'
import OrderRoutes from './orders'
import InvoiceRoutes from './invoices'
import PurchaseRoutes from './purchases'
import BillsRoutes from './bills'
import OtherExpenseRoutes from './other-expenses'
import EmployeesRoutes from './employees'

const PromoCodesComponent = () => import(/* webpackChunkName: "js/promo-codes" */  "../components/promo-codes/PromocodesComponent");

const ClientsComponent = () => import(/* webpackChunkName: "js/clients" */  "../pages/clients/ClientsComponent");
const SuppliersComponent = () => import(/* webpackChunkName: "js/suppliers" */  "../pages/vendors/VendorsComponent");
const BusinessSettingComponent = () => import(/* webpackChunkName: "js/business-settings" */  "../pages/business-settings/BusinessSettingComponent");

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/@/dashboard',
            name: 'dashboard',
            component: ExampleComponent,
            meta: {type: 'dashboard'}
        },
        {
            path: '/@/products',
            name: 'products',
            meta: {type: 'products'},
            component: ProductsComponent,
        },
        {
            path: '/@/product-categories',
            name: 'product categories',
            meta: {type: 'products'},
            component: ProductCategoriesComponent,
        },
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
        {
            path: '/@/clients',
            name: 'clients',
            meta: {type: 'contacts'},
            component: ClientsComponent,
        },
        {
            path: '/@/suppliers',
            name: 'suppliers',
            meta: {type: 'contacts'},
            component: SuppliersComponent,
        },
        ...EmployeesRoutes,
        {
            path: '/@/business-settings',
            name: 'business settings',
            meta: {type: 'business'},
            component: BusinessSettingComponent,
        },
    ],
});

export default router
