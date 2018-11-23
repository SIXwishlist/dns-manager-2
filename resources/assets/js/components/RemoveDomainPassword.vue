<template>
  <a @click="remove()"><span class="icon mdi mdi-lock"></span> Tắt đăng nhập</a>
</template>

<script>
  export default {
    props: ['domain'],

    methods: {
      remove() {
        let c = confirm('Bạn chắc chắn muốn tắt đăng nhập của tên miền này?');

        if (!c) return;

        this.$http.delete('/ajax/domains/' + this.domain + '/password')
          .then(response => {
            alert('Đã tắt đăng nhập của tên miền ' + this.domain);

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
