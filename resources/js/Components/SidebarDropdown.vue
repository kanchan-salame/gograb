<script>
export default {
  props: ["title", "height", "active"],
  data() {
    return {
      showMenu: false,
    };
  },

  methods: {
    toggleShow() {
      this.showMenu = !this.showMenu;
    },
  },

  computed: {
    class() {
      return this.showMenu ? this.height : "h-0";
    },
    classes() {
      return this.active
        ? "bg-gray-300 text-gray-900 group flex items-center px-2 py-2 text-base leading-6 font-semibold rounded-md"
        : "text-gray-100 hover:text-gray-900 hover:bg-gray-200 group flex items-center px-2 py-2 text-base leading-6 font-semibold rounded-md";
    },
  },
};
</script>
<style>
.sidebar-dropdown {
  transition: 300ms;
}
svg.rotate-90 {
  transform: rotate(90deg);
}
</style>
<template>
  <div class="font-semibold text-sm list-none block">

    <div
      class="flex items-center justify-between mb-2 cursor-pointer"
      @click="toggleShow"
    >
      {{ title }}
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="20"
        height="20"
        :class="{ 'rotate-90': showMenu }"
        class="dropdown-menu"
        viewBox="0 0 24 24"
      >
        <path fill="none" d="M0 0h24v24H0V0z" />
        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z" />
      </svg>
    </div>
    <ul
      class="ml-4 overflow-hidden dropdown-menu font-normal"
      :class="this.class"
    >
      <slot></slot>
    </ul>
  </div>
</template>
