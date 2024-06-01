<template>
  <app-layout>
    <Head title="Restaurant Timing" />
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800"> Restaurant Timing </span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0 relative z-1">
          <primary-button @click="$inertia.get(route('restaurant.index'))">
            Go Back
          </primary-button>
        </div>
      </div>
    </template>

    <div>
      <div class="pb-10 sm:px-6 lg:px-8">
        <jet-form-section class="mt-10 sm:mt-0">
          <template #title> Basic Information </template>
          <template #description>
            Provide basic information like Image and image url for the
            Restaurant.
          </template>
          <template #form>
            <div class="col-span-6 sm:col-span-4">
              <div>
                <jet-label for="name" value="Name" />
                <div class="flex rounded-md shadow-sm mt-1">
                  <jet-input
                    id="name"
                    type="text"
                    class="flex-1 block w-full rounded"
                    v-model="form.name"
                  />
                </div>
                <jet-input-error :message="form.errors.name" class="mt-2" />
              </div>
            </div>
            <div
              class="grid grid-cols-1 md:grid-cols-1 gap-2 col-span-6 sm:col-span-4"
            >
              <jet-label for="image" value="Image" />
              <jet-input
                id="image"
                type="file"
                ref="restaurantImage"
                @change="handleFileChange"
                class="flex-1 block w-full rounded"
                accept="image/*"
              />
              <jet-input-error :message="form.errors.image" class="mt-2" />
            </div>
          </template>
        </jet-form-section>
        <div class="hidden sm:block">
          <div class="py-8">
            <div class="border-t border-gray-200" />
          </div>
        </div>
        <jet-form-section class="mt-10 sm:mt-0">
          <template #title> Longitude/Latitude Information </template>
          <template #description>
            Provide basic information like Longitude and Latitude url for the
            Restaurant.
          </template>
          <template #form>
            <div class="col-span-6 sm:col-span-4">
              <div>
                <jet-label for="longitude" value="Longitude" />
                <div class="flex rounded-md shadow-sm mt-1">
                  <jet-input
                    id="longitude"
                    type="text"
                    class="flex-1 block w-full rounded"
                    v-model="form.longitude"
                  />
                </div>
                <jet-input-error
                  :message="form.errors.longitude"
                  class="mt-2"
                />
              </div>
            </div>
            <div
              class="grid grid-cols-1 md:grid-cols-1 gap-2 col-span-6 sm:col-span-4"
            >
              <div>
                <jet-label for="latitude" value="Latitude" />
                <div class="flex rounded-md shadow-sm mt-1">
                  <jet-input
                    id="latitude"
                    type="text"
                    class="flex-1 block w-full rounded"
                    v-model="form.latitude"
                  />
                </div>
                <jet-input-error :message="form.errors.latitude" class="mt-2" />
              </div>
            </div>
          </template>
        </jet-form-section>
        <div class="hidden sm:block">
          <div class="py-8">
            <div class="border-t border-gray-200" />
          </div>
        </div>
        <jet-form-section class="mt-10 sm:mt-0">
          <template #title> Price Information </template>
          <template #description>
            Provide Price information like order price and delivery price for
            the Restaurant.
          </template>
          <template #form>
            <div class="col-span-6 sm:col-span-4">
              <div>
                <jet-label for="order-price" value="Min Order Price" />
                <div class="flex rounded-md shadow-sm mt-1">
                  <jet-input
                    id="order-price"
                    type="text"
                    class="flex-1 block w-full rounded"
                    v-model="form.min_order_price"
                  />
                </div>
                <jet-input-error
                  :message="form.errors.min_order_price"
                  class="mt-2"
                />
              </div>
            </div>
            <div
              class="grid grid-cols-1 md:grid-cols-1 gap-2 col-span-6 sm:col-span-4"
            >
              <div>
                <jet-label for="delivery_fee" value="Delivery Fee" />
                <div class="flex rounded-md shadow-sm mt-1">
                  <jet-input
                    id="delivery_fee"
                    type="text"
                    class="flex-1 block w-full rounded"
                    v-model="form.delivery_fee"
                  />
                </div>
                <jet-input-error
                  :message="form.errors.delivery_fee"
                  class="mt-2"
                />
              </div>
            </div>
          </template>
        </jet-form-section>
        <div class="hidden sm:block">
          <div class="py-8">
            <div class="border-t border-gray-200" />
          </div>
        </div>
        <jet-form-section class="mt-10 sm:mt-0">
          <template #title> Time Information </template>
          <template #description>
            Provide Time information like order Delivery max and min time for
            the Restaurant.
          </template>
          <template #form>
            <div class="col-span-6 sm:col-span-4">
              <div>
                <jet-label for="max-time" value="Delivery Max Time" />
                <div class="flex rounded-md shadow-sm mt-1">
                  <jet-input
                    id="max-time"
                    type="text"
                    class="flex-1 block w-full rounded"
                    v-model="form.delivery_max_time"
                  />
                </div>
                <jet-input-error
                  :message="form.errors.delivery_max_time"
                  class="mt-2"
                />
              </div>
            </div>
            <div
              class="grid grid-cols-1 md:grid-cols-1 gap-2 col-span-6 sm:col-span-4"
            >
              <jet-label for="min-time" value="Delivery Min Time" />
              <div class="flex rounded-md shadow-sm mt-1">
                <jet-input
                  id="min-time"
                  type="text"
                  class="flex-1 block w-full rounded"
                  v-model="form.delivery_min_time"
                />
              </div>
              <jet-input-error
                :message="form.errors.delivery_min_time"
                class="mt-2"
              />
            </div>
          </template>
        </jet-form-section>
        <form-actions>
          <jet-action-message class="mr-3"> Added. </jet-action-message>
          <jet-secondary-button
            class="text-sm px-10"
            @click="$inertia.get(route('restaurants.index'))"
          >
            Nevermind
          </jet-secondary-button>
          <primary-button
            class="ml-2 text-sm px-10"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="saveRestaurant"
          >
            {{ restaurant ? "Update Restaurant" : "Add Restaurant" }}
          </primary-button>
        </form-actions>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SubNavLink from "@/Components/Ui/SubNavLink.vue";
import ItemForm from "@/Pages/Restaurant/Form.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import CheckBox from "@/Jetstream/Checkbox.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetTextArea from "@/Jetstream/TextArea.vue";
import InputHelp from "@/Components/Form/InputHelp.vue";
import InputSelect from "@/Components/Form/Select.vue";
import FormActions from "@/Components/Form/Actions.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
export default {
  components: {
    AppLayout,
    SubNavLink,
    ItemForm,
    Head,
    JetFormSection,
    JetInputError,
    JetLabel,
    JetInput,
    JetSectionBorder,
    JetActionMessage,
    JetSecondaryButton,
    JetButton,
    JetTextArea,
    InputHelp,
    FormActions,
    InputSelect,
    PrimaryButton,
    CheckBox
  },
  props: ["restaurant"],
  setup(props) {
    const form = useForm({
      days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
      opening_times:[],
      closing_times:[],
    });

    const isChecked = ref(false);
    const checked = ref('checked');



    // Save restaurant
    function saveRestaurantCategories() {
      const options = {
        errorBag: "saveRestaurantCategories",
        preserveScroll: (page) => Object.keys(page.props.errors).length,
        onError: () => {
          toast.error("Please check form errors!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        },
      };

        form.post(route("restaurant.update.categories" , props.restaurant.id), options);

    }

    return {
      form,
      saveRestaurantCategories,
      isChecked,
      checked,
    };
  },
  computed: {
    title() {
      return props.restaurant ? "Update Restaurant" : "Add Restaurant";
    },
  },
};
</script>
