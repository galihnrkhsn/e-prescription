<script setup lang="ts">
    import { defineProps } from 'vue';
    import { router } from '@inertiajs/vue3'

    const emit = defineEmits(['close'])
    const props = defineProps<{
        resep: any
    }>()

    function closeModal() {
        emit('close')
    }

    function cetakPDF() {
        window.open(`/resep/${props.resep.resep_id}/print`, '_blank');
    }

</script>
<template>
    <div class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center px-4">
        <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6 overflow-y-auto max-h-[90vh]">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Detail Resep</h2>
                <button @click="$emit('close')" class="text-gray-500 hover:text-red-500 text-sm">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <p class="text-sm"><span class="font-medium text-gray-700">Nama Resep:</span> {{ resep.nama_resep }}</p>
            </div>

            <div v-if="resep.details && resep.details.some((d: any) => d.racikan_id === null)">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Obat Non-Racikan</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border border-gray-200">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                        <th class="px-4 py-2 border-b">Obat</th>
                        <th class="px-4 py-2 border-b">Intruksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="detail in resep.details.filter((d: any) => d.racikan_id === null)"
                            :key="detail.resep_detail_id"
                            class="border-b"
                        >
                            <td class="px-4 py-2">{{ detail.obatalkes?.obatalkes_nama }} (Qty: {{ detail.qty }})</td>
                            <td class="px-4 py-2">{{ detail.signa?.signa_nama }}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>

            </div>
            <div v-if="resep.racikans?.length" class="mt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Obat Racikan</h3>
                <div
                    v-for="racikan in resep.racikans"
                    :key="racikan.racikan_id"
                    class="mb-3 border border-gray-200 rounded p-3"
                >
                    <p class="font-medium text-gray-800 mb-1">{{ racikan.nama_racikan }}</p>
                    <p class="text-xs text-gray-500 mb-2">{{ racikan.signa?.signa_nama }}</p>
                    <ul class="pl-4 text-sm text-gray-600 list-disc">
                        <li
                            v-for="item in racikan.details"
                            :key="item.resep_detail_id"
                        >
                            {{ item.obatalkes?.obatalkes_nama }} - Qty: {{ item.qty }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-2">
                <button @click="$emit('close')" class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300 cursor-pointer">
                Kembali
                </button>
                <button @click="cetakPDF" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700 cursor-pointer">
                Cetak PDF
                </button>
            </div>
        </div>
    </div>
</template>
