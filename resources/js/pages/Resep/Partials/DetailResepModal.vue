<template>
  <div class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center">
    <div class="bg-white p-6 rounded w-full max-w-2xl shadow-md max-h-[90vh] overflow-y-auto">
      <h2 class="text-xl font-bold mb-4">Detail Resep</h2>
      <p><strong>Nama Resep:</strong> {{ resep.nama_resep }}</p>

      <div v-if="resep.details.length">
        <h3 class="font-semibold mt-4">Non Racikan</h3>
        <ul class="list-disc pl-5">
          <li v-for="(detail, index) in resep.details.filter(d => !d.is_racikan)" :key="index">
            {{ detail.obatalkes.obatalkes_nama }} (Qty: {{ detail.qty }}) - Signa: {{ detail.signa.signa_nama }}
          </li>
        </ul>
      </div>

      <div v-if="resep.racikans.length">
        <h3 class="font-semibold mt-4">Racikan</h3>
        <div v-for="(racikan, index) in resep.racikans" :key="index" class="mb-2">
          <strong>{{ racikan.nama_racikan }} - Signa: {{ racikan.signa.signa_nama }}</strong>
          <ul class="list-disc pl-5">
            <li v-for="item in racikan.items" :key="item.obatalkes_id">
              {{ item.obatalkes.obatalkes_nama }} (Qty: {{ item.qty }})
            </li>
          </ul>
        </div>
      </div>

      <div class="text-right mt-4">
        <button @click="$emit('close')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
    defineProps<{
    resep: any
    }>()
</script>
