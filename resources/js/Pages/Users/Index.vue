<script >
import AppLayout from "@/Layouts/AppLayout.vue";
import SubNavLink from "@/Components/Ui/SubNavLink.vue";
import SearchFilter from "@/Components/Ui/SearchFilter.vue";
import Pagination from '@/Components/Ui/Pagination.vue';

export default {
  components: {
    AppLayout,
    SubNavLink,
    SearchFilter,
    Pagination
  },
  props: ["users"],
};
</script>

<template>
  <AppLayout title="Users">
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">Users</span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0">
          <sub-nav-link :href="route('users.create')" icon="Plus">
            Add User
          </sub-nav-link>
        </div>
      </div>
    </template>

    <div>
      <div class="sm:px-6 lg:px-8 pb-20">
        <search-filter :filterLinks="filters" />
        <div>
          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div
                class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
              >
                <div
                  class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                >
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          #
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Name
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Billable Hours
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Non-billable Hours
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Status
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Cr/Dr
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Projects
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Actions
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr
                        v-for="(user, index) in users.data"
                        :key="`user-${user.id}`"
                      >
                        <td class="px-6 py-4 whitespace-nowrap">
                          {{ index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm font-medium text-gray-900">
                            {{ user.name }}
                          </div>
                          <div class="text-sm text-gray-500">
                            {{ user.name }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900">
                            {{ user.name }}
                          </div>
                          <div class="text-sm text-gray-500">
                            {{ user.name }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                          <div class="text-sm text-gray-900">
                            {{ user.name }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <!-- <a
                            href="#"
                            @click.prevent="confirmClientToggle(user)"
                          >
                            <span
                              class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                              :class="
                                user.activated_at
                                  ? 'bg-green-100 text-green-800'
                                  : 'bg-gray-100 text-gray-800'
                              "
                            >
                              {{ user.activated_at ? "Active" : "Inactive" }}
                            </span>
                          </a> -->
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                          <!-- <span
                            class="text-sm text-gray-900"
                            :class="{
                              'text-green-600': client.balance < 0,
                              'text-red-600': client.balance > 0,
                            }"
                          >
                            {{ client.currency.symbol
                            }}{{ balance(client.balance) }}
                          </span> -->
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <!-- <div class="flex items-center">
                            <inertia-link
                              :href="
                                route('project.index', {
                                  _query: {
                                    'filter[client_id]': client.id,
                                    'filter[status]': 'active',
                                  },
                                })
                              "
                            >
                              <span
                                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800"
                              >
                                {{ client.projects_count }}
                              </span>
                            </inertia-link>
                            <inertia-link
                              :href="
                                route('project.create', {
                                  _query: {
                                    client_id: client.id,
                                    back: route('client.index'),
                                  },
                                })
                              "
                            >
                              <plus-icon
                                class="h-5 w-5 text-primary hover:text-dark ml-1"
                              />
                            </inertia-link>
                          </div> -->
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <!-- <div class="flex justify-end">
                            <inertia-link
                              :href="route('users.edit', client.id)"
                            >
                              <pencil-alt-icon
                                class="h-5 w-5 text-primary hover:text-dark"
                              />
                            </inertia-link>
                            <TrashIcon
                              @click.prevent="confirmClientDelete(client)"
                              class="ml-1 h-5 w-5 text-red-500 cursor-pointer"
                            />
                          </div> -->
                        </td>
                      </tr>

                      <!-- More rows... -->
                    </tbody>
                  </table>
                  <pagination :links="users.links" :from="users.from" :to="users.to" :total="users.total" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"></div>
    </div>
  </AppLayout>
</template>
