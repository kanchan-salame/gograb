<template>
  <div>
    <jet-form-section class="mt-10 sm:mt-0">
      <template #title> Basic Information </template>

      <template #description>
        Provide basic information like Name for the Good Type.
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
      </template>
    </jet-form-section>

    <form-actions>
      <jet-action-message class="mr-3"> Added. </jet-action-message>

      <jet-secondary-button
        class="text-sm px-10"
        @click="$inertia.get(route('goodType.index'))"
      >
        Nevermind
      </jet-secondary-button>

      <primary-button
        class="ml-2 text-sm px-10"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
        @click="saveGoodType"
      >
        {{ goodType ? "Update Good Type" : "Add Good Type" }}
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
  props: ["goodType"],
  setup(props) {
    const form = useForm({
        _method: props.goodType ? 'PUT' : 'POST',
      name: props.goodType ? props.goodType.name : "",
    });

    // Save slider
    function saveGoodType() {
      const options = {
        errorBag: "saveGoodType",
        preserveScroll: (page) => Object.keys(page.props.errors).length,
        onError: () => {
          toast.error("Please check form errors!", {
                position: toast.POSITION.BOTTOM_RIGHT,
            });
        },
      };

      if (!props.goodType) {
        // New goodtype
        form.post(route("goodType.store"), options);
      } else {
        // Existing goodtype
        form.post(route("goodType.update", props.goodType.id), options);
      }
    }

    return {
      form,
      saveGoodType,
    };
  },
};
</script>

