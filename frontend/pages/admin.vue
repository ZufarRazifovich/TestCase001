<template>
  <b-container>
    <div class="m-5 mainBloc p-5">
      <b-row class="headTbl mb-3 pb-2" ><b-col>Url</b-col><b-col>Частота проверки</b-col><b-col>Количество повторов</b-col></b-row>
      <div v-for="url in urls" class="p-0" v-on:click="getCheckLists(url.id)">
        <b-row  class="itemUrl mb-3 pt-1 pb-1" v-b-modal.modal-1 >
          <b-col>{{url.url}}</b-col><b-col>{{url.check_periodicity}}</b-col><b-col>{{url.repeat_periodicity}}</b-col>
        </b-row>
      </div>
      <b-modal id="modal-1" title="Список проверок">
        <b-overlay :show="show" rounded="xl">
          <div v-if="checklist.length == 0"><p>Проверки не найдены</p></div>
          <div v-else>
          <div v-for="check in checklist">
            <b-row>
              <b-col>Status - {{ check.http_code }}, date - {{ check.created_at }}</b-col>
            </b-row>
          </div>
          </div>
        </b-overlay>
      </b-modal>
    </div>
  </b-container>
</template>

  <script>
  import axios from "axios";

  export default {
    data() {
        return {
          urls: [],
          checklist: [],
          show: false
        }
    },
    components: {
      axios
    },
    methods:{
      getUrls(){
        axios.post('http://127.0.0.1:8080/api/urls',{page: 1}).then(response=>{this.urls = response.data.data }).catch(error => {alert(error)})
      },
      getCheckLists(id){
        this.show = true
        axios.post('http://127.0.0.1:8080/api/geturlchecks',{id: id}).then(response=>{this.checklist = response.data.data; this.show = false; }).catch(error => {alert(error)})
      },

    },

    created(){
      this.getUrls()
    }
  }
  </script>
<style>
.mainBloc{
  height: 100vh;
  background-color: gainsboro;
}
.headTbl{
  border-bottom: 0.5px solid gray;
}
.itemUrl:hover{
  background-color: wheat;
  cursor: pointer;
}
</style>