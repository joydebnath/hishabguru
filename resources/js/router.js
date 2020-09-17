import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const ProductsComponent = () => import(/* webpackChunkName: "js/products" */  "./components/products/ProductsComponent");
const ProductCategoriesComponent = () => import(/* webpackChunkName: "js/product-categories" */  "./components/product-categories/ProductsComponent");
const MarketplaceComponent = () => import(/* webpackChunkName: "js/marketplace" */  "./components/marketplace/MarketplaceComponent");
const ExampleComponent = () => import(/* webpackChunkName: "js/examples" */  "./components/ExampleComponent");
const QuotationsComponent = () => import(/* webpackChunkName: "js/quotations" */  "./components/quotations/QuotationsComponent");
const OrdersComponent = () => import(/* webpackChunkName: "js/orders" */  "./components/orders/OrdersComponent");
const PromoCodesComponent = () => import(/* webpackChunkName: "js/promo-codes" */  "./components/promo-codes/PromocodesComponent");
const InvoicesComponent = () => import(/* webpackChunkName: "js/invoices" */  "./components/invoices/InvoicesComponent");
const ClientsComponent = () => import(/* webpackChunkName: "js/clients" */  "./components/clients/ClientsComponent");
const SuppliersComponent = () => import(/* webpackChunkName: "js/suppliers" */  "./components/vendors/VendorsComponent");

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
        {
            path: '/@/quotations',
            name: 'quotations',
            meta: {type: 'business'},
            component: QuotationsComponent,
        },
        {
            path: '/@/orders',
            name: 'orders',
            meta: {type: 'business'},
            component: OrdersComponent,
        },
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
        {
            path: '/@/invoices',
            name: 'invoices',
            meta: {type: 'accounting'},
            component: InvoicesComponent,
        },
        {
            path: '/@/expenses',
            name: 'expenses',
            meta: {type: 'accounting'},
            component: ExampleComponent,
        },
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
        {
            path: '/@/employees',
            name: 'employees',
            meta: {type: 'teams'},
            component: ExampleComponent,
        },
        {
            path: '/@/leave-management',
            name: 'leave management',
            meta: {type: 'teams'},
            component: ExampleComponent,
        },
    ],
});

export default router
