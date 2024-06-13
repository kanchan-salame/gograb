<template>
  <div>
    <jet-form-section class="mt-10 sm:mt-0">
      <template #title> Basic Information </template>

      <template #description>
        Provide basic information like Name, Image and image url for the Category.
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
                ref="categoryImage"
                @change="handleImageChange"
                class="flex-1 block w-full rounded"
                accept="image/*"
              />
            <jet-input-error :message="form.errors.image" class="mt-2" />
        </div>
        <div
          class="grid grid-cols-1 md:grid-cols-1 gap-2 col-span-6 sm:col-span-4"
        >
          <jet-label for="icon" value="Icon" />
          <jet-input
                id="icon"
                type="file"
                ref="categoryIcon"
                @change="handleIconChange"
                class="flex-1 block w-full rounded"
                accept="image/*"
              />
            <jet-input-error :message="form.errors.icon" class="mt-2" />
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
        @click="saveCategory"
      >
        {{ category ? "Update Category" : "Add Category" }}
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
import PrimaryButton from '@/Components/PrimaryButton.vue';

import {
  CalculatorIcon,
  AdjustmentsIcon,
  CalendarIcon,
} from "@heroicons/vue/outline";
import { reactive, computed, watch, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

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
    PrimaryButton
  },
  props: ["category"],
  setup(props) {
    const form = useForm({
        _method: props.category ? 'PUT' : 'POST',
      name: props.category ? props.category.name : "",
      image: props.category ? props.category.image : "",
      icon: props.category ? props.category.icon : "",
    });

    const handleImageChange = (event) => {
        console.log(event.target.files[0]);
            form.image = event.target.files[0];
            const reader = new FileReader();
            reader.readAsDataURL(form.image);
            reader.onload = (e) => {
            // previewImage.value = e.target.result;
        };
    }

    const handleIconChange = (event) => {
        console.log(event.target.files[0]);
            form.icon = event.target.files[0];
            const reader = new FileReader();
            reader.readAsDataURL(form.image);
            reader.onload = (e) => {
            // previewImage.value = e.target.result;
        };
    }

    // Save slider
    function saveCategory() {
        console.log(form);
      const options = {
        errorBag: "saveCategory",
        preserveScroll: (page) => Object.keys(page.props.errors).length,
        onError: () => {
          toast.error("Please check form errors!", {
                position: toast.POSITION.BOTTOM_RIGHT,
            });
        },
      };

      if (!props.category) {
        // New Category
        form.post(route("category.store"), options);
      } else {
        // Existing Category
        form.post(route("category.update", props.category.id), options);
      }
    }

    return {
      form,
      saveCategory,
      handleImageChange,
      handleIconChange
    };
  },
};
</script>

