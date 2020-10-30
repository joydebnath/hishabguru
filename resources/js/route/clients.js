const ClientsComponent = () => import(/* webpackChunkName: "js/clients" */  "../pages/clients/ClientsComponent");
const ClientStatsComponent = () => import(/* webpackChunkName: "js/client-stats" */  "../components/statistics/client/ClientStatComponent");

export default [
    {
        path: '/@/clients',
        name: 'clients',
        meta: {type: 'contacts'},
        component: ClientsComponent,
    },
    {
        path: '/@/stats/client/:id',
        name: 'client statistics',
        meta: {type: 'contacts'},
        component: ClientStatsComponent,
    },
]
