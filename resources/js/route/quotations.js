const QuotationsComponent = () => import(/* webpackChunkName: "js/quotations" */  "../components/quotations/QuotationsComponent");

export default [
    {
        path: '/@/quotations',
        name: 'quotations',
        meta: {type: 'business'},
        component: QuotationsComponent,
    },
]
