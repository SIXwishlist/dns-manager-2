<template>
  <a @click="deleteUser()"><span class="mdi mdi-delete"></span> Xoá</a>
</template>

<script>
  export default {
    props: ['user'],

    methods: {
      deleteUser() {
        let c = confirm('Bạn chắc chắn muốn xoá người dùng #' + this.user + '?');

        if (!c) return;

        this.$http.delete('/users/' + this.user)
          .then(response => {
            alert('Đã xoá người dùng #' + this.user);

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
