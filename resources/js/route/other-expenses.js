const OtherExpensesComponent = () => import(/* webpackChunkName: "js/other-expenses" */  "../pages/other-expenses/OtherExpensesComponent");
const OtherExpenseComponent = () => import(/* webpackChunkName: "js/other-expense" */  "@/components/crud/other-expenses/OtherExpenseComponent");
const CreateOtherExpenseComponent = () => import(/* webpackChunkName: "js/create-other-expense" */  "@/components/crud/other-expenses/CreateOtherExpenseComponent");

export default [
    {
        path: '/@/other-expenses',
        name: 'other expenses',
        meta: {type: 'expenses'},
        component: OtherExpensesComponent,
    },
    {
        path: '/@/other-expenses/create',
        name: 'create an expenses',
        meta: {type: 'expenses'},
        component: CreateOtherExpenseComponent,
    },
    {
        path: '/@/other-expenses/:id',
        name: 'expense details',
        meta: {type: 'expenses'},
        component: OtherExpenseComponent,
    },
]
