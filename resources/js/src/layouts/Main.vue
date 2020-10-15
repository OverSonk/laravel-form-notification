<template>
  <div class="container">
    <form-notification />
  </div>
</template>
<script>
import FormNotification from "../catalogs/FormNotification/FormNotification";
export default {
  components: {
    FormNotification,
  },
  metaInfo() {
    return { title: "Inicio" };
  },
};
</script>