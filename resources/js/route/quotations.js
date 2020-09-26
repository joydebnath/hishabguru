const QuotationsComponent = () => import(/* webpackChunkName: "js/quotations" */  "../components/quotations/QuotationsComponent");
const QuotationComponent = () => import(/* webpackChunkName: "js/quotation" */  "../components/crud/quotations/QuotationComponent");
const CreateQuotationComponent = () => import(/* webpackChunkName: "js/create-quotation" */  "../components/crud/quotations/CreateQuotationComponent");

export default [
    {
        path: '/@/quotations',
        name: 'quotations',
        meta: {type: 'business'},
        component: QuotationsComponent,
    },
    {
        path: '/@/quotations/create',
        name: 'create a quotation',
        meta: {type: 'business'},
        component: CreateQuotationComponent,
    },
    {
        path: '/@/quotations/:id',
        name: 'quotation details',
        meta: {type: 'business'},
        component: QuotationComponent,
    },
]
