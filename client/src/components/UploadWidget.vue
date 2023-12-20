<script setup>
import { ref, onMounted, defineProps, defineEmits } from "vue";

const emit = defineEmits(["on-upload"]);

const cloudinary = ref(null);
const widget = ref(null);
const uploadedImageUrl = ref(null);

onMounted(() => {
  if (!cloudinary.value) {
    cloudinary.value = window.cloudinary;
  }

  // To help improve the load time of the widget on the first instance, use requestIdleCallback
  // to trigger widget creation. If requestIdleCallback isn't supported, fall back to
  // setTimeout: https://caniuse.com/requestidlecallback
  const onIdle = () => {
    if (!widget.value) {
      widget.value = createWidget();
    }
  };

  "requestIdleCallback" in window
    ? requestIdleCallback(onIdle)
    : setTimeout(onIdle, 10);
});

function createWidget() {
  if (!cloudinary.value) {
    console.error("Cloudinary is not defined");
    return null;
  }

  const options = {
    cloudName: "pitz",
    uploadPreset: "peter-main"
  };

  return cloudinary.value.createUploadWidget(options, (error, result) => {
    if (error || result.event === "success") {
      uploadedImageUrl.value = result.info.url;
      emit("on-upload", { error, result, widget: widget.value });
    }
  });
}

function onClick() {
  if (!widget.value) {
    widget.value = createWidget();
  }
  widget.value && widget.value.open();
}
</script>

<template>
  <div>
    <button @click="onClick">Upload</button>
    <img v-if="uploadedImageUrl" :src="uploadedImageUrl" alt="Uploaded Image">
  </div>
</template>
