<template>
  <div class="grid grid-cols-4">
    <div
      class="md:col-start-3 md:col-span-2 col-start-1 col-span-4 border-b border-gray-200 p-4"
    >
      <div class="flex flex-row items-center justify-end">
        <p
          class="noto text-gray-700 text-base md:text-lg w-64 text-right pr-4"
          v-text="message"
        ></p>
        <img :src="image" :alt="message" class="w-48 md:w-56" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    image: String,
    message: String
  }
};
</script>
