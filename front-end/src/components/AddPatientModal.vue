<template>
  <div class="modal-overlay">
    <div class="modal-content">
      <button class="close-x" @click="$emit('close')">X</button>

      <h2 class="modal-title">TAMBAH PASIEN</h2>

      <div class="form-container">
        <input
          type="text"
          placeholder="No. Rekam Medik (Otomatis)"
          class="input-full readonly-input"
          readonly
        />

        <div class="input-row">
          <input v-model="name" placeholder="Nama Pasien" class="input-half" />
          <input v-model="nik" placeholder="NIK" class="input-half" />
        </div>

        <input
          v-model="email"
          placeholder="Email"
          class="input-full"
        />

        <textarea
          v-model="address"
          placeholder="Alamat"
          class="input-full textarea-field"
        ></textarea>

        <p v-if="error" style="color:red">{{ error }}</p>

        <button @click="save" class="save-button">SIMPAN</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '../api/api'

const emit = defineEmits(['saved', 'close'])

const name = ref('')
const nik = ref('')
const email = ref('')
const address = ref('')
const error = ref('')

const save = async () => {
  error.value = ''

  if (!name.value || !nik.value || !email.value || !address.value) {
    error.value = 'Semua field wajib diisi'
    return
  }

  try {
    await api.post('/patients', {
      name: name.value,
      nik: nik.value,
      email: email.value,
      address: address.value
    })

    emit('saved')  // refresh table
    emit('close')  // tutup modal
  } catch (err) {
    error.value =
      err.response?.data?.message ||
      'Gagal menyimpan pasien'
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
  width: 500px;
  position: relative;
  text-align: center;
}

.close-x {
  position: absolute;
  top: 20px;
  right: 25px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
}

.input-row {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
}

.input-half, .input-full {
  border: 2px solid #000;
  border-radius: 10px;
  padding: 12px;
  outline: none;
}

.input-half { flex: 1; }
.input-full { width: 100%; margin-bottom: 15px; }

.readonly-input { background-color: #d9d9d9; border: none; }

.textarea-field { height: 100px; resize: none; }

.save-button {
  background-color: #0061d5;
  color: white;
  border: none;
  padding: 12px 40px;
  border-radius: 10px;
  font-weight: bold;
  cursor: pointer;
}
</style>
