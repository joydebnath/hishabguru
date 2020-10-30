const ProductsComponent = () => import(/* webpackChunkName: "js/products" */  "../pages/products/ProductsComponent");
const ProductCategoriesComponent = () => import(/* webpackChunkName: "js/product-categories" */  "../pages/product-categories/ProductsComponent");
const ProductStatsComponent = () => import(/* webpackChunkName: "js/product-stats" */  "../components/statistics/product/ProductStatComponent");

export default [
    {
        path: '/@/products',
        name: 'products',
        meta: {type: 'products'},
        component: ProductsComponent,
    },
    {
        path: '/@/product-categories',
        name: 'product categories',
        meta: {type: 'products'},
        component: ProductCategoriesComponent,
    },
    {
        path: '/@/stats/product/:id',
        name: 'product statistics',
        meta: {type: 'products'},
        component: ProductStatsComponent,
    },
]
