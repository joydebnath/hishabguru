<template>
  <div class="grid grid-cols-4">
    <div
      class="col-start-1 col-span-4 md:col-span-2 border-b border-gray-200 p-4"
    >
      <div class="flex flex-row items-center">
        <img :src="image" :alt="message" class="w-48 md:w-56" />
        <p
          class="noto text-gray-700 text-base md:text-lg pl-4 w-64"
          v-text="message"
        ></p>
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
