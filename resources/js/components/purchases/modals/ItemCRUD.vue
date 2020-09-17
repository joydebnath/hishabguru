<template>
    <b-modal
        v-model="$props.show"
        has-modal-card
        :on-cancel="() => $emit('on-close')"
        :can-cancel="['x','escape']"
        trap-focus
        aria-role="dialog"
        aria-modal
        width="1000"
    >
        <div class="modal-card" style="width: 75rem">
            <header class="modal-card-head flex flex-row justify-between">
                <p class="text-lg text-gray-700" v-text="title"></p>
                <button type="button" class="delete" @click="$emit('on-close')"/>
            </header>
            <section class="modal-card-body">
                <div class="grid grid-cols-3 gap-2">
                    <div class="col-span-1">
                        <PurchaseDetails/>
                    </div>
                    <div class="col-span-2 ml-4">
                        <ProductsTable/>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot flex justify-content-end">
                <button class="button">Draft</button>
                <button class="button is-primary">Save</button>
            </footer>

        </div>
    </b-modal>
</template>

<script>
import PurchaseDetails from '../widgets/PurchaseDetails'
import ProductsTable from '../widgets/ProductsTable'

export default {
    props: {
        show: Boolean,
        action_type: String
    },
    components: {
        PurchaseDetails, ProductsTable
    },
    computed: {
        title() {
            return this.$props.action_type == "edit"
                ? "Edit Purchase"
                : "Create new Purchase";
        }
    }
};
</script>

<style></style>
