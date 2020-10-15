<!--
    File Name: Error404.vue
    Description: 404 Page
 -->


<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="error-404">
          <h1>Oops!</h1>
          <h2>Error 404</h2>
          <div class="error-details">Ha ocurrido un error</div>
          <a class="btn btn-primary" href="/"> Ir al inicio</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  metaInfo() {
    return { title: "Error 404" };
  },
};
</script>