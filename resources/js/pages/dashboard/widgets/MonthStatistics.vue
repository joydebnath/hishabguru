<template>
    <nav class="level box shadow">
            <span class="text-gray-700 flex flex-col align-items-center">
                <small class="mb-0">Statistics</small>
                <span class="text-uppercase tracking-wider">{{ current_month_name }}</span>
            </span>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading text-green-700">Incomes</p>
                <p class="title flex flex-row">
                    <b-skeleton width="60px" height="10" :animated="false"/>
                </p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading text-orange-600">Expenses</p>
                <p class="title flex flex-row">
                    <b-skeleton width="60px" height="10" :animated="false"/>
                </p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading text-red-700">Bills to pay</p>
                <p class="title flex flex-row">
                    <b-skeleton width="60px" height="10" :animated="false"/>
                </p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading text-gray-800">Customer Due</p>
                <p class="title flex flex-row text-red-600">
                    <b-skeleton width="60px" height="10" :animated="false"/>
                </p>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "MonthStatistics",
    computed: {
        current_month_name() {
            return new Date().toLocaleString('default', {month: 'long'});
        }
    }
}
</script>

