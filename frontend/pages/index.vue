<template>
  <b-container class="p-5">
    <b-card bg-variant="light">
      <validation-observer ref="observer" v-slot="{ handleSubmit }">
        <b-form @submit.prevent="onSubmit">
        <b-form-group
        label-cols-lg="3"
        label="Форма добавления URL"
        label-size="lg"
        label-class="font-weight-bold pt-0"
        class="mb-0"
      >
      <validation-provider name="URL для проверки:" :rules="{ required: true }" v-slot="validationContext">

        <b-form-group
          label="URL для проверки:"
          label-for="nested-street"
          label-cols-sm="4"
          label-align-sm="right"
        >
          <b-form-input
           id="nested-street"
           v-model="url"
           :readonly="isSubmitBtnActive"
           :state="getValidationState(validationContext)"
           ></b-form-input>
          <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
        </b-form-group>
      </validation-provider>

        <b-form-group
          label="Частота проверки:"
          label-for="nested-city"
          label-cols-sm="4"
          label-align-sm="right"
        >
          <b-form-spinbutton id="demo-sb" :readonly="isSubmitBtnActive" v-model="checkPeriodicity" min="1" max="10"></b-form-spinbutton>

        </b-form-group>

        <b-form-group
          label="Количество повторов в случае ошибки:"
          label-for="nested-country"
          label-cols-sm="4"
          label-align-sm="right"
        >
          <b-form-spinbutton id="demo-sb" :readonly="isSubmitBtnActive" v-model="repeatPeriodicity" min="1" max="10"></b-form-spinbutton>
        </b-form-group>
        <b-form-group>
          <b-button type="submit" variant="primary" :disabled="isSubmitBtnActive">Submit</b-button>
        </b-form-group>
      </b-form-group>

      </b-form>
      </validation-observer>


    </b-card>
  </div>
  </b-container>
  </template>

  <script>
  import { ValidationObserver, ValidationProvider } from "vee-validate";
  import axios from "axios";

  export default {
    data() {
        return {
          checkPeriodicity: 5,
          repeatPeriodicity: 1,
          url: '',
          isSubmitBtnActive: false
        }
    },
    components: {
      ValidationObserver: ValidationObserver,
      ValidationProvider: ValidationProvider,
      axios
    },
    methods:{
      getValidationState({ dirty, validated, valid = null }) {
        return dirty || validated ? valid : null;
      },
      resetForm() {
        this.form = {
          name: null,
          food: null
        };

        this.$nextTick(() => {
          this.$refs.observer.reset();
        });
      },
      onSubmit() {
        this.isSubmitBtnActive = true
        axios.post('http://127.0.0.1:8080/api/createUrl',{
        url: this.url,
        check_periodicity: this.checkPeriodicity,
        repeat_periodicity: this.repeatPeriodicity,
      }).then(response=>{
        alert('URL успешно добавлен')
        this.isSubmitBtnActive = false
      }).catch(error => {
        alert(error)
        this.isSubmitBtnActive = false
      })
      }
    }
  }
  </script>
<style>
.ifLoading{
  height: 100vh;
  width: 100vw;
  background-color: red;
  position: absolute;
}
</style>