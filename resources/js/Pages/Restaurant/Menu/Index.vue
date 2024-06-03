<script >
import AppLayout from "@/Layouts/AppLayout.vue";
import SubNavLink from "@/Components/Ui/SubNavLink.vue";
import SearchFilter from "@/Components/Ui/SearchFilter.vue";
import Pagination from "@/Components/Ui/Pagination.vue";
import { PlusIcon, PencilAltIcon, TrashIcon } from "@heroicons/vue/outline";
import JetConfirmationModal from "@/Components/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from '@/Jetstream/Button.vue';
import { Head, Link } from '@inertiajs/vue3';
import EmptyList from '@/Components/Ui/EmptyList.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ClockIcon, TagIcon, MenuIcon   } from "@heroicons/vue/solid"

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
    Head,
    EmptyList,
    PrimaryButton,
    Link,
    ClockIcon,
    TagIcon,
    MenuIcon
  },
  props: ["restaurant"],
  data() {
    return {
      restaurantBeingDeleted: null,
      restaurantBeingToggled: null,
      toggleRestaurantForm: this.$inertia.form({}),
    };
  },
  methods: {
    confirmRestaurantDelete(restaurant) {
      this.restaurantBeingDeleted = restaurant;
    },
    deleteRestaurant() {
      this.toggleRestaurantForm.delete(
        route("restaurant.destroy", this.restaurantBeingDeleted.id),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.restaurantBeingDeleted = null),
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
<Head title="Restaurants" />
  <AppLayout title="Restaurants">
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">Restaurant Menus</span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0">
          <primary-button @click="$inertia.get(route('restaurant.create'))">
            Add Restaurant Menu
          </primary-button>
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

                >

                </div>
                <EmptyList

                    icon="ClockIcon"
                    title="No Restaurant Menu"
                    description="Restaurant Menu not found. Get started by adding a new Restaurant Menus."
                    button-title="Add Restaurant Menus"
                    :button-url="route('restaurant.menu.create')"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"></div>
    </div>
    <!-- User Active toggle Confirmation Modal -->
        <jet-confirmation-modal :show="restaurantBeingToggled" @close="restaurantBeingToggled = null">
            <template #title>
                {{ restaurantBeingToggled.activated_at ?  'Deactivate' : 'Activate' }} Client
            </template>

            <template #content>
                Are you sure you would like to {{ restaurantBeingToggled.activated_at ?  'deactivate' : 'activate' }} {{ restaurantBeingToggled.id }}?
            </template>

            <template #footer>
                <jet-secondary-button @dblclick="restaurantBeingToggled = null">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="mr-2" @click="toggleClient"
                    :class="{ 'opacity-25': toggleRestaurantForm.processing }" :disabled="toggleRestaurantForm.processing"
                    v-if="restaurantBeingToggled.activated_at">
                    Deactivate
                </jet-danger-button>
                <jet-button class="mr-2" @click="toggleClient"
                    :class="{ 'opacity-25': toggleRestaurantForm.processing }" :disabled="toggleRestaurantForm.processing"
                    v-else>
                    Activate
                </jet-button>
            </template>
        </jet-confirmation-modal>
    <!-- User Delete  Confirmation Modal -->
    <jet-confirmation-modal
      :show="restaurantBeingDeleted"
      @close="restaurantBeingDeleted = null"
    >
      <template #title> Delete Restaurant </template>

      <template #content>
        Are you sure you would like to delete {{ restaurantBeingDeleted.name }}?
      </template>

      <template #footer>
        <jet-secondary-button
          @click="restaurantBeingDeleted = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="deleteRestaurant">
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </AppLayout>
</template>
