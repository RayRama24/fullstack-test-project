<template>
  <div class="modal-overlay">
    <div class="modal-content">
      <button class="close-x" @click="$emit('close')">X</button>

      <h2 class="modal-title">BUAT KUNJUNGAN</h2>

      <div class="form-container">
        <!-- Cari Pasien -->
        <div class="section-label">Cari Pasien</div>
        <input
          v-model="rm"
          type="text"
          placeholder="No Rekam Medik"
          class="input-search"
        />

        <p v-if="error" style="color:red">{{ error }}</p>

        <hr class="divider" />

        <div class="section-label">Data Pasien</div>

        <div class="input-row">
          <input
            :value="patient?.name || ''"
            placeholder="Nama Pasien"
            class="input-half readonly"
            readonly
          />
          <input
            :value="patient?.nik || ''"
            placeholder="NIK"
            class="input-half readonly"
            readonly
          />
        </div>

        <textarea
          :value="patient?.address || ''"
          placeholder="Alamat"
          class="input-full textarea-field readonly"
          readonly
        ></textarea>

        <button
          class="submit-button"
          :disabled="!patient"
          @click="createVisit"
        >
          BUAT KUNJUNGAN
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import api from '../api/api'

const emit = defineEmits(['saved', 'close'])

const rm = ref('')
const patient = ref(null)
const error = ref('')

watch(rm, async (val) => {
  patient.value = null
  error.value = ''

  if (!val) return

  try {
    const res = await api.get(`/patients/${val}`)
    patient.value = res.data.data
  } catch (err) {
    error.value = 'Pasien tidak ditemukan'
  }
})


const createVisit = async () => {
  if (!patient.value) return

  try {
    await api.post('/visits', {
      medical_record_no: rm.value
    })

    emit('saved')   // refresh data table
    emit('close')   // tutup modal
  } catch (err) {
    error.value = 'Gagal membuat kunjungan'
  }
}
</script>

<style scoped>

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 30px;
  border-radius: 30px;
  width: 550px;
  position: relative;
}

.close-x {
  position: absolute;
  top: 20px;
  right: 25px;
  background: none;
  border: none;
  font-size: 22px;
  cursor: pointer;
}

.modal-title {
  text-align: center;
  font-weight: bold;
  margin-bottom: 20px;
}

.section-label {
  text-align: left;
  font-weight: bold;
  margin-bottom: 5px;
}

.form-container {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.input-search {
  width: 100%;
  padding: 12px;
  border: 2px solid #000;
  border-radius: 8px;
  box-sizing: border-box;
}

.divider {
  border: 0;
  border-top: 2px solid #000;
  margin: 10px 0;
}

.input-row {
  display: flex;
  gap: 10px;
}

.input-half {
  flex: 1;
  padding: 12px;
  border-radius: 8px;
  border: none;
}

.input-full {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  border: none;
}

.readonly {
  background-color: #d9d9d9;
}

.textarea-field {
  height: 80px;
  resize: none;
}

.submit-button {
  background-color: #0061d5;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 10px;
  font-weight: bold;
  cursor: pointer;
  align-self: center;
}

.submit-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>
