<script>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import CircularChart from "@/Components/CircularChart.vue";

import {
  Chart3DComponent,
  Chart3DSeriesCollectionDirective,
  Chart3DSeriesDirective,
  ColumnSeries3D,
  Category3D,
  DataLabel3D,
  Tooltip3D,
} from "@syncfusion/ej2-vue-charts";

import { CircularChart3DComponent, CircularChart3DSeriesCollectionDirective, CircularChart3DSeriesDirective, PieSeries3D, CircularChartDataLabel3D, CircularChartLegend3D } from "@syncfusion/ej2-vue-charts";

export default {
  name: "App",
  components: {
    "ejs-chart3d": Chart3DComponent,
    "e-chart3d-series-collection": Chart3DSeriesCollectionDirective,
    "e-chart3d-series": Chart3DSeriesDirective,
    ApplicationLogo,
    CircularChart,
  },
  data() {
    return {
      seriesData: [
        { month: "Jan", sales: 35 },
        { month: "Feb", sales: 28 },
        { month: "Mar", sales: 34 },
        { month: "Apr", sales: 32 },
        { month: "May", sales: 40 },
        { month: "Jun", sales: 32 },
        { month: "Jul", sales: 35 },
        { month: "Aug", sales: 55 },
        { month: "Sep", sales: 38 },
        { month: "Oct", sales: 30 },
        { month: "Nov", sales: 25 },
        { month: "Dec", sales: 32 },
      ],
      primaryXAxis: {
        valueType: "Category",
      },
      primaryYAxis: {
        labelFormat: "${value}K",
      },
      dataLabel: {
        visible: true,
      },
      tooltip: {
        enable: true,
      },
      title: "Sales Analysis",
    };
  },
  provide: {
    chart3d: [ColumnSeries3D, Category3D, DataLabel3D, Tooltip3D],
  },
};
</script>

<style>
#container {
  height: 350px;
}
</style>

<template>
  <div class="mb-5 p-8">
    <h1>Welcome, {{ $page.props.auth.user.name }}</h1>
    <h1>
      {{ new Date() }}
    </h1>
  </div>

  <!-- <div class="mb-5 p-8">
    <ejs-chart3d
      id="container"
      :title="title"
      :primaryXAxis="primaryXAxis"
      :primaryYAxis="primaryYAxis"
      :tooltip="tooltip"
    >
      <e-chart3d-series-collection>
        <e-chart3d-series
          :dataSource="seriesData"
          type="Column"
          xName="month"
          yName="sales"
          name="Sales"
          :dataLabel="dataLabel"
        >
        </e-chart3d-series>
      </e-chart3d-series-collection>
    </ejs-chart3d>
  </div> -->
  <!-- <CircularChart /> -->

  <!-- <div class="mb-5 p-8">

  </div> -->
  <div class="flex items-center justify-center">
    <div
      class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4"
    >
      <!-- 1 card -->
      <div class="relative bg-white py-6 px-6 rounded-3xl w-64 my-4 shadow-xl">
        <div
          class="text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-pink-500 left-4 -top-6"
        >
          <!-- svg  -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-8 w-8"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"
            />
          </svg>
        </div>
        <div class="mt-8">
          <p class="text-xl font-semibold my-2">Users</p>
          <div class="flex space-x-2 text-gray-400 text-sm">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <p>Marketing Team</p>
          </div>
          <div class="flex space-x-2 text-gray-400 text-sm my-3">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            <p>1 Weeks Left</p>
          </div>
          <div class="border-t-2"></div>

          <div class="flex justify-between">
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Total Users</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Progress</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>34%</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 2 card -->
      <div class="relative bg-white py-6 px-6 rounded-3xl w-64 my-4 shadow-xl">
        <div
          class="text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-green-500 left-4 -top-6"
        >
          <!-- svg  -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-8 w-8"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
            />
          </svg>
        </div>
        <div class="mt-8">
          <p class="text-xl font-semibold my-2">Drivers</p>
          <div class="flex space-x-2 text-gray-400 text-sm">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <p>Core UI Team</p>
          </div>
          <div class="flex space-x-2 text-gray-400 text-sm my-3">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            <p>3 Weeks Left</p>
          </div>
          <div class="border-t-2"></div>

          <div class="flex justify-between">
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Totals Drivers</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Progress</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>76%</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 3 card -->
      <div class="relative bg-white py-6 px-6 rounded-3xl w-64 my-4 shadow-xl">
        <div
          class="text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-blue-500 left-4 -top-6"
        >
          <!-- svg  -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-8 w-8"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
            />
          </svg>
        </div>
        <div class="mt-8">
          <p class="text-xl font-semibold my-2">Restaurants</p>
          <div class="flex space-x-2 text-gray-400 text-sm">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <p>Marketing Team</p>
          </div>
          <div class="flex space-x-2 text-gray-400 text-sm my-3">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            <p>2 Days Left</p>
          </div>
          <div class="border-t-2"></div>

          <div class="flex justify-between">
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Total Restaurants</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Progress</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>4%</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 4 card -->
      <div class="relative bg-white py-6 px-6 rounded-3xl w-64 my-4 shadow-xl">
        <div
          class="text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-yellow-500 left-4 -top-6"
        >
          <!-- svg  -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-8 w-8"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"
            />
          </svg>
        </div>
        <div class="mt-8">
          <p class="text-xl font-semibold my-2">Sales</p>
          <div class="flex space-x-2 text-gray-400 text-sm">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <p>Marketing Team</p>
          </div>
          <div class="flex space-x-2 text-gray-400 text-sm my-3">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            <p>1 Month Left</p>
          </div>
          <div class="border-t-2"></div>

          <div class="flex justify-between">
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Total Sales</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Progress</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 5 card -->
      <div class="relative bg-white py-6 px-6 rounded-3xl w-64 my-4 shadow-xl">
        <div
          class="text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-yellow-500 left-4 -top-6"
        >
          <!-- svg  -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-8 w-8"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"
            />
          </svg>
        </div>
        <div class="mt-8">
          <p class="text-xl font-semibold my-2">Parcels</p>
          <div class="flex space-x-2 text-gray-400 text-sm">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <p>Marketing Team</p>
          </div>
          <div class="flex space-x-2 text-gray-400 text-sm my-3">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            <p>1 Month Left</p>
          </div>
          <div class="border-t-2"></div>

          <div class="flex justify-between">
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Total Parcels</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Progress</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 6 card -->
      <div class="relative bg-white py-6 px-6 rounded-3xl w-64 my-4 shadow-xl">
        <div
          class="text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-yellow-500 left-4 -top-6"
        >
          <!-- svg  -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-8 w-8"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"
            />
          </svg>
        </div>
        <div class="mt-8">
          <p class="text-xl font-semibold my-2">Food</p>
          <div class="flex space-x-2 text-gray-400 text-sm">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <p>Marketing Team</p>
          </div>
          <div class="flex space-x-2 text-gray-400 text-sm my-3">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            <p>1 Month Left</p>
          </div>
          <div class="border-t-2"></div>

          <div class="flex justify-between">
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Total Food Orders</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Progress</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 7 card -->
      <div class="relative bg-white py-6 px-6 rounded-3xl w-64 my-4 shadow-xl">
        <div
          class="text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-yellow-500 left-4 -top-6"
        >
          <!-- svg  -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-8 w-8"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"
            />
          </svg>
        </div>
        <div class="mt-8">
          <p class="text-xl font-semibold my-2">Rides</p>
          <div class="flex space-x-2 text-gray-400 text-sm">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <p>Marketing Team</p>
          </div>
          <div class="flex space-x-2 text-gray-400 text-sm my-3">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            <p>1 Month Left</p>
          </div>
          <div class="border-t-2"></div>

          <div class="flex justify-between">
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Total Rides</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Progress</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 8 card -->
      <div class="relative bg-white py-6 px-6 rounded-3xl w-64 my-4 shadow-xl">
        <div
          class="text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-yellow-500 left-4 -top-6"
        >
          <!-- svg  -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-8 w-8"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"
            />
          </svg>
        </div>
        <div class="mt-8">
          <p class="text-xl font-semibold my-2">Trips</p>
          <div class="flex space-x-2 text-gray-400 text-sm">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <p>Marketing Team</p>
          </div>
          <div class="flex space-x-2 text-gray-400 text-sm my-3">
            <!-- svg  -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            <p>1 Month Left</p>
          </div>
          <div class="border-t-2"></div>

          <div class="flex justify-between">
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Team Member</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
            <div class="my-2">
              <p class="font-semibold text-base mb-2">Progress</p>
              <div class="text-base text-gray-400 font-semibold">
                <p>90%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
