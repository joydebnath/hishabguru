const OrdersComponent = () => import(/* webpackChunkName: "js/orders" */  "../components/orders/OrdersComponent");
const OrderComponent = () => import(/* webpackChunkName: "js/order" */  "../components/crud/orders/OrderComponent");
const CreateOrderComponent = () => import(/* webpackChunkName: "js/create-order" */  "../components/crud/orders/CreateOrderComponent");

export default [
    {
        path: '/@/orders',
        name: 'orders',
        meta: {type: 'business'},
        component: OrdersComponent,
    },
    {
        path: '/@/orders/create',
        name: 'create an order',
        meta: {type: 'business'},
        component: CreateOrderComponent,
    },
    {
        path: '/@/orders/:id',
        name: 'order details',
        meta: {type: 'business'},
        component: OrderComponent,
    },
]
