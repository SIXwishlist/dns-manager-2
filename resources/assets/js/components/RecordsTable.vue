<template>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th style="width:10%;">Loại</th>
        <th style="width:17%;">Tên</th>
        <th style="width:15%;">Giá trị</th>
        <th style="width:10%;">TTL</th>
        <th style="width:10%;"></th>
      </tr>
    </thead>
    <tbody>
      <record-line v-for="record in records" :domain="domain" :record="record"></record-line>
    </tbody>
  </table>
</template>

<script>
  export default {
    props: ['domain', 'records']
  }
</script>
