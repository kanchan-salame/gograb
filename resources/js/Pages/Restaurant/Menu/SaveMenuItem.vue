<template>
  <app-layout>
    <Head title="Menu Item" />
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">
              {{ menu ? "Update Restaurant Menu Item" : "Add Restaurant Menu Item" }}
            </span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0 relative z-1">
          <!-- <sub-nav-link :href="route('sliders.index')" :back="true" icon="Plus">
                    <span class="gradient__text">Go Back</span>
                </sub-nav-link> -->
        </div>
      </div>
    </template>

    <div>
      <div class="pb-10 sm:px-6 lg:px-8">
        <jet-form-section class="mt-10 sm:mt-0">
          <template #title> Basic Information </template>
          <template #description>
            Provide basic information like Image, name, price and description for the
            Restaurant menu.
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
                <jet-input-error
                  :message="form.errors.description"
                  class="mt-2"
                />
              </div>
            </div>
            <div class="col-span-6 sm:col-span-4">
              <div>
                <jet-label for="price" value="Price" />
                <div class="flex rounded-md shadow-sm mt-1">
                  <jet-input
                    id="price"
                    type="text"
                    class="flex-1 block w-full rounded"
                    v-model="form.price"
                  />
                </div>
                <jet-input-error
                  :message="form.errors.price"
                  class="mt-2"
                />
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
            @click="saveRestaurantMenu"
          >
            {{ restaurant ? "Update Restaurant Menu Item" : "Add Restaurant Menu Item" }}
          </primary-button>
        </form-actions>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SubNavLink from "@/Components/Ui/SubNavLink.vue";
import MenuForm from "@/Pages/Restaurant/Menu/Form.vue";
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
import { Head, Link } from "@inertiajs/vue3";
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
    AppLayout,
    SubNavLink,
    MenuForm,
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
    CalculatorIcon,
    AdjustmentsIcon,
    CalendarIcon,
    InputSelect,
    PrimaryButton,
  },
  props: ["menu"],
  setup(props) {
    const form = useForm({
      _method: props.menu ? "PUT" : "POST",
      name: props.menu ? props.menu.name : "",
      price: props.menu ? props.menu.price : "",
      image: props.menu ? props.menu.image : "",
      description: props.menu ? props.menu.description : "",
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
    function saveRestaurantMenu() {
      const options = {
        errorBag: "saveRestaurantMenu",
        preserveScroll: (page) => Object.keys(page.props.errors).length,
        onError: () => {
          toast.error("Please check form errors!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        },
      };

      if (!props.menu) {
        // New Item
        form.post(route("restaurant.store.menu.item", props.restaurant.id), options);
      } else {
        // Existing Item
        form.post(
          route("restaurant.update.menu.item", {
            restaurant: props.restaurant.id,
            restaurantMenu: props.menu.id,
          }),
          options
        );
      }
    }

    return {
      form,
      saveRestaurantMenu,
      handleFileChange,
    };
  },
};
</script>
