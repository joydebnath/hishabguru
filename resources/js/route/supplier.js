const SuppliersComponent = () => import(/* webpackChunkName: "js/suppliers" */  "../pages/suppliers/SuppliersComponent");
const SupplierStatsComponent = () => import(/* webpackChunkName: "js/supplier-stats" */  "../components/statistics/supplier/SupplierStatComponent");

export default [
    {
        path: '/@/suppliers',
        name: 'suppliers',
        meta: {type: 'contacts'},
        component: SuppliersComponent,
    },
    {
        path: '/@/stats/supplier/:id',
        name: 'supplier statistics',
        meta: {type: 'contacts'},
        component: SupplierStatsComponent,
    },
]
