<template>
  <div>
    <jet-form-section class="mt-10 sm:mt-0">
      <template #title> Basic Information </template>

      <template #description>
        Provide basic information like Image and image url for the Item.
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
            <jet-label for="serviceSubCategory" value="Service Category" />
            <div class="flex rounded-md shadow-sm mt-1">
              <input-select
                id="serviceCategory"
                class="flex-1 block w-full rounded"
                :options="serviceCategoriesOptions"
                v-model="form.service_category_id"
                :empty="'Select Category'"
              />
            </div>
            <jet-input-error
              :message="form.errors.service_category_id"
              class="mt-2"
            />
          </div>
        </div>
        <div class="col-span-6 sm:col-span-4">
          <div>
            <jet-label for="serviceSubCategory" value="Service Sub Category" />
            <div class="flex rounded-md shadow-sm mt-1">
              <input-select
                id="serviceSubCategory"
                class="flex-1 block w-full rounded"
                :options="serviceSubCategoriesOptions"
                v-model="form.service_sub_category_id"
                :empty="'Select Sub Category'"
              />
            </div>
            <jet-input-error
              :message="form.errors.service_sub_category_id"
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
            ref="sliderImage"
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
        @click="$inertia.get(route('sliders.index'))"
      >
        Nevermind
      </jet-secondary-button>

      <primary-button
        class="ml-2 text-sm px-10"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
        @click="saveItem"
      >
        {{ service ? "Update Service" : "Add Service" }}
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
import axios from "axios";
import PrimaryButton from "@/Components/PrimaryButton.vue";

import {
  CalculatorIcon,
  AdjustmentsIcon,
  CalendarIcon,
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
  props: ["service", "serviceCategories"],
  setup(props) {
    const form = useForm({
      _method: props.service ? "PUT" : "POST",
      name: props.service ? props.service.name : "",
      image: props.service ? props.service.image : "",
      service_category_id: props.service
        ? props.service.service_category_id
        : "",
      service_sub_category_id: props.service
        ? props.service.service_sub_category_id
        : "",
    });

    const serviceCategoriesOptions = [];
    const serviceSubCategoriesOptions = [];


    props.serviceCategories.forEach(element => {
        let option = { 'value': element.id, 'label': element.name}
        serviceCategoriesOptions.push(option)
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

    // Save slider
    function saveItem() {
      const options = {
        errorBag: "saveItem",
        preserveScroll: (page) => Object.keys(page.props.errors).length,
        onError: () => {
          toast.error("Please check form errors!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        },
      };

      if (!props.service) {
        // New Item
        form.post(route("service.store"), options);
      } else {
        // Existing Item
        form.post(route("service.update", props.service.id), options);
      }
    }

    return {
      form,
      saveItem,
      handleFileChange,
      serviceCategoriesOptions,
      serviceSubCategoriesOptions
    };
  },
};
</script>

