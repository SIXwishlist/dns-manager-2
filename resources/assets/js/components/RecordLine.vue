<template>
  <tr>
    <td>{{ record.type }}</td>
    <td>
      <input type="text" id="name" v-model="name" placeholder="Tên" class="form-control"/>
    </td>
    <td>
      <textarea id="content" v-model="content" v-if="record.type == 'TXT'" placeholder="Giá trị" class="form-control" rows="5"></textarea>
      <input type="text" id="content" v-model="content" v-else placeholder="Giá trị" class="form-control"/>
      <template v-if="record.type == 'MX'">
        Priority:
        <input type="text" id="content" v-model="priority" placeholder="Priority" class="form-control"/>
      </template>
    </td>
    <td>
      <select v-model="ttl" class="form-control">
        <option v-for="t in listTTL" :value="t.value">{{t.label}}</option>
      </select>
    </td>
    <td class="text-right">
      <div class="btn-group btn-hspace">
        <delete-record :domain="domain" :record="record.id"></delete-record>
      </div>
    </td>
  </tr>
</template>

<script>
  export default {
    data() {
      return {
        listTTL: [
          { value: 0, label: 'Tự động' },
          { value: 60*2, label: '2 phút' },
          { value: 60*5, label: '5 phút' },
          { value: 60*10, label: '10 phút' },
          { value: 60*15, label: '15 phút' },
          { value: 60*30, label: '30 phút' },
          { value: 60*60, label: '1 tiếng' },
          { value: 60*60*2, label: '2 tiếng' },
          { value: 60*60*5, label: '5 tiếng' },
          { value: 60*60*12, label: '12 tiếng' },
          { value: 60*60*24, label: '1 ngày' }
        ],
        type: 'A',
        name: this.record.name,
        content: this.record.content,
        ttl: this.record.ttl,
        priority: this.record.priority
      }
    },

    props: ['domain', 'record'],

    watch: {
      name: _.debounce(function (quantity) {
        this.saveRecord();
      }, 1000),
      content: _.debounce(function (quantity) {
        this.saveRecord();
      }, 1000),
      ttl: _.debounce(function (quantity) {
        this.saveRecord();
      }, 1000),
      priority: _.debounce(function (quantity) {
        this.saveRecord();
      }, 1000)
    },

    methods: {
      saveRecord() {
        let data = {
          name: this.name,
          content: this.content,
          ttl: this.ttl,
          priority: this.priority
        };

        this.$http.put('/ajax/domains/' + this.domain + '/dnsRecords/' + this.record.id, data)
          .then(response => {
            // alert('Thêm bản ghi thành công');

            // location.reload();
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
