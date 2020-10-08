const EmployeesComponent = () => import(/* webpackChunkName: "js/employees" */  "../pages/employees/EmployeesComponent");
// const EmployeeComponent = () => import(/* webpackChunkName: "js/employee" */  "@/components/crud/bills/BillComponent");


export default [
    {
        path: '/@/employees',
        name: 'employees',
        meta: {type: 'teams'},
        component: EmployeesComponent,
    },
    // {
    //     path: '/@/employees/:id',
    //     name: 'employee details',
    //     meta: {type: 'teams'},
    //     component: EmployeeComponent,
    // },
]
