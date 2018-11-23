<template>
  <a @click="deleteRecord()" class="btn btn-default btn-danger">
    <span class="mdi mdi-close"></span>
    <span class="sr-only">Xoá</span>
  </a>
</template>

<script>
  export default {
    props: ['domain', 'record'],

    methods: {
      deleteRecord() {
        let c = confirm('Bạn chắc chắn muốn xoá bản ghi này?');

        if (!c) return;

        this.$http.delete('/ajax/domains/' + this.domain + '/dnsRecords/' + this.record)
          .then(response => {
            alert('Đã xoá 1 bản ghi DNS');

            location.reload();
          })
          .catch(response => {
            let msg = "Lỗi:";

            for (let i in response.body) {
              msg += "\n" + response.body[i][0];
            }

            alert(msg);
          });
      }
    }
  }
</script>
