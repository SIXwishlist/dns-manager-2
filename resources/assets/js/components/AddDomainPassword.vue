<template>
  <button type="button" class="btn btn-default btn-xs" data-toggle="modal" :data-target="'#add-password-modal-' + id">
    <template v-if="change">
      <span class="icon mdi mdi-key"></span> Đổi mật khẩu
    </template>
    <template v-else>
      <span class="icon mdi mdi-shield-check"></span> Bật đăng nhập
    </template>
  </button>
</template>

<script>
  export default {
    props: ['change', 'domain', 'id']
  }
</script>
