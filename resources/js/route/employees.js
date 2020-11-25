const EmployeesComponent = () => import(/* webpackChunkName: "js/employees" */  "../pages/employees/EmployeesComponent");

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
    // {
    //     path: '/@/leave-management',
    //     name: 'leave management',
    //     meta: {type: 'teams'},
    //     component: ExampleComponent,
    // },
]
