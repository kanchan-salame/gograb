<template>
    <div class="col-span-6 sm:col-span-4">
        <jet-label for="discounted_amount" value="Discount" />
        <div class="flex rounded-md shadow-sm mt-1">
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                {{ clientCurrencySymbol }}
            </span>
            <jet-input @change="checkAmount($event)" id="discounted_amount" type="text" class="flex-1 block w-full rounded-l-none" v-model="discountItem.discounted_amount" />
        </div>
        <jet-input-error v-if="discountError !== ''" :message="discountError" class="mt-2" />
    
    </div>
        <div class="col-span-6 sm:col-span-4">
            <jet-label for="description" value="Description" />
            <jet-input id="description" v-model="discountItem.description" type="text" class="mt-1 block w-full" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 col-span-6 sm:col-span-4">
            <dl class="rounded-lg bg-white shadow-lg sm:grid sm:grid-cols-1">
               <div
                    class="flex flex-col border-b border-gray-100 p-6 text-center sm:border-0 sm:border-r">
                    <dt class="order-2 mt-2 leading-6 font-medium text-gray-500">
                        {{ teamCurrencyCode }}
                    </dt>
                    <dd class="order-1 text-xl font-extrabold gradient__text">
                        {{ teamCurrencySymbol }}{{ discountItem.total_alt }}
                    </dd>
                </div>
            </dl>
        </div>
        <div class="col-span-6">
            <div class="py-4">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
    <div class="col-span-6">
        <jet-button class="ml-2 text-sm px-10" @click.native="onDiscountAdd">
            <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true"/>
            Add
        </jet-button>
    </div>
    <!-- </jet-form-section> -->
</template>

<script>
import JetLabel from '@/Jetstream/Label'
import JetInputError from '@/Jetstream/InputError'
import JetButton from '@/Jetstream/Button'
import JetInput from '@/Jetstream/Input'
import { PlusIcon } from '@heroicons/vue/outline'

import { reactive, computed, watch, ref } from 'vue'

export default {
    components: {
        JetLabel,
        JetInputError,
        JetButton,
        JetInput,
        PlusIcon,
    },
    props: [
        'form',
        'teamCurrencyCode',
        'teamCurrencySymbol',
        'clientCurrencyCode',
        'clientCurrencySymbol',
        'validationError',
        'isDiffCurrency',
    ],
    emits: [ 'add-discount-item' ],
    setup(props, context) {
        const discountItem = reactive({
            description: '',
            total: '0.00',
            total_alt: '0.00',
            discounted_amount: '',
            quantity: '',
            unit_rate: '',
            alt_conversion_rate: props.form.alt_conversion_rate,
            item_id:'',
            project_id:'',
            timelog:[],
            type:"discount",
        })

        watch(() => [props.form.alt_conversion_rate, discountItem.discounted_amount], (newValues) => {
            if (newValues[0] !== '' || newValues[1] !== '') {
                let total = parseFloat(newValues[1]).toFixed(2);
                discountItem.total = total;
                discountItem.total_alt = parseFloat(newValues[0] * newValues[1]).toFixed(2);
            }
            discountItem.alt_conversion_rate = newValues[1];
        });

        /**
         * Validation for discount items
         */
        const discountError = ref('');

        const onDiscountAdd = () => {
            if (discountItem.discounted_amount == '') {
                discountError.value = 'Discount field is required.';
                return 
            }
            context.emit('add-discount-item', discountItem)
        }

        function checkAmount(e) {
            const input = e.target.value;
            if (Math.sign(input) > 0) {
                discountError.value = '';
            } else {
                discountError.value = 'Please enter valid positive number.';
            }
        }
       
        return {
            discountItem,
            discountError,
            onDiscountAdd,
            checkAmount,
        }
    },
}
</script>
