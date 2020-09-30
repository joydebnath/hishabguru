const BillsComponent = () => import(/* webpackChunkName: "js/bills" */  "../pages/bills/BillsComponent");
const BillComponent = () => import(/* webpackChunkName: "js/bill" */  "@/components/crud/bills/BillComponent");
const CreateBillComponent = () => import(/* webpackChunkName: "js/create-bill" */  "@/components/crud/bills/CreateBillComponent");

export default [
    {
        path: '/@/bills',
        name: 'bills',
        meta: {type: 'expenses'},
        component: BillsComponent,
    },
    {
        path: '/@/bills/create',
        name: 'create a bill',
        meta: {type: 'expenses'},
        component: CreateBillComponent,
    },
    {
        path: '/@/bills/:id',
        name: 'bill details',
        meta: {type: 'expenses'},
        component: BillComponent,
    },
]
