<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  laravelVersion: {
    type: String,
    required: true,
  },
  phpVersion: {
    type: String,
    required: true,
  },
  restaurantMenuItems: {
    type: Object,
    required: true,
  },
});

function handleImageError() {
  document.getElementById("screenshot-container")?.classList.add("!hidden");
  document.getElementById("docs-card")?.classList.add("!row-span-1");
  document.getElementById("docs-card-content")?.classList.add("!flex-row");
  document.getElementById("background")?.classList.add("!hidden");
}

function addToCart(restaurantMenuItem) {
    const form = useForm({
      restaurant_menu_item_id: restaurantMenuItem.id,
      restaurant_menu_id: restaurantMenuItem.restaurant_menu_id,
      restaurant_id: restaurantMenuItem.restaurant_menu.restaurant_id,
      formtype: "restaurantMenuItem",
    });

    const options = {
        errorBag: "addToCart",
        preserveScroll: (page) => Object.keys(page.props.errors).length,
        onError: () => {
          toast.error("Something went wrong!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        },
      };

    // New Item
    form.post(route("cart.store"), options);
}
</script>

<template>
  <Head title="Welcome" />
  <AppLayout title="Dashboard">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
      <img
        id="background"
        class="absolute -left-20 top-0 max-w-[877px]"
        src="https://laravel.com/assets/img/welcome/background.svg"
      />
      <div
        class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
      >
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
          <header
            class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3"
          >
            <div class="flex lg:justify-center lg:col-start-2">
              <img src="images/logo1.png" alt="Logo" srcset="">
            </div>
          </header>

          <main class="mt-6">
            <div class="grid gap-6 lg:grid-cols-2 lg:gap-8"></div>

            <!-- ✅ Grid Section - Starts Here 👇 -->
            <section
              id="Projects"
              class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5"
              v-if="restaurantMenuItems.length"
            >
              <!--   ✅ Product cards - Starts Here 👇 -->
              <div
                class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl"
                v-for="(restaurantMenuItem, index) in restaurantMenuItems" :key="`restaurantMenuItem-${index}`"
              >
                <!-- <a :href="route('restaurantMenuItem.show', restaurantMenuItem)"> -->
                    <a href="#">
                  <img
                    :src="restaurantMenuItem.imagepath"
                    :alt="restaurantMenuItem.name"
                    class="h-80 w-72 object-cover rounded-t-xl"
                  />

                </a>
                  <div class="px-4 py-3 w-72">
                    <a href="#">
                    <span class="text-gray-400 mr-3 uppercase text-xs"
                      >Brand</span
                    >
                    <p
                      class="text-lg font-bold text-black truncate block capitalize"
                    >
                      {{restaurantMenuItem.name}}
                    </p>
                    </a>
                    <div class="flex items-center">
                      <p
                        class="text-lg font-semibold text-black cursor-auto my-3"
                      >
                        {{restaurantMenuItem.price}}
                      </p>
                      <del>
                        <p class="text-sm text-gray-600 cursor-auto ml-2">
                          $199
                        </p>
                      </del>
                      <div class="ml-auto">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="20"
                          height="20"
                          fill="currentColor"
                          class="bi bi-bag-plus"
                          viewBox="0 0 16 16"
                          @click="addToCart(restaurantMenuItem)"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z"
                          />
                          <path
                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"
                          />
                        </svg>
                      </div>
                    </div>
                  </div>
              </div>
              <!--   🛑 Product cards - Ends Here  -->

            </section>
          </main>

          <footer
            class="py-16 text-center text-sm text-black dark:text-white/70"
          >
            Dilus24 &copy;2024
          </footer>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
