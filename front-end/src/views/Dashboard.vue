<script setup>
import { ref, onMounted } from 'vue' 
import api from '../api/api'
import PatientTable from '../components/PatientTable.vue'
import AddPatientModal from '../components/AddPatientModal.vue' // Tambahkan import ini
import AddVisitModal from '../components/AddVisitModal.vue'     // Tambahkan import ini

const patients = ref([])
const showPatientModal = ref(false)
const showVisitModal = ref(false)

const fetchPatients = async () => {
  try {
    const res = await api.get('/patients')
    patients.value = res.data.data || res.data // Sesuaikan dengan struktur API Anda
  } catch (err) {
    console.error("Gagal mengambil data:", err)
  }
}

onMounted(fetchPatients)
</script>

<template>
  <div class="dashboard-container">
    <div class="dashboard-card">
      <div class="logo-wrapper">
        <h1 class="logo-text">Medi<span class="green-text">sin</span></h1>
      </div>

      <div class="action-buttons">
        <button class="btn btn-blue" @click="showPatientModal = true">TAMBAH PASIEN</button>
        <button class="btn btn-green" @click="showVisitModal = true">BUAT KUNJUNGAN</button>
      </div>

      <div class="table-wrapper">
        <PatientTable :patients="patients" />
      </div>

      <AddPatientModal
        v-if="showPatientModal"
        @close="showPatientModal = false"
        @saved="fetchPatients"
      />
      
      <AddVisitModal
        v-if="showVisitModal"
        @close="showVisitModal = false"
        @saved="fetchPatients"
      />
    </div>
  </div>
</template>

<style scoped>
.dashboard-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  min-height: 100vh;
  background-color: #0061d5;
  padding: 40px 20px;
  box-sizing: border-box;
}
.dashboard-card {
  background-color: white;
  width: 100%;
  max-width: 1000px;
  min-height: 80vh;
  padding: 40px;
  border-radius: 40px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}
.logo-wrapper { text-align: center; margin-bottom: 40px; }
.logo-text { font-size: 42px; font-weight: 800; color: #1a3a5a; margin: 0; }
.green-text { color: #2ecc71; }
.action-buttons { display: flex; gap: 10px; margin-bottom: 20px; }
.btn { border: none; padding: 12px 25px; border-radius: 15px; color: white; font-weight: bold; cursor: pointer; font-size: 14px; }
.btn-blue { background-color: #0061d5; }
.btn-green { background-color: #44d600; }
.table-wrapper { width: 100%; overflow-x: auto; }
</style>