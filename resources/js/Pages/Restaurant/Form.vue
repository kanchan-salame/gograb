<template>
  <div>
    <jet-form-section class="mt-10 sm:mt-0">
      <template #title> Basic Information </template>
      <template #description>
        Provide basic information like Image and image url for the Restaurant.
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
        <div class="col-span-6 sm:col-span-4">
          <div>
            <jet-label for="email" value="Email" />
            <div class="flex rounded-md shadow-sm mt-1">
              <jet-input
                id="email"
                type="text"
                class="flex-1 block w-full rounded"
                v-model="form.email"
              />
            </div>
            <jet-input-error :message="form.errors.email" class="mt-2" />
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
            <jet-input-error :message="form.errors.longitude" class="mt-2" />
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
        Provide Price information like order price and delivery price for the
        Restaurant.
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
            <jet-input-error :message="form.errors.delivery_fee" class="mt-2" />
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
        Provide Time information like order Delivery max and min time for the
        Restaurant.
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
</template>

<script>
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetTextArea from "@/Jetstream/TextArea.vue";
import InputHelp from "@/Components/Form/InputHelp.vue";
import InputSelect from "@/Components/Form/Select.vue";
import FormActions from "@/Components/Form/Actions.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

import {
  CalculatorIcon,
  AdjustmentsIcon,
  CalendarIcon,
  //   SectionBorder,
} from "@heroicons/vue/outline";
import { reactive, computed, watch, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
  components: {
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
    CalculatorIcon,
    AdjustmentsIcon,
    CalendarIcon,
    InputSelect,
    PrimaryButton,
  },
  props: ["restaurant"],
  setup(props) {
    const form = useForm({
        _method: props.restaurant ? 'PUT' : 'POST',
      name: props.restaurant ? props.restaurant.name : "",
      email: props.restaurant ? props.restaurant.email : "",
      image: props.restaurant ? props.restaurant.image : "",
      latitude: props.restaurant ? props.restaurant.latitude : "",
      longitude: props.restaurant ? props.restaurant.longitude : "",
      min_order_price: props.restaurant ? props.restaurant.min_order_price : "",
      delivery_fee: props.restaurant ? props.restaurant.delivery_fee : "",
      delivery_max_time: props.restaurant ? props.restaurant.delivery_max_time : "",
      delivery_min_time: props.restaurant ? props.restaurant.delivery_min_time : "",
    });

    const handleFileChange = (event) => {
      console.log(event.target.files[0]);
      form.image = event.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(form.image);
      reader.onload = (e) => {
        // previewImage.value = e.target.result;
      };
    };

    // Save restaurant
    function saveRestaurant() {
      const options = {
        errorBag: "saveRestaurant",
        preserveScroll: (page) => Object.keys(page.props.errors).length,
        onError: () => {
          toast.error("Please check form errors!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        },
      };

      if (!props.restaurant) {
        // New Item
        form.post(route("restaurant.store"), options);
      } else {
        // Existing Item
        form.post(route("restaurant.update", props.restaurant.id), options);
      }
    }

    return {
      form,
      saveRestaurant,
      handleFileChange,
    };
  },
};
</script>

