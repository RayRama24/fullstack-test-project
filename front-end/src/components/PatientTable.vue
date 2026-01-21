<template>
  <table class="custom-table">
    <thead>
      <tr>
        <th>NO</th>
        <th>NO REKAM MEDIK</th>
        <th>NAMA PASIEN</th>
        <th>NIK</th>
        <th>ALAMAT</th>
        <th>JML KUNJUNGAN</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(patient, index) in patients" :key="patient.id">
        <td>{{ index + 1 }}</td>
        <td>{{ patient.no_rm }}</td>
        <td>{{ patient.nama }}</td>
        <td>{{ patient.nik }}</td>
        <td>{{ patient.address }}</td>
        <td>{{ patient.jumlah_kunjungan || 0 }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
const props = defineProps({
  patients: {
    type: Array,
    required: true,
    default: () => []
  }
})
</script>

<style scoped>
.custom-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  font-size: 13px;
}

.custom-table th {
  background-color: #d3d3d3;
  padding: 12px 8px;
  border: 1px solid #999;
  text-align: center;
  font-weight: bold;
}

.custom-table td {
  padding: 10px 8px;
  border: 1px solid #999;
  text-align: center;
}
</style>