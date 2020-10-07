const InvoicesComponent = () => import(/* webpackChunkName: "js/invoices" */  "../pages/invoices/InvoicesComponent");
const InvoiceComponent = () => import(/* webpackChunkName: "js/invoice" */  "../components/crud/invoices/InvoiceComponent");
const CreateInvoiceComponent = () => import(/* webpackChunkName: "js/create-invoice" */  "../components/crud/invoices/CreateInvoiceComponent");

export default [
    {
        path: '/@/invoices',
        name: 'invoices',
        meta: {type: 'business'},
        component: InvoicesComponent,
    },
    {
        path: '/@/invoices/create',
        name: 'create an invoices',
        meta: {type: 'business'},
        component: CreateInvoiceComponent,
    },
    {
        path: '/@/invoices/:id',
        name: 'invoices details',
        meta: {type: 'business'},
        component: InvoiceComponent,
    },
]
