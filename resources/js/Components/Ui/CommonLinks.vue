<template>
    <div>
        <div class="flex items-center flex-shrink-0 px-4">
            <inertia-link :href="route('dashboard')">
                <jet-application-mark class="block h-9 w-auto" />
            </inertia-link>
        </div>
        <nav class="mt-5 flex-1 flex flex-col divide-y divide-gray-800 overflow-y-auto" aria-label="Sidebar">
            <div class="px-2 space-y-1">
                <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                    <HomeIcon class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700" aria-hidden="true" />
                    Dashboard
                </jet-nav-link>
                <jet-nav-link>
                    <OfficeBuildingIcon class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700" aria-hidden="true" />
                    Users
                </jet-nav-link>
                <jet-nav-link >
                    <ClockIcon class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700" aria-hidden="true" />
                    Drivers
                </jet-nav-link>
                <jet-nav-link>
                    <CashIcon class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700" aria-hidden="true" />
                    Notifications
                </jet-nav-link>
            </div>
            <div class="mt-6 pt-6">
                <div class="px-2 space-y-1">
                    <div class="ml-2 relative text-gray-100 text-opacity-50 group-hover:text-gray-700" v-if="$page.props.jetstream.hasTeamFeatures">
                        {{ $page.props.auth.user.current_team.name }}
                    </div>
                   <!-- <jet-nav-link :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">
                        <CogIcon class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700" aria-hidden="true" />
                        Team Settings
                    </jet-nav-link> -->
                     <!-- <jet-nav-link :href="route('gstRate.index')" :active="isGstRateRoute" v-if="canManageInvoices">
                        <ReceiptTaxIcon class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700" aria-hidden="true" />
                        Manage GST Rates
                    </jet-nav-link>

                    <jet-nav-link :href="route('item.index')" :active="isItemRoute" v-if="canManageInvoices">
                        <CollectionIcon class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700" aria-hidden="true" />
                        Manage Items
                    </jet-nav-link>
                    <jet-nav-link :href="route('paymentMethod.index')" :active="isPaymentRoute">
                        <CashIcon class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700" aria-hidden="true" />
                        Payment Method
                    </jet-nav-link> -->
                </div>
            </div>
        </nav>
    </div>
</template>
<script>
import {
    ClockIcon,
    CogIcon,
    HomeIcon,
    MenuAlt1Icon,
    OfficeBuildingIcon,
    ReceiptTaxIcon,
    CollectionIcon,
} from '@heroicons/vue/outline'
import {
    CashIcon,
    CheckCircleIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    SearchIcon,
    CreditCardIcon,
} from '@heroicons/vue/solid'

import JetNavLink from '@/Jetstream/NavLink.vue'
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
// import { truncate } from '@/helpers'

export default {
    components: {
        JetApplicationMark,
        JetNavLink,
        JetDropdown,
        JetDropdownLink,
        CashIcon,
        CheckCircleIcon,
        ChevronDownIcon,
        ChevronRightIcon,
        MenuAlt1Icon,
        CreditCardIcon,
        OfficeBuildingIcon,
        SearchIcon,
        HomeIcon,
        ClockIcon,
        CogIcon,
        ReceiptTaxIcon,
        CollectionIcon
    },

    computed: {
        // isClientRoute() {
        //     return route().current('client.index') || route().current('client.create')
        //         || route().current('client.show') || route().current('client.edit')
        //         || route().current('project.index') || route().current('project.create')
        //         || route().current('project.show') || route().current('project.edit');
        // },

        // isTimelogRoute() {
        //     return route().current('timelog.index') || route().current('timelog.create')
        //         || route().current('timelog.show') || route().current('timelog.edit');
        // },

        // isInvoiceRoute() {
        //     return route().current('invoice.index') || route().current('invoice.create')
        //         || route().current('invoice.show') || route().current('invoice.edit');
        // },

        // isGstRateRoute() {
        //     return route().current('gstRate.index') || route().current('gstRate.create')
        //         || route().current('gstRate.show') || route().current('gstRate.edit');
        // },

        // isItemRoute(){
        //     return route().current('item.index') || route().current('item.create')
        //         || route().current('item.show') || route().current('item.edit');
        // },

        // isPaymentRoute() {
        //     return route().current('paymentMethod.index') || route().current('paymentMethod.create')
        //         || route().current('paymentMethod.edit');
        // },

        // canManageClients() {
        //     return this.hasTeamPermission('clients:manage');
        // },

        // canManageInvoices() {
        //     return this.hasTeamPermission('invoices:manage');
        // },

        // teamName() {
        //     return truncate(this.$page.props.user.current_team.name, 20)
        // }
    },


}

document.addEventListener("DOMContentLoaded", function () {
      // Obtener todas las opciones principales con desplegables
      const opcionesConDesplegable = document.querySelectorAll(".opcion-con-desplegable");

      // Agregar evento de clic a cada opción principal
      opcionesConDesplegable.forEach(function (opcion) {
        opcion.addEventListener("click", function () {
          // Obtener el desplegable asociado a la opción
          const desplegable = opcion.querySelector(".desplegable");

          // Alternar la clase "hidden" para mostrar u ocultar el desplegable
          desplegable.classList.toggle("hidden");
        });
      });
    })
</script>
