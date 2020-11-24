<template>
  <div class="flex flex-row items-baseline text-sm">
    <svg
      class="inline-flex mr-1 h-4 w-4"
      width="24"
      height="24"
      viewBox="0 0 24 24"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M5 21V3L19 12L5 21Z"
        stroke="#000"
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round"
      ></path>
    </svg>
    <span class="font-medium text-gray-700">{{ line }}</span>
  </div>
</template>

<script>
export default {
  props: {
    line: String
  }
};
</script>

<style></style>
