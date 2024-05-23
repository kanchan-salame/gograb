<template>
    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
        <h2
            class="
            text-lg leading-6 font-medium text-gray-900 my-3
            "
        >
            GST Details
        </h2>
            <div class="-my-2 overflow-auto sm:-mx-6 lg:-mx-8">
                <div
                    class="
                        py-2
                        align-middle
                        inline-block
                        min-w-full
                        sm:px-6
                        lg:px-8
                    "
                >
                    <div
                        class="
                            shadow
                            overflow-hidden
                            border-b border-gray-200
                            sm:rounded-lg
                        "
                    >
                        <table
                            class="min-w-full divide-y divide-gray-200"
                            v-if="(gstInvoiceContent.cgst_amount !== null && gstInvoiceContent.sgst_amount !== null) || (gstInvoiceContent.igst_amount !== null)"
                        >
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-r
                                        "
                                        rowspan="2"
                                        :width="(gstInvoiceContent.cgst_amount !== null && gstInvoiceContent.sgst_amount !== null) ? '20%' : '40%'"
                                    >
                                        HSN/SAC Code
                                    </th>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-r
                                        "
                                        rowspan="2"
                                        :width="(gstInvoiceContent.cgst_amount !== null && gstInvoiceContent.sgst_amount !== null) ? '20%' : '15%'"
                                    >
                                        Taxable Value
                                    </th>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-b
                                        "
                                        colspan="2"
                                        :width="(gstInvoiceContent.cgst_amount !== null && gstInvoiceContent.sgst_amount !== null) ? '20%' : '20%'"
                                        v-if="gstInvoiceContent.cgst_amount && gstInvoiceContent.sgst_amount !== null"
                                    >
                                        CGST
                                    </th>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-b
                                            border-l
                                        "
                                        colspan="2"
                                        :width="(gstInvoiceContent.cgst_amount !== null && gstInvoiceContent.sgst_amount !== null) ? '20%' : '20%'"
                                        v-if="gstInvoiceContent.cgst_amount && gstInvoiceContent.sgst_amount !== null"
                                    >
                                        SGST
                                    </th>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-b
                                            border-l
                                        "
                                        colspan="2"
                                        :width="(gstInvoiceContent.cgst_amount !== null && gstInvoiceContent.sgst_amount !== null) ? '20%' : '25% '"
                                        v-if="gstInvoiceContent.igst_amount !== null"
                                    >
                                        IGST
                                    </th>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-l
                                        "
                                        rowspan="2"
                                        :width="(gstInvoiceContent.cgst_amount !== null && gstInvoiceContent.sgst_amount !== null) ? '20%' : '20%'"
                                    >
                                        Total <span
                                            >Tax Amount</span
                                        >
                                    </th>
                                </tr>
                                <tr>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-r
                                        "
                                        width="10%"
                                        v-if="gstInvoiceContent.cgst_amount && gstInvoiceContent.sgst_amount !== null"
                                    >
                                        Rate
                                    </th>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-r
                                        "
                                        width="10%"
                                        v-if="gstInvoiceContent.cgst_amount && gstInvoiceContent.sgst_amount !== null"
                                    >
                                    Amount
                                    </th>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-r
                                        "
                                        width="10%"
                                        v-if="gstInvoiceContent.cgst_amount && gstInvoiceContent.sgst_amount !== null"
                                    >
                                        Rate
                                    </th>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                        "
                                        width="10%"
                                        v-if="gstInvoiceContent.cgst_amount && gstInvoiceContent.sgst_amount !== null"
                                    >
                                        Amount
                                    </th>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-l
                                        "
                                        width="10%"
                                        v-if="gstInvoiceContent.igst_amount !== null"
                                    >
                                        Rate
                                    </th>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-500
                                            uppercase
                                            tracking-wider
                                            border-l
                                        "
                                        width="10%"
                                        v-if="gstInvoiceContent.igst_amount !== null"
                                    >
                                    Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="
                                    bg-white
                                    divide-y divide-gray-200
                                "
                            >
                                <tr
                                    v-for="(item, index) in gstInvoiceContent"
                                    :key="index"
                                >
                                    <td
                                        class="
                                            px-3
                                            py-4
                                            text-xs text-gray-900
                                            border-r
                                        "
                                    >
                                        <div
                                            class="
                                                text-xs text-gray-900
                                            "
                                        >
                                            <span v-if="item.type == 'product'">
                                            HSN
                                            Code:
                                            {{ item.gst_rate.code }}
                                            </span>
                                            <span v-if="item.type == 'service'">
                                            SAC
                                            Code:
                                            {{ item.gst_rate.code }}
                                            </span> -
                                            {{
                                                item.gst_rate
                                                    .description
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        class="
                                            px-3
                                            py-4
                                            whitespace-nowrap
                                            text-xs text-gray-900
                                            border-r
                                            text-center
                                        "
                                    >

                                        {{
                                            client.currency
                                                .symbol
                                        }}{{ item.items_total }}
                                    </td>
                                    <td
                                        class="
                                            px-3
                                            py-4
                                            whitespace-nowrap
                                            text-xs text-gray-900
                                            border-r
                                            text-center
                                        "
                                        v-if="item.cgst_amount && item.sgst_amount !== null"
                                    >
                                        {{
                                            item.gst_rate.cgst_rate
                                                ? item.gst_rate.cgst_rate + '%'
                                                : '-'
                                        }}
                                    </td>
                                    <td
                                        class="
                                            px-3
                                            py-4
                                            whitespace-nowrap
                                            text-xs text-gray-900
                                            border-r
                                            text-center
                                        "
                                            v-if="item.cgst_amount && item.sgst_amount !== null"
                                    >
                                        <span v-if="item.cgst_amount !== null">
                                            {{
                                                client.currency
                                                    .symbol
                                            }}
                                        </span>{{
                                            item.cgst_amount
                                                ? item.cgst_amount
                                                : '-'
                                        }}
                                    </td>
                                    <td
                                        class="
                                            px-3
                                            py-4
                                            whitespace-nowrap
                                            text-xs text-gray-900
                                            border-r
                                            text-center
                                        "  v-if="item.cgst_amount && item.sgst_amount !== null">
                                        {{
                                            item.gst_rate.sgst_rate
                                                ? item.gst_rate.sgst_rate + '%'
                                                : '-'
                                        }}
                                        </td>
                                    <td
                                        class="
                                            px-3
                                            py-4
                                            whitespace-nowrap
                                            text-xs text-gray-900
                                            border-r
                                            text-center
                                        "  v-if="item.cgst_amount && item.sgst_amount !== null">
                                        <span v-if="item.sgst_amount !== null">
                                            {{
                                                client.currency
                                                    .symbol
                                            }}
                                        </span>{{
                                            item.sgst_amount
                                                ? item.sgst_amount
                                                : '-'
                                        }}
                                        </td>
                                    <td
                                        class="
                                            px-3
                                            py-4
                                            whitespace-nowrap
                                            text-xs text-gray-900
                                            border-r
                                            text-center
                                        " v-if="item.igst_amount !== null">
                                        {{
                                            item.gst_rate.igst_rate
                                                ? item.gst_rate.igst_rate + '%'
                                                : '-'
                                        }}
                                        </td>
                                    <td
                                        class="
                                            px-3
                                            py-4
                                            whitespace-nowrap
                                            text-xs text-gray-900
                                            border-r
                                            text-center
                                        " v-if="item.igst_amount !== null">
                                        <span v-if="item.igst_amount !== null">
                                            {{
                                                client.currency
                                                    .symbol
                                            }}
                                        </span>{{
                                            item.igst_amount
                                                ? item.igst_amount
                                                : '-'
                                        }}
                                    </td>
                                    <td
                                        class="
                                            px-3
                                            py-4
                                            whitespace-nowrap
                                            text-xs text-gray-900
                                            border-r
                                            text-center
                                        ">
                                        {{
                                            client.currency
                                                .symbol
                                        }}{{
                                            !item.igst_amount
                                                ? item.cgst_amount + item.sgst_amount
                                                : item.igst_amount
                                        }}
                                    </td>
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                        <table
                            class="min-w-full divide-y divide-gray-200"
                            v-else
                        >
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="
                                            px-3
                                            py-3
                                            text-center text-xs
                                            font-medium
                                            text-gray-900
                                            uppercase
                                            tracking-wider
                                            border-r
                                        "
                                        rowspan="2"
                                        width="20%"
                                    >
                                        HSN/SAC Code Description
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="
                                    bg-white
                                    divide-y divide-gray-200
                                "
                            >
                                <tr
                                    v-for="(item, index) in gstInvoiceContent"
                                    :key="index"
                                >
                                    <td
                                        class="
                                            px-3
                                            py-4
                                            text-xs text-gray-900
                                            border-r
                                        "
                                    >
                                        <div
                                            class="
                                                text-xs text-gray-900
                                            "
                                        >
                                        <span
                                            class="
                                                text-xs
                                            "
                                            v-if="item.type == 'product'"
                                        >
                                            HSN
                                            Code:
                                            {{ item.gst_rate.code }}</span>
                                            <span
                                            class="
                                                text-xs
                                            "
                                            v-if="item.type == 'service'"
                                        >
                                            SAC
                                            Code:
                                            {{ item.gst_rate.code }}</span>
                                             -
                                            {{
                                                item.gst_rate
                                                    .description
                                            }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
export default {
    props: {
        gstInvoiceContent: {
            type: Object,
            default: {},
        },
        client: {
            type: Object,
            default: {},
        }
    },
}
</script>
