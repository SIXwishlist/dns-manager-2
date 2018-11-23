<template>
  <div class="row">
    <div class="col-xs-12">
      <div class="form-group">
        <label for="type">Loại</label>
        <select v-model="type" id="type" class="form-control">
          <option v-for="t in types">{{t}}</option>
        </select>
      </div>
      <div class="form-group">
        <label for="name">Tên</label>
        <input type="text" id="name" v-model="name" placeholder="Tên" class="form-control"/>
      </div>
      <div class="form-group">
        <label for="content">Giá trị</label>
        <textarea id="content" v-model="content" v-if="type == 'TXT'" placeholder="Giá trị" class="form-control" rows="5"></textarea>
        <input type="text" id="content" v-model="content" v-else placeholder="Giá trị" class="form-control"/>
      </div>
      <div class="form-group" v-if="type == 'MX'">
        <label for="priority">Độ ưu tiên</label>
        <input type="text" id="priority" v-model="priority" placeholder="Độ ưu tiên" class="form-control"/>
      </div>
      <div class="form-group">
        <label for="ttl">TTL</label>
        <select v-model="ttl" id="ttl" class="form-control">
          <option v-for="t in listTTL" :value="t.value">{{t.label}}</option>
        </select>
      </div>
      <div class="form-group">
        <button type="button" class="btn btn-primary btn-xl" @click="addRecord()">Thêm</button>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        // types: ['A', 'AAAA', 'CNAME', 'MX', 'LOC', 'SRV', 'SPF', 'TXT', 'NS'],
        types: ['A', 'AAAA', 'CNAME', 'MX', 'LOC', 'SPF', 'TXT', 'NS'],
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
        name: null,
        content: null,
        ttl: 0,
        priority: 1
      }
    },

    props: ['domain'],

    mounted() {
    },

    methods: {
      addRecord() {
        let data = {
          type: this.type,
          name: this.name,
          content: this.content,
          ttl: this.ttl,
          priority: this.priority
        };

        this.$http.post('/ajax/domains/' + this.domain + '/dnsRecords', data)
          .then(response => {
            //alert('Thêm bản ghi thành công');

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
