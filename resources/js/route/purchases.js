const PurchasesComponent = () => import(/* webpackChunkName: "js/purchases" */  "../components/purchases/PurchasesComponent");
const PurchaseComponent = () => import(/* webpackChunkName: "js/purchase" */  "../components/crud/purchases/PurchaseComponent");
const CreatePurchaseComponent = () => import(/* webpackChunkName: "js/create-purchase" */  "../components/crud/purchases/CreatePurchaseComponent");

export default [
    {
        path: '/@/purchases',
        name: 'purchases',
        meta: {type: 'expenses'},
        component: PurchasesComponent,
    },
    {
        path: '/@/purchases/create',
        name: 'create a purchase',
        meta: {type: 'expenses'},
        component: CreatePurchaseComponent,
    },
    {
        path: '/@/purchases/:id',
        name: 'purchase details',
        meta: {type: 'expenses'},
        component: PurchaseComponent,
    },
]
