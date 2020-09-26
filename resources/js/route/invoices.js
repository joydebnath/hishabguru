const InvoicesComponent = () => import(/* webpackChunkName: "js/invoices" */  "../components/invoices/InvoicesComponent");

export default [
    {
        path: '/@/invoices',
        name: 'invoices',
        meta: {type: 'accounting'},
        component: InvoicesComponent,
    },
]
