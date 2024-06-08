<template>
  <div>
    <div class="flex items-center flex-shrink-0 px-4">
      <inertia-link :href="route('dashboard')">
        <jet-application-mark class="block h-9 w-auto" />
      </inertia-link>
    </div>
    <nav
      class="mt-5 flex-1 flex flex-col divide-y divide-gray-800 overflow-y-auto"
      aria-label="Sidebar"
    >
      <div class="px-2 space-y-1">
        <jet-nav-link
          :href="route('dashboard')"
          :active="route().current('dashboard')"
        >
          <HomeIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Dashboard
        </jet-nav-link>
        <jet-nav-link
          :href="route('users.index')"
          :active="route().current('users.index')"
          v-if="this.$page.props.auth.user.role == 'admin'"
        >
          <UsersIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Users
        </jet-nav-link>
        <jet-nav-link
          :href="route('users.index')"
          :active="route().current('users.index')"
          v-if="this.$page.props.auth.user.role == 'vendor'"
        >
          <AcademicCapIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Manage Restaurants
        </jet-nav-link>
        <jet-nav-link
          :href="route('users.index')"
          :active="route().current('users.index')"
          v-if="this.$page.props.auth.user.role == 'vendor'"
        >
          <TruckIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Manage Orders
        </jet-nav-link>
        <jet-nav-link v-if="this.$page.props.auth.user.role == 'admin'">
          <BellIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Notifications
        </jet-nav-link>
      </div>
      <div class="mt-6 pt-6">
        <div class="px-2 space-y-1">
          <div
            class="ml-2 relative text-gray-100 text-opacity-50 group-hover:text-gray-700"
            v-if="$page.props.jetstream.hasTeamFeatures"
          >
            {{ $page.props.auth.user.current_team.name }}
          </div>
          <sidebar-dropdown @click="dropdown()">
            <CakeIcon
              class="flex mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              aria-hidden="true"
            />
            Food Delivery
            <ChevronRightIcon
              class="flex mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              :class="rotate"
              aria-hidden="true"
              style="right: -40px; position: relative"
            />
          </sidebar-dropdown>
          <div
            class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"
            id="submenu"
            :class="{ hidden: this.isHidden }"
          >
            <jet-nav-link
              :href="route('restaurant.index')"
              :active="route().current('restaurant.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <OfficeBuildingIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Restaurants
            </jet-nav-link>
            <jet-nav-link
              :href="route('users.index')"
              :active="route().current('users.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Orders
            </jet-nav-link>
            <jet-nav-link
              :href="route('category.index')"
              :active="route().current('category.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <ViewBoardsIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Categories
            </jet-nav-link>
            <jet-nav-link
              :href="route('sliders.index')"
              :active="route().current('sliders.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <ColorSwatchIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Sliders
            </jet-nav-link>
          </div>
          <sidebar-dropdown @click="dropdown2()">
            <ShoppingCartIcon
              class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              aria-hidden="true"
            />
            Parcel Delivery
            <ChevronRightIcon
              class="flex mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              :class="rotate2"
              aria-hidden="true"
              style="right: -40px; position: relative"
            />
          </sidebar-dropdown>
          <div
            class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"
            id="submenu"
            :class="{ hidden: this.isHidden2 }"
          >
            <jet-nav-link
              :href="route('goodType.index')"
              :active="route().current('goodType.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <PaperAirplaneIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Good Type
            </jet-nav-link>
            <jet-nav-link
              :href="route('users.index')"
              :active="route().current('users.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Orders
            </jet-nav-link>
            <jet-nav-link
              :href="route('packageSize.index')"
              :active="route().current('packageSize.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <MailIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Package Size
            </jet-nav-link>
          </div>
          <sidebar-dropdown @click="dropdown3()">
            <CubeTransparentIcon
              class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              aria-hidden="true"
            />
            Ride Hailing
            <ChevronRightIcon
              class="flex mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              :class="rotate3"
              aria-hidden="true"
              style="right: -40px; position: relative"
            />
          </sidebar-dropdown>
          <div
            class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"
            id="submenu"
            :class="{ hidden: this.isHidden3 }"
          >
            <jet-nav-link
              :href="route('users.index')"
              :active="route().current('users.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Trip
            </jet-nav-link>
            <jet-nav-link
              :href="route('users.index')"
              :active="route().current('users.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Trip Requests
            </jet-nav-link>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>
<script type="text/javascript">
</script>
<script>
import {
  ClockIcon,
  CogIcon,
  HomeIcon,
  MenuAlt1Icon,
  OfficeBuildingIcon,
  ReceiptTaxIcon,
  CollectionIcon,
  ChevronRightIcon,
  UsersIcon,
  BellIcon,
  ViewBoardsIcon,
  AcademicCapIcon,
  ColorSwatchIcon,
  ShoppingCartIcon,
  PaperAirplaneIcon,
  MailIcon,
  TruckIcon,
  CakeIcon,
  CubeTransparentIcon,
} from "@heroicons/vue/outline";
import {
  CashIcon,
  CheckCircleIcon,
  ChevronDownIcon,
  SearchIcon,
  CreditCardIcon,
} from "@heroicons/vue/solid";

import JetNavLink from "@/Jetstream/NavLink.vue";
import SidebarDropdown from "@/Jetstream/SidebarDropdown.vue";
import JetApplicationMark from "@/Jetstream/ApplicationMark.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import { ref } from "vue";
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
    CollectionIcon,
    SidebarDropdown,
    UsersIcon,
    BellIcon,
    ViewBoardsIcon,
    AcademicCapIcon,
    CakeIcon,
    ColorSwatchIcon,
    ShoppingCartIcon,
    PaperAirplaneIcon,
    MailIcon,
    CubeTransparentIcon,
    TruckIcon,
  },

  setup() {
    const isHidden = ref(true);
    const isHidden2 = ref(true);
    const isHidden3 = ref(true);
    const isRotate = ref(true);
    // ...
    return {
      isHidden,
      isHidden2,
      isHidden3,
      isRotate,
    };
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
    rotate() {
      return this.isHidden ? "rotate-0" : "rotate-90";
    },
    rotate2() {
      return this.isHidden2 ? "rotate-0" : "rotate-90";
    },
    rotate3() {
      return this.isHidden3 ? "rotate-0" : "rotate-90";
    },
  },
  methods: {
    dropdown() {
      this.isHidden = !this.isHidden;
    },
    dropdown2() {
      this.isHidden2 = !this.isHidden2;
    },
    dropdown3() {
      this.isHidden3 = !this.isHidden3;
    },
  },
};
</script>
