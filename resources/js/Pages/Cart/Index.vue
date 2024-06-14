<script >
import AppLayout from "@/Layouts/AppLayout.vue";
import SubNavLink from "@/Components/Ui/SubNavLink.vue";
import SearchFilter from "@/Components/Ui/SearchFilter.vue";
import Pagination from "@/Components/Ui/Pagination.vue";
import { PlusIcon, PencilAltIcon, TrashIcon } from "@heroicons/vue/outline";
import JetConfirmationModal from "@/Components/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import EmptyList from '@/Components/Ui/EmptyList.vue'

export default {
  components: {
    AppLayout,
    SubNavLink,
    SearchFilter,
    Pagination,
    PlusIcon,
    PencilAltIcon,
    TrashIcon,
    JetConfirmationModal,
    JetDangerButton,
    JetSecondaryButton,
    JetButton,
    EmptyList
  },
  props: ["carts"],
  data() {
    return {
      userBeingDeleted: null,
      userBeingToggled: null,
      filterStatus: "",
      toggleUserForm: this.$inertia.form({}),
      searchTerm: "",
      filters: [
        {
          title: "All",
          value: "",
        },
        {
          title: "Driver",
          value: "driver",
        },
        {
          title: "Users",
          value: "users",
        },
      ],
    };
  },
  methods: {

    total () {
        const price = 0;
        props.carts.forEach(element => {
            console.log(element.price);
            // element.price += element.price;
            // return element.price;

        });
    },
    confirmUserDelete(client) {
      this.userBeingDeleted = client;
    },
    deleteUser() {
      this.toggleUserForm.delete(
        route("cart.destroy", this.userBeingDeleted.id),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.userBeingDeleted = null),
          onError: (errors) => {
            const toast = useToast();
            toast.error(errors.id);
          },
        }
      );
    },
  },
};
</script>

<template>
  <AppLayout title="Cart">
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">Cart</span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0">
          <sub-nav-link :href="route('welcome.index')" icon="Plus">
            Continue Shopping
          </sub-nav-link>
        </div>
      </div>
    </template>

    <div>
      <div class="sm:px-6 lg:px-8 pb-20">
        <div>
          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div
                class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
              >
                <div
                  class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                  v-if="carts.length"
                >
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          #
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          ID
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Name
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Image
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Quantity
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Price
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Total
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Actions
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr
                        v-for="(cart, index) in carts"
                        :key="`cart-${cart.id}`"
                      >
                        <td class="px-6 py-4 whitespace-nowrap">
                          {{ index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm font-medium text-gray-900">
                            {{ cart.id }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900">
                            {{ cart.restaurant_menu_item.name }}
                          </div>
                        </td>
                        <td class="whitespace-nowrap text-right">
                          <img
                            :src="cart.restaurant_menu_item.imagepath"
                            :alt="cart.restaurant_menu_item.imagepath"
                            class="rounded-full h-20 w-20 object-cover"
                          />
                        </td>
                        <td class="whitespace-nowrap text-center">
                          {{ cart.quantity }}
                        </td>
                        <td class="whitespace-nowrap text-center">
                          {{ cart.restaurant_menu_item.price }}
                        </td>
                        <td class="whitespace-nowrap text-center">
                            {{ cart.quantity * cart.restaurant_menu_item.price }}
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex justify">
                            <button @click.prevent="confirmUserDelete(cart)">
                              <TrashIcon
                                class="ml-1 h-5 w-5 text-red-500 cursor-pointer"
                              />
                            </button>
                          </div>
                        </td>
                      </tr>

                      <!-- More rows... -->
                    </tbody>
                  </table>
                </div>
                <EmptyList
                    v-else
                    icon="ClockIcon"
                    title="No Items"
                    description="Items not found. Click on below button to continue shopping."
                    button-title="Continue Shopping"
                    :button-url="route('welcome.index')"
                />

                <div>
                    <span>Total Price: {{ 1000 }}</span> <br>
                    <a href="">Place Order</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"></div>
    </div>
    <!-- User Active toggle Confirmation Modal -->
    <jet-confirmation-modal
      :show="userBeingToggled"
      @close="userBeingToggled = null"
    >
      <template #title>
        {{ userBeingToggled.activated_at ? "Deactivate" : "Activate" }} Client
      </template>

      <template #content>
        Are you sure you would like to
        {{ userBeingToggled.activated_at ? "deactivate" : "activate" }}
        {{ userBeingToggled.name }}?
      </template>

      <template #footer>
        <jet-secondary-button @dblclick="userBeingToggled = null">
          Nevermind
        </jet-secondary-button>

        <jet-danger-button
          class="mr-2"
          @click="toggleClient"
          :class="{ 'opacity-25': toggleUserForm.processing }"
          :disabled="toggleUserForm.processing"
          v-if="userBeingToggled.activated_at"
        >
          Deactivate
        </jet-danger-button>
        <jet-button
          class="mr-2"
          @click="toggleClient"
          :class="{ 'opacity-25': toggleUserForm.processing }"
          :disabled="toggleUserForm.processing"
          v-else
        >
          Activate
        </jet-button>
      </template>
    </jet-confirmation-modal>
    <!-- User Delete  Confirmation Modal -->
    <jet-confirmation-modal
      :show="userBeingDeleted"
      @close="userBeingDeleted = null"
    >
      <template #title> Delete User </template>

      <template #content>
        Are you sure you would like to delete {{ userBeingDeleted.name }}?
      </template>

      <template #footer>
        <jet-secondary-button
          @click="userBeingDeleted = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="deleteUser">
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </AppLayout>
</template>
