<template>
  <a @click="deleteDomain()"><span class="mdi mdi-delete"></span> Xoá</a>
</template>

<script>
  export default {
    props: ['domain'],

    methods: {
      deleteDomain() {
        let c = confirm('Bạn chắc chắn muốn xoá tên miền này?');

        if (!c) return;

        this.$http.delete('/ajax/domains/' + this.domain)
          .then(response => {
            alert('Đã xoá tên miền ' + this.domain);

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
