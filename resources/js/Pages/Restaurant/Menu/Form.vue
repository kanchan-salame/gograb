<template>
  <div>
    <jet-form-section class="mt-10 sm:mt-0">
      <template #title> Basic Information </template>
      <template #description>
        Provide basic information like Image, name and description for the Restaurant menu.
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
            <jet-label for="description" value="Description" />
            <div class="flex rounded-md shadow-sm mt-1">
              <jet-input
                id="description"
                type="text"
                class="flex-1 block w-full rounded"
                v-model="form.description"
              />
            </div>
            <jet-input-error :message="form.errors.description" class="mt-2" />
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
        {{ restaurant ? "Update Restaurant Menu" : "Add Restaurant Menu" }}
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
      image: props.restaurant ? props.restaurant.image : "",
      description: props.restaurant ? props.restaurant.description : "",
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

