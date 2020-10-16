<template >
  <div class="row h-screen align-items-center justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">
            Formualrio para crear notificaciones
          </h5>

          <form
            @submit.prevent="saveNotification"
            @keydown="form.onKeydown($event)"
          >
            <div class="form-group">
              <label for="name">Nombre</label>
              <input
                type="name"
                class="form-control"
                id="name"
                placeholder="Ingrese su nombre"
                v-model="form.name"
              />
              <has-error :form="form" field="name" />
            </div>
            <div class="form-group">
              <label for="phone">Teléfono</label>
              <input
                type="phone"
                class="form-control"
                id="phone"
                placeholder="Ingrese su teléfono"
                v-model="form.phone"
              />
              <has-error :form="form" field="phone" />
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                class="form-control"
                id="email"
                placeholder="Ingresa su email"
                v-model="form.email"
              />
              <has-error :form="form" field="email" />
            </div>
            <div class="form-group">
              <label for="subject">Asunto</label>
              <input
                type="subject"
                class="form-control"
                id="subject"
                placeholder="Ingresa su asunto"
                v-model="form.subject"
              />
              <has-error :form="form" field="subject" />
            </div>

            <div class="form-group position-relative">
              <input
                type="file"
                class="form-control position-absolute"
                name="file"
                id="file"
                ref="inputFile"
                placeholder="Archivo"
                v-on:change="loadFile"
              />
              <label for="file" class="custom-input-file">{{ fileName }}</label>
              <has-error :form="form" field="file" />
            </div>

            <div class="row">
              <div class="col-12 col-md-6 mb-3 mb-sm-0">
                <button
                  type="button"
                  class="btn btn-danger btn-block"
                  @click="formClear()"
                >
                  Limpiar información
                </button>
              </div>
              <div class="col-12 col-md-6">
                <button type="submit" class="btn btn-primary btn-block">
                  Enviar
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- <vue-element-loading :active="loading" is-full-screen /> -->
  </div>
</template>

<script>
import Form from "vform";
import Swal from "sweetalert2";
import axios from "axios";
import VueElementLoading from "vue-element-loading";

export default {
  name: "createNotification",
  data: () => ({
    form: new Form({
      name: "",
      phone: "",
      email: "",
      subject: "",
      file: "",
    }),
    loading: false,
  }),
  components: {
    VueElementLoading,
  },
  computed: {
    fileName: {
      get() {
        if (!!this.form.file) {
          return this.$refs.inputFile.files[0].name;
        } else {
          return "Subir archivo";
        }
      },
      set(value) {
        return value;
      },
    },
  },

  methods: {
    async saveNotification() {
      try {
        this.loading = true;
        let params = new FormData();
        params.append("name", this.form.name);
        params.append("email", this.form.email);
        params.append("phone", this.form.phone);
        params.append("subject", this.form.subject);
        params.append("file", this.form.file);
        const { data } = await axios.post(`/api/notifications`, params, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        this.loading = false;
        this.formClear();
        Swal.fire({
          icon: "success",
          title: "Éxito",
          text: "El formulario se ha enviado con éxito.",
          confirmButtonText: "Ok",
        });
      } catch (exception) {
        this.loading = false;
        this.form.errors.set(this.form.extractErrors(exception.response));
        console.log("Ocurrió un error:", exception);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Ocurrio un error al enviar el formulario.",
          confirmButtonText: "Ok",
        });
      }
    },
    formClear() {
      this.form.clear();
      this.form = _.assign(this.form, {
        name: null,
        phone: null,
        email: null,
        subject: null,
        file: null,
      });
    },
    loadFile() {
      if (this.$refs.inputFile.files.length > 0) {
        this.form.file = this.$refs.inputFile.files[0];
      } else {
        this.form.file = null;
      }
    },
  },
};
</script>
<style lang="scss">
#file {
  opacity: 0;
  width: 100%;
  height: 50px;
  cursor: pointer !important;
  padding: 0;
}
.custom-input-file {
  display: block;
  position: relative;
  width: 100%;
  height: 50px;
  border: 1px dashed #000;
  padding: 10px;
  text-align: center;
  cursor: pointer !important;
  &:hover {
    color: #007bff;
    border: 2px dashed #007bff;
  }
}
</style>