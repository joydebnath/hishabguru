<template>
    <div class="relative bg-white mt-px">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-row justify-center items-center border-b-2 border-gray-100 py-2 md:space-x-10">
                <nav class="hidden md:flex space-x-10">
                    <DashboardMenu :active="active"/>
                    <InventoryMenu :active="active"/>
                    <BusinessMenu :active="active"/>
                    <ExpenseMenu :active="active"/>
<!--                    <AccountingMenu :active="active"/>-->
                    <ContactsMenu :active="active"/>
                    <TeamsMenu :active="active"/>
                </nav>
            </div>
        </div>
    </div>

</template>

<script>
import AccountingMenu from "./menus/AccountingMenu";
import BusinessMenu from "./menus/BusinessMenu";
import ContactsMenu from "./menus/ContactsMenu";
import DashboardMenu from "./menus/DashboardMenu";
import ExpenseMenu from "./menus/ExpenseMenu";
import InventoryMenu from "./menus/InventoryMenu";
import TeamsMenu from "./menus/TeamsMenu";

export default {
    name: "TopMenuBar",
    props: {
        active: String
    },
    components: {AccountingMenu, BusinessMenu, ContactsMenu, DashboardMenu,ExpenseMenu, InventoryMenu, TeamsMenu}
}
</script>

