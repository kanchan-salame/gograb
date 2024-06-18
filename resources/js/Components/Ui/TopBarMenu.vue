<template>
  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog
        as="div"
        class="fixed inset-0 flex z-40 lg:hidden"
        @close="sidebarOpen = false"
      >
        <TransitionChild
          as="template"
          enter="transition-opacity ease-linear duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="transition-opacity ease-linear duration-300"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-100" />
        </TransitionChild>
        <TransitionChild
          as="template"
          enter="transition ease-in-out duration-300 transform"
          enter-from="-translate-x-full"
          enter-to="translate-x-0"
          leave="transition ease-in-out duration-300 transform"
          leave-from="translate-x-0"
          leave-to="-translate-x-full"
        >
          <div
            class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-dark"
          >
            <TransitionChild
              as="template"
              enter="ease-in-out duration-300"
              enter-from="opacity-0"
              enter-to="opacity-100"
              leave="ease-in-out duration-300"
              leave-from="opacity-100"
              leave-to="opacity-0"
            >
              <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button
                  type="button"
                  class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                  @click="sidebarOpen = false"
                >
                  <span class="sr-only">Close sidebar</span>
                  <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                </button>
              </div>
            </TransitionChild>
            <common-links></common-links>
          </div>
        </TransitionChild>
        <div class="flex-shrink-0 w-14" aria-hidden="true">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </Dialog>
    </TransitionRoot>

    <div
      class="relative z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200 lg:border-none dark:bg-slate-800 dark:text-white"
    >
      <!-- Hamburger -->
      <button
        type="button"
        class="px-4 border-r border-gray-200 text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500 lg:hidden"
        @click="sidebarOpen = true"
      >
        <span class="sr-only">Open sidebar</span>
        <MenuAlt1Icon class="h-6 w-6" aria-hidden="true" />
      </button>
      <!-- Search bar -->
      <div class="flex-1 px-4 flex justify-end sm:px-6 lg:px-8">
        <div class="ml-4 flex items-center md:ml-6">
          <!-- <div class="ml-3 relative" v-if="$page.props.auth.user.role != 'admin'"> -->
          <div class="ml-3 relative">
            <jet-dropdown align="right" width="48">
              <template #trigger>
                <button
                  v-if="$page.props.auth.user"
                  class="flex items-center text-sm border-2 border-transparent rounded-full transition"
                >
                  <BellIcon
                    class="hidden flex-shrink-0 ml-1 h-8 w-8 text-gray-400 lg:block"
                    aria-hidden="true"
                  />
                  <span
                    id="notify-count"
                    style="
                      color: #fff;
                      background-color: red;
                      border-radius: 20px;
                      width: 20px;
                      position: relative;
                      top: -15px;
                      left: -20px;
                    "
                    >{{
                      this.unreadNotifications.length > 0
                        ? this.unreadNotifications.length
                        : 0
                    }}</span
                  >
                </button>
              </template>

              <template #content>
                <!-- Account Management -->
                <div
                  class="block px-4 py-2 text-xs text-gray-900"
                  v-if="this.unreadNotifications.length > 0"
                >
                  Manage Notifications
                </div>
                <div class="block px-4 py-2 text-xs text-gray-900" v-else>
                  No New Notifications
                </div>
                <a
                  href=""
                  class="block px-4 py-2 text-xs text-gray-400"
                  @click="markAllAsRead"
                  v-show="this.unreadNotifications.length > 0"
                >
                  Mark all as read
                </a>
                <div
                  v-for="(notification, index) in this.unreadNotifications"
                  :key="index"
                >
                  <div
                    @click="readNotification(notification)"
                    class="block px-4 py-2 text-xs text-gray-400"
                  >
                    <h4>{{ notification.data.comment }}</h4>
                    <p class="block px-4 py-2 text-xs text-gray-700">
                      {{ updateCurrentTime(notification.created_at) }}
                    </p>
                    <hr />
                  </div>
                </div>
                <div class="border-t border-gray-100"></div>
              </template>
            </jet-dropdown>
          </div>
          <div class="ml-3 relative">
          <div class="ml-3 relative inline-block">
            <Link :href="route('register')" @click="goToRegister" class="inline-block"
                v-if="$page.props.canRegister"
            >
              Register
            </Link>
          </div>
          <div class="ml-3 relative inline-block">
            <Link :href="route('login')" class="inline-block" @click="goToLogin"
                v-if="$page.props.canLogin"
            > Login </Link>
          </div>
          <div class="ml-3 relative inline-block">
            <MoonIcon
              @click="changeDarkLightMode"
              class="hidden flex-shrink-0 ml-1 h-8 w-8 text-gray-400 inline-block"
              aria-hidden="true"
            />
          </div>
          <div
            class="px-3 relative inline-block text-left"
            v-if="$page.props.auth.user != null"
          >
            <!-- Teams Dropdown -->
            <jet-dropdown
              align="right"
              width="60"
              v-if="$page.props.jetstream.hasTeamFeatures"
              v-show="$page.props.auth.user.role == 'admin'"
            >
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition"
                  >
                    {{ $page.props.auth.user.current_team.name }}

                    <svg
                      class="ml-2 -mr-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <div class="w-60">
                  <!-- Team Management -->
                  <template v-if="$page.props.jetstream.hasTeamFeatures">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      Manage Team
                    </div>

                    <!-- Team Settings -->
                    <jet-dropdown-link
                      :href="
                        route('teams.show', $page.props.auth.user.current_team)
                      "
                    >
                      Team Settings
                    </jet-dropdown-link>

                    <jet-dropdown-link
                      :href="route('teams.create')"
                      v-if="$page.props.jetstream.canCreateTeams"
                    >
                      Create New Team
                    </jet-dropdown-link>

                    <div class="border-t border-gray-100"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      Switch Teams
                    </div>

                    <template
                      v-for="team in $page.props.auth.user.all_teams"
                      :key="team.id"
                    >
                      <form @submit.prevent="switchToTeam(team)">
                        <jet-dropdown-link as="button">
                          <div class="flex items-center">
                            <svg
                              v-if="
                                team.id == $page.props.auth.user.current_team_id
                              "
                              class="mr-2 h-5 w-5 text-green-400"
                              fill="none"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              stroke="currentColor"
                              viewBox="0 0 24 24"
                            >
                              <path
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                              ></path>
                            </svg>
                            <div>{{ team.name }}</div>
                          </div>
                        </jet-dropdown-link>
                      </form>
                    </template>
                  </template>
                </div>
              </template>
            </jet-dropdown>
          </div>
          <!-- Settings Dropdown -->
          <div class="ml-3 relative" v-if="$page.props.auth.user != null">
            <jet-dropdown align="right" width="48">
              <template #trigger>
                <button
                  v-if="$page.props.jetstream.managesProfilePhotos"
                  class="flex items-center text-sm border-2 border-transparent rounded-full transition"
                >
                  <img
                    class="h-8 w-8 rounded-full object-cover"
                    :src="$page.props.auth.user.profile_photo_url"
                    :alt="$page.props.auth.user.name"
                  />
                  <span
                    class="hidden ml-3 text-gray-700 text-sm font-medium lg:block dark:text-white"
                    ><span class="sr-only">Open user menu for </span
                    >{{ $page.props.auth.user.name }}</span
                  >
                  <ChevronDownIcon
                    class="hidden flex-shrink-0 ml-1 h-5 w-5 text-gray-400 lg:block"
                    aria-hidden="true"
                  />
                </button>

                <span v-else class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition"
                  >
                    <img
                      class="h-8 w-8 rounded-full"
                      src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                      alt=""
                    />
                    <span
                      class="hidden ml-3 text-gray-700 text-sm font-medium lg:block"
                      ><span class="sr-only">Open user menu for </span
                      >{{ $page.props.auth.user.name }}</span
                    >
                    <svg
                      class="ml-2 -mr-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Manage Account
                </div>

                <jet-dropdown-link :href="route('profile.show')">
                  Profile
                </jet-dropdown-link>

                <jet-dropdown-link
                  :href="route('api-tokens.index')"
                  v-if="$page.props.jetstream.hasApiFeatures"
                >
                  API Tokens
                </jet-dropdown-link>

                <div class="border-t border-gray-100"></div>

                <!-- Authentication -->
                <form @submit.prevent="logout">
                  <jet-dropdown-link as="button"> Log Out </jet-dropdown-link>
                </form>
              </template>
            </jet-dropdown>
            <!-- <a href="#" class="btn btn__primary">Test</a>
                        <a href="#" class="btn btn__bordered"><span class="gradient__text">Test</span></a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import CommonLinks from "@/Components/Ui/CommonLinks.vue";
import moment from "moment";

import {
  Dialog,
  DialogOverlay,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";

import {
  MenuAlt1Icon,
  XIcon,
  MoonIcon,
  BellIcon,
  LoginIcon,
} from "@heroicons/vue/outline";
import { ChevronDownIcon } from "@heroicons/vue/solid";
import axios from "axios";
import { toast } from "vue3-toastify";

export default {
  components: {
    JetDropdown,
    JetDropdownLink,
    CommonLinks,
    MenuAlt1Icon,
    ChevronDownIcon,
    Dialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
    XIcon,
    MoonIcon,
    BellIcon,
    LoginIcon,
  },

  setup() {
    const sidebarOpen = ref(false);

    return {
      sidebarOpen,
    };
  },
  mounted() {
    this.getUnreadNotifications();

    this.interval = setInterval(
      function () {
        this.getUnreadNotifications();
      }.bind(this),
      500
    );
  },

  data() {
    return {
      unreadNotifications: {},
      currentTime: null,
    };
  },

  methods: {
    readNotification(notification) {
      axios
        .post("showNotification/" + notification.id)
        .then((response) => {
          location.reload();
          console.log(response);
          toast.success("Notification mark as read!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        })
        .catch((errors) => {
          console.log(errors);
          toast.error("Something went wrong!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        });
    },

    markAllAsRead() {
      axios
        .get("markAllAsRead")
        .then((response) => {
          location.reload();
          toast.success("Notifications mark all as read!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        })
        .catch((errors) => {
          console.log(errors);
          toast.error("Something went wrong!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        });
    },
    updateCurrentTime(time) {
      return moment(time).fromNow();
    },
    created() {
      this.currentTime = moment().format("LTS");
      setInterval(() => this.updateCurrentTime(), 1000);
    },

    getUnreadNotifications() {
      if (this.$page.props.auth.user != null) {
        axios
          .get("unreadNotification")
          .then((response) => {
            this.unreadNotifications = response.data;
          })
          .catch((errors) => {
            console.log(errors);
            toast.error("Something went wrong!", {
              position: toast.POSITION.BOTTOM_RIGHT,
            });
          });
      }

    goToLogin() {
        this.$inertia.get(route("login"));
    },

    goToRegister() {
        this.$inertia.get(route("register"));
    },
    switchToTeam(team) {
      this.$inertia.put(
        route("current-team.update"),
        {
          team_id: team.id,
        },
        {
          preserveState: false,
        }
      );
    },

    logout() {
      this.$inertia.post(route("logout"));
    },

    changeDarkLightMode() {
      const html = document.getElementsByTagName("html")[0].classList;
      if (html == "dark") {
        html.remove("dark");
        html.add("light");
      } else {
        html.remove("light");
        html.add("dark");
      }
    },
  },

  computed: {
    isClientRoute() {
      return (
        route().current("client.index") ||
        route().current("client.create") ||
        route().current("client.show") ||
        route().current("client.edit") ||
        route().current("project.index") ||
        route().current("project.create") ||
        route().current("project.show") ||
        route().current("project.edit")
      );
    },

    isTimelogRoute() {
      return (
        route().current("timelog.index") ||
        route().current("timelog.create") ||
        route().current("timelog.show") ||
        route().current("timelog.edit")
      );
    },

    canManageClients() {
      return this.hasTeamPermission("clients:manage");
    },
  },
};
</script>
