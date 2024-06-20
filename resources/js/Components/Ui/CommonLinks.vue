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
      v-if="this.$page.props.auth.user != null"
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
          :href="route('cart.index')"
          :active="route().current('cart.index')"
          v-if="this.$page.props.auth.user.role == 'user'"
        >
          <UsersIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Cart
        </jet-nav-link>
        <jet-nav-link
          :href="route('user.myOrders')"
          :active="route().current('user.myOrders')"
          v-if="this.$page.props.auth.user.role == 'user'"
        >
          <UsersIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          My Orders
        </jet-nav-link>
        <jet-nav-link
          :href="route('restaurant.orders')"
          :active="route().current('restaurant.orders')"
          v-if="this.$page.props.auth.user.role == 'restaurant'"
        >
          <UsersIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Orders
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

        <jet-nav-link :href="route('notification.index')"
          :active="route().current('notification.index')"
          v-if="this.$page.props.auth.user.role == 'admin'">
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
          <sidebar-dropdown
            @click="dropdown()"
            v-if="this.$page.props.auth.user.role == 'admin'"
          >
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
            v-if="this.$page.props.auth.user.role == 'admin'"
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
              :href="route('foodOrder.index')"
              :active="route().current('foodOrder.index')"
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
          <sidebar-dropdown
            @click="dropdown2()"
            v-if="this.$page.props.auth.user.role == 'admin'"
          >
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
            v-if="this.$page.props.auth.user.role == 'admin'"
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
          <sidebar-dropdown
            @click="dropdown3()"
            v-if="this.$page.props.auth.user.role == 'admin'"
          >
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
            v-if="this.$page.props.auth.user.role == 'admin'"
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
          <sidebar-dropdown
            @click="dropdown4()"
            v-if="this.$page.props.auth.user.role == 'admin'"
          >
            <CubeTransparentIcon
              class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              aria-hidden="true"
            />
            Services
            <ChevronRightIcon
              class="flex mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              :class="rotate4"
              aria-hidden="true"
              style="right: -40px; position: relative"
            />
          </sidebar-dropdown>
          <div
            class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"
            id="submenu"
            :class="{ hidden: this.isHidden4 }"
            v-if="this.$page.props.auth.user.role == 'admin'"
          >
            <jet-nav-link
              :href="route('serviceCategory.index')"
              :active="route().current('serviceCategory.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Categories
            </jet-nav-link>
            <jet-nav-link
              :href="route('serviceSubCategory.index')"
              :active="route().current('serviceSubCategory.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Sub Categories
            </jet-nav-link>
            <jet-nav-link
              :href="route('service.index')"
              :active="route().current('service.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Services
            </jet-nav-link>
            <jet-nav-link
              :href="route('subService.index')"
              :active="route().current('subService.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Sub Services
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
              Bookings
            </jet-nav-link>
          </div>
          <sidebar-dropdown
            @click="dropdown6()"
            v-if="this.$page.props.auth.user.role == 'admin'"
          >
            <CubeTransparentIcon
              class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              aria-hidden="true"
            />
            Products
            <ChevronRightIcon
              class="flex mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              :class="rotate6"
              aria-hidden="true"
              style="right: -40px; position: relative"
            />
          </sidebar-dropdown>
          <div
            class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"
            id="submenu"
            :class="{ hidden: this.isHidden6 }"
            v-if="this.$page.props.auth.user.role == 'admin'"
          >
            <jet-nav-link
              :href="route('productCategory.index')"
              :active="route().current('productCategory.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Categories
            </jet-nav-link>
            <jet-nav-link
              :href="route('productSubCategory.index')"
              :active="route().current('productSubCategory.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Sub Categories
            </jet-nav-link>
            <jet-nav-link
              :href="route('product.index')"
              :active="route().current('product.index')"
              v-if="this.$page.props.auth.user.role == 'admin'"
            >
              <TruckIcon
                class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
                aria-hidden="true"
              />
              Products
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
          </div>
          <sidebar-dropdown
            @click="dropdown5()"
            v-if="this.$page.props.auth.user.role == 'admin'"
          >
            <CubeTransparentIcon
              class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              aria-hidden="true"
            />
            Predict Cost
            <ChevronRightIcon
              class="flex mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              :class="rotate5"
              aria-hidden="true"
              style="right: -40px; position: relative"
            />
          </sidebar-dropdown>
          <div
            class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"
            id="submenu"
            :class="{ hidden: this.isHidden5 }"
            v-if="this.$page.props.auth.user.role == 'admin'"
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
              Website
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
          <jet-nav-link
            :href="route('users.index')"
            :active="route().current('users.index')"
            v-if="this.$page.props.auth.user.role == 'admin'"
          >
            <TruckIcon
              class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
              aria-hidden="true"
            />
            Book Now
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
            Be Partner
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
            Invest Now
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
            Products
          </jet-nav-link>
          </div>
        </div>
    </nav>
    <nav
      class="mt-5 flex-1 flex flex-col divide-y divide-gray-800 overflow-y-auto"
      aria-label="Sidebar"
      v-else
    >
      <div class="px-2 space-y-1">
        <jet-nav-link
          :href="route('welcome.index')"
          :active="route().current('welcome.index')"
        >
          <HomeIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Home
        </jet-nav-link>
        <jet-nav-link
          :href="route('users.index')"
          :active="route().current('users.index')"
        >
          <UsersIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Users
        </jet-nav-link>
        <jet-nav-link
          :href="route('cart.index')"
          :active="route().current('cart.index')"
        >
          <ShoppingCartIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Cart
        </jet-nav-link>
        <jet-nav-link
          :href="route('register')"
          :active="route().current('register')"
        >
          <SaveAsIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Register
        </jet-nav-link>
        <jet-nav-link :href="route('login')" :active="route().current('login')">
          <LoginIcon
            class="mr-4 flex-shrink-0 h-6 w-6 group-hover:text-gray-700"
            aria-hidden="true"
          />
          Login
        </jet-nav-link>
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
  SaveAsIcon,
  LoginIcon,
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
    ShoppingCartIcon,
    SaveAsIcon,
    LoginIcon,
  },

  setup() {
    const isHidden = ref(true);
    const isHidden2 = ref(true);
    const isHidden3 = ref(true);
    const isHidden4 = ref(true);
    const isHidden5 = ref(true);
    const isHidden6 = ref(true);
    const isRotate = ref(true);
    // ...
    return {
      isHidden,
      isHidden2,
      isHidden3,
      isHidden4,
      isHidden5,
      isHidden6,
      isRotate,
    };
  },

  computed: {
    rotate() {
      return this.isHidden ? "rotate-0" : "rotate-90";
    },
    rotate2() {
      return this.isHidden2 ? "rotate-0" : "rotate-90";
    },
    rotate3() {
      return this.isHidden3 ? "rotate-0" : "rotate-90";
    },
    rotate4() {
      return this.isHidden4 ? "rotate-0" : "rotate-90";
    },
    rotate5() {
      return this.isHidden5 ? "rotate-0" : "rotate-90";
    },
    rotate6() {
      return this.isHidden6 ? "rotate-0" : "rotate-90";
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
    dropdown4() {
      this.isHidden4 = !this.isHidden4;
    },
    dropdown5() {
      this.isHidden5 = !this.isHidden5;
    },
    dropdown6() {
      this.isHidden6 = !this.isHidden6;
    },
  },
};
</script>
